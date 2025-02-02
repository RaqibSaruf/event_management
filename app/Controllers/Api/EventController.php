<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Auth;
use App\Helpers\Session;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use App\Requests\EventRequest;

class EventController extends BaseController
{
    public function __construct(private EventRepository $eventRepo, private AttendeeRepository $attendeeRepo) {}


    public function adminPagination(Request $request)
    {
        $data = $this->eventRepo->paginate($request->get(), false);

        return Response::json($data);
    }

    public function pagination(Request $request)
    {
        $data = $this->eventRepo->paginate($request->get(), true);

        return Response::json($data);
    }

    public function detail(int $id)
    {
        $event = $this->eventRepo->findOne($id, 'id', ['*'], true);
        $totalAttendees = $this->attendeeRepo->countTotalAttendees($id);

        return Response::json([
            "message" => "Event details for event id: $id",
            "data" => [
                "event" => $event,
                "totalAttendees" => $totalAttendees,
            ]
        ]);
    }
}
