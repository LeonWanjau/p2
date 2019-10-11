<?php

namespace App\Http\Controllers\Project\Teachers;

use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ScheduleController extends Controller
{

    public function index(Request $request)
    {
        $events = new Event();

        $from = $request->from;
        $to = $request->to;

        return response()->json([
            "data" => $events->where("start_date", "<", $to)->where("end_date", ">=", $from)->get()
        ]);
    }

    public function store(Request $request)
    {

        $event = new Event();

        $event->text = strip_tags($request->text);
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->rec_type = $request->rec_type;
        $event->event_length = $request->event_length;
        $event->event_pid = $request->event_pid;
        $event->teacher_id = 8;
        $event->save();

        $status = "inserted";
        if ($event->rec_type == "none") {
            $status = "deleted";
        }

        return response()->json([
            "action" => "inserted",
            "tid" => $event->id
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->text = strip_tags($request->text);
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->rec_type = $request->rec_type;
        $event->event_length = $request->event_length;
        $event->event_pid = $request->event_pid;
        $event->save();

        $this->deleteRelated($event);

        return response()->json([
            "action" => "updated"
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        // delete the modified instance of the recurring series
        if ($event->event_pid) {
            $event->rec_type = "none";
            $event->save();
        } else {
            // delete a regular instance
            $event->delete();
        }

        $this->deleteRelated($event);

        return response()->json([
            "action" => "deleted"
        ]);
    }

    private function deleteRelated($event)
    {
        if ($event->event_pid && $event->event_pid !== "none") {
            Event::where("event_pid", $event->id)->delete();
        }
        
    }
}
