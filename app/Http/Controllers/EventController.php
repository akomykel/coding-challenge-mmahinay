<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function createEvent(Request $request)
    {
        $result = $this->eventRepository->createEvent($request);
        return response()->json($result);
    }

    public function listEvents()
    {
        $result = $this->eventRepository->listEvents();
        return response()->json($result);
    }
    
}
