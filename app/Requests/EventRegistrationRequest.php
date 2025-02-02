<?php

declare(strict_types=1);

namespace App\Requests;

use App\Core\Request;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use App\Requests\Interfaces\MustValidate;

class EventRegistrationRequest extends Request implements MustValidate
{
    public function __construct(private EventRepository $eventRepo, private AttendeeRepository $attendeeRepo, private int $eventId)
    {
        parent::__construct();
    }

    public function isValid(): bool
    {
        return $this->isEventAvailableForRegistration() && $this->isValidName() && $this->isValidEmail();
    }

    private function isEventAvailableForRegistration(): bool
    {
        $event = $this->eventRepo->findOne($this->eventId, 'id', ['*'], true);
        $currentTime = strtotime(date('Y-m-d H:i:s'));
        $startTime = strtotime($event->start_time);
        $endTime = strtotime($event->end_time);

        if ($currentTime < $startTime) {
            $this->errorMsg = "Registration has not started yet.";
            return false;
        } elseif ($currentTime > $endTime) {
            $this->errorMsg = "Registration is closed.";
            return false;
        }

        $totalAttendee = $this->attendeeRepo->countTotalAttendees($event->id);

        if ($event->max_capacity <= $totalAttendee) {
            $this->errorMsg = "Maximum attendee capacity already exists. Please try another event.";
            return false;
        }

        return true;
    }

    private function isValidName(): bool
    {
        $name = trim($this->post('name'));
        if (strlen($name) < 3) {
            $this->errors['name'] = 'Name must be at least 3 characters';
            return false;
        } else if (strlen($name) > 255) {
            $this->errors['name'] = "Name can be max 255 characters";
            return false;
        }

        return true;
    }

    private function isValidEmail(): bool
    {
        $email = trim($this->post('email'));
        if (empty($email)) {
            $this->errors['email'] = 'Email is required';
            return false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please provide a valid email";
            return false;
        } else if (strlen($email) > 255) {
            $this->errors['email'] = "Email can be max 255 characters";
            return false;
        } else if ($this->attendeeRepo->isExist($email, 'email')) {
            $this->errors['email'] = "Already registered";
            $this->errorMsg = "Already registered";
            return false;
        }

        return true;
    }
}
