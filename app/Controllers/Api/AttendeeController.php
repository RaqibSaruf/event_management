<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use App\Requests\EventRegistrationRequest;

class AttendeeController extends BaseController
{
    public function __construct(private EventRepository $eventRepo, private AttendeeRepository $attendeeRepo) {}

    public function pagination(Request $request, int $eventId)
    {
        $filters = [
            ...$request->get(),
            'event_id' => $eventId
        ];
        $data = $this->attendeeRepo->paginate($filters, false);

        return Response::json($data);
    }


    public function save(EventRegistrationRequest $request, int $eventId)
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

        return Response::json([
            'statusCode' => 201,
            'message' => 'Registration successfull'
        ]);
    }
}
