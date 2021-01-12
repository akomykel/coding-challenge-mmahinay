<?php
namespace App\Repositories;

use App\Models\Eevent;

class EventRepository implements EventInterface
{
    public function createEvent($request) {
        $event = Eevent::firstOrNew(['event_title' => $request->eventTitle]);
        $event->event_date_from = $request->eventDateFrom;
        $event->event_date_to = $request->eventDateTo;
        $event->event_days = implode(',',$request->eventDays);
        $event->save();
        return $event;
    }

    public function listEvents() {
        $events = Eevent::all();
        return $events;
    }
}