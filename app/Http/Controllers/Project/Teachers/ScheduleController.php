<?php

namespace App\Http\Controllers\Project\Teachers;

use App\Http\Controllers\Controller;
use App\Event;
use App\ProjectModels\StudentParent;
use App\ProjectModels\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DHTMLX_Scheduler\Helper;
use GuzzleHttp\Client;
use App\Classes\SendMessage;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function test()
    {
        /*
        $helper = new Helper([
            "db_name" => "is_p2",
            "user" => "root",
            "password" => "",
            "table_name" => "events"
        ]);

        $helper->setFieldsNames([
            $helper::FLD_ID => 'id',
            helper::FLD_START_DATE => "start_date",
            helper::FLD_END_DATE => "end_date",
            helper::FLD_TEXT => "text",
            helper::FLD_RECURRING_TYPE => "rec_type",
            helper::FLD_PARENT_ID => "event_pid",
            helper::FLD_LENGTH => "event_length"

        ]);

        $data = $helper->getData("2018-12-10 03:00:00", "2018-12-17 00:00:00");

        Log::channel('single')->info($data);
        */

        $client = new Client();
        $response = $client->request('GET', 'https://api.wit.ai/message', [
            'headers' => [
                'Authorization' => 'Bearer ULL6S6AGXVJMPMXY2HLFHAWA7Z7QHF2V',
                'Accept' => 'application/vnd.wit.20170307+json'
            ],
            'query' => [
                'q' => 'I would like to meet with Mr.Njoroge on wednesday from 2pm to 3pm'
            ]
        ]);

        //Log::channel('single')->info($response->getBody());
        //dd(json_decode($response->getBody()));
        //return json_decode($response->getBody())->entities->datetime[0]->to->value;

        //2019-10-23T16:00:00.000+03:00

        $carbon = new Carbon(json_decode($response->getBody())->entities->datetime[0]->to->value);
        $end_time = $carbon->subHour()->format("Y-m-d H:i:s");
        $start_time = Carbon::create(json_decode($response->getBody())->entities->datetime[0]->from->value)->format("Y-m-d H:i:s");

        $events = Event::where('start_date', ">=", $start_time)->where("end_date", "<=", $end_time)

            ->orWhere(function ($query) use ($start_time, $end_time) {
                $query->where('start_date', "<=", $start_time)
                    ->where('end_date', '>=', $start_time)
                    ->where('end_date', '<=', $end_time);
            })


            ->orWhere(function ($query) use ($start_time, $end_time) {
                $query->where('start_date', '>=', $start_time)
                    ->where('start_date', '<=', $end_time)
                    ->where('end_date', '>=', $end_time);
            })->get();

        return $events;
        /*
       $data=new \DateTime(json_decode($response->getBody())->entities->datetime[0]->to->value);
       return $data->format('Y-m-d H:i:s');
       */
    }

    public function showViewSchedule()
    {
        return view('project_views.teachers.view_schedule');
    }

    public function index(Request $request)
    {
        //$events = new Event();

        $from = $request->from;
        $to = $request->to;

        $events = Event::where("start_date", "<", $to)->where("end_date", ">=", $from);

        if (Auth::user() != null) {
            $events = $events->where('teacher_id', Auth::user()->id);
        }

        $events = $events->get();

        //Log::channel('single')->info( $events->where("start_date", "<", $to)->where("end_date", ">=", $from)->get());


        return response()->json([
            //"data" => $events->where("start_date", "<", $to)->where("end_date", ">=", $from)->get()
            "data" => $events
        ]);
    }

    public function store(Request $request)
    {

        $event = new Event();

        if (Auth::user() != null) {
            $user = Auth::user();
        } else {
            $user = User::first();
        }

        $event->text = strip_tags($request->text);
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->rec_type = $request->rec_type;
        $event->event_length = $request->event_length;
        $event->event_pid = $request->event_pid;
        $event->teacher_id = $user->id;
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
        if ($request['rec_type'] != "null") {
            $event->rec_type = $request->rec_type;
        }
        if ($request['event_length'] != "null") {
            $event->event_length = $request->event_length;
        }
        if ($request['pid'] != null) {
            $event->event_pid = $request->event_pid;
        }
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

        if ($event->parent_id != null) {
            $carbon_start_time = Carbon::create($event->start_date);
            $carbon_end_time = Carbon::create($event->end_date);

            $start_minute = $carbon_start_time->minute < 10 ? "0" . $carbon_start_time->minute : $carbon_start_time->minute;
            $end_minute = $carbon_end_time->minute < 10 ? "0" . $carbon_end_time->minute : $carbon_end_time->minute;
            $day_of_week = $carbon_start_time->dayOfWeek;

            switch ($day_of_week) {
                case 0:
                    $day_of_week = "Sunday";
                    break;

                case 1:
                    $day_of_week = "Monday";
                    break;

                case 2:
                    $day_of_week = "Tuesday";
                    break;

                case 3:
                    $day_of_week = "Wednesday";
                    break;

                case 4:
                    $day_of_week = "Thursday";
                    break;

                case 5:
                    $day_of_week = "Friday";
                    break;

                case 6:
                    $day_of_week = "Saturday";
                    break;
            }


            $parent = StudentParent::find($event->parent_id);
            $teacher = User::find($event->teacher_id);

            $msg_text = "Your meeting with "
                . $teacher->f_name . " " . $teacher->l_name
                . " on "
                .$carbon_start_time->day."/".$carbon_start_time->month."/".$carbon_start_time->year
                . " from "
                . $carbon_start_time->hour . ":" . $start_minute
                . " to "
                . $carbon_end_time->hour . ":" . $end_minute
                . " has been cancelled";

            $country_code = "+254";
            $phone_no = $country_code . ltrim($parent->phone_number, $parent->phone_number[0]);

            SendMessage::sendMessage($phone_no, $msg_text, "parent", [$parent->id]);
        }

        return response()->json([
            "action" => "deleted"
        ]);
    }

    private function deleteRelated($event)
    {
        /*
        if ($event->event_pid && $event->event_pid !== "none") {
            Event::where("event_pid", $event->id)->delete();
        }
        */

        if ($event->event_pid == null && $event->rec_type !== "none") {
            Event::where("event_pid", $event->id)->delete();
        }
    }
}
