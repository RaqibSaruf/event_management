<?php

declare(strict_types=1);

namespace App\Requests;

use App\Core\Request;
use App\Requests\Interfaces\MustValidate;

class EventRequest extends Request implements MustValidate
{
    public function isValid(): bool
    {
        return $this->isValidName() && $this->isValidDescription() && $this->isValidMaxCapacity()
            && $this->isValidStartTime() && $this->isValidEndTime();
    }

    private function isValidName(): bool
    {
        $name = trim($this->post('name'));
        if (strlen($name) < 3) {
            $this->errors["name"] = "Name must be at least 3 characters";
            return false;
        }

        return true;
    }

    private function isValidDescription(): bool
    {
        $description = trim($this->post('description'));
        if (strlen($description) < 60) {
            $this->errors["description"] = "Description must be at least 60 characters";
            return false;
        }

        return true;
    }

    private function isValidMaxCapacity(): bool
    {
        $maxCapacity = trim($this->post('max_capacity'));
        if (empty($maxCapacity)) {
            $this->errors["max_capacity"] = "Max attendee capacity is required";
            return false;
        } elseif (!filter_var($maxCapacity, FILTER_VALIDATE_INT)) {
            $this->errors["max_capacity"] = "Must be a valid positive integer";
            return false;
        }
        return true;
    }
    private function isValidStartTime(): bool
    {
        $startTime = trim($this->post('start_time'));
        if (empty($startTime)) {
            $this->errors["start_time"] = "Start time is required";
            return false;
        } elseif (strtotime($startTime) < time()) {
            $this->errors["start_time"] = "Start time must be in the future";
            return false;
        }
        return true;
    }
    private function isValidEndTime(): bool
    {
        $endTime = trim($this->post('end_time'));
        $startTime = trim($this->post('start_time'));
        if (empty($endTime)) {
            $this->errors["end_time"] = "End time is required";
            return false;
        } elseif (!empty($startTime) && strtotime($endTime) <= strtotime($startTime)) {
            $this->errors["end_time"] = "End time must be after start time";
            return false;
        }
        return true;
    }
}
