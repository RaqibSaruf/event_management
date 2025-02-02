<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Session;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use App\Requests\EventRegistrationRequest;

class AttendeeController extends BaseController
{
    public function __construct(private EventRepository $eventRepo, private AttendeeRepository $attendeeRepo) {}

    public function registerForm(int $eventId)
    {
        $event = $this->eventRepo->findOne($eventId, 'id', ['*'], true);

        return Response::view('AttendeeRegister', ['event' => $event]);
    }

    public function register(EventRegistrationRequest $request, int $eventId)
    {
        if (!$request->isValid()) {
            throw new ValidationException($request->errors, $request->post(), $request->errorMsg);
        }

        $data = [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'event_id' => $eventId,
        ];
        $this->attendeeRepo->create($data);

        Session::setSuccess("Registration successfull");

        return Response::refresh();
    }
}
