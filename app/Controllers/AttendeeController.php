<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Session;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use App\Requests\EventRegistrationRequest;

class AttendeeController extends BaseController
{
    public function __construct(private EventRepository $eventRepo, private AttendeeRepository $attendeeRepo) {}

    public function index(int $eventId)
    {
        $event = $this->eventRepo->findOne($eventId, 'id', ['*'], true);

        return Response::view('Attendee/Index', ['event' => $event]);
    }

    public function download(int $eventId)
    {
        $attendees = $this->attendeeRepo->getAll($eventId);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendees.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        fputcsv($output, ["id", "Name", "Email", "Created At"]);

        foreach ($attendees as $attendee) {
            $data = [
                "id" => $attendee['id'],
                "name" => $attendee['name'],
                "email" => $attendee['email'],
                "created_at" => $attendee['created_at'],
            ];
            fputcsv($output, $data);
        }

        fclose($output);
        exit;
    }

    public function create(int $eventId)
    {
        $event = $this->eventRepo->findOne($eventId, 'id', ['*'], true);

        return Response::view('Attendee/Create', ['event' => $event]);
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

        Session::setSuccess("Registration successfull");

        return Response::refresh();
    }

    public function delete(int $eventId, int $id)
    {
        $this->attendeeRepo->delete($eventId, $id);

        Session::setSuccess("Attendee deleted successfully");

        return Response::refresh();
    }
}
