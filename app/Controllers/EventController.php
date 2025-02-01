<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Auth;
use App\Helpers\Session;
use App\Repositories\EventRepository;
use App\Requests\EventRequest;

class EventController extends BaseController
{
    public function __construct(private EventRepository $eventRepo) {}

    public function index(Request $request)
    {
        // $data = $this->eventRepo->paginate($request->get());
        // dd($data);
        return Response::view('Event/Index');
    }

    public function eventPaginationAPI(Request $request)
    {
        $data = $this->eventRepo->paginate($request->get());

        return Response::json($data);
    }

    public function create()
    {
        return Response::view('Event/Create');
    }

    public function save(EventRequest $request)
    {
        if (!$request->isValid()) {
            throw new ValidationException($request->errors, $request->post());
        }

        $data = [
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'max_capacity' => (int)$request->post('max_capacity'),
            'start_time' => date("Y-m-d H:i:s", strtotime($request->post('start_time'))),
            'end_time' => date("Y-m-d H:i:s", strtotime($request->post('end_time'))),
            'created_by' => Auth::id()
        ];

        $this->eventRepo->create($data);

        Session::setSuccess("Event created successfully");

        return Response::redirect('/events');
    }
}
