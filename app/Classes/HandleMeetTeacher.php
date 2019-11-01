<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Event;
use DHTMLX_Scheduler\Helper;
use App\ProjectModels\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HandleMeetTeacher
{

    public static function handleMeetTeacher($data_obj, $request, $parent)
    {
        //Check if data contains teacher
        if (isset($data_obj->entities->teacher_name)) {

            $teacher_name_arr = $data_obj->entities->teacher_name;

            //Check if more than one teacher is specified
            if (sizeof($teacher_name_arr) > 1) {

                SendMessage::sendMessage($request['from'], 'Please specify one teacher', "parent", [$parent->id]);
                return "";

                //Only one teacher specified
            } else {

                $replace_values = ['Mr.', 'Mrs.', 'Mr', 'Mrs'];
                $teacher_name = str_replace($replace_values, "", $teacher_name_arr[0]->value);

                $teacher = User::where('role_id', 1)
                    ->where('f_name', $teacher_name)
                    ->orwhere('l_name', $teacher_name)
                    ->get();

                //Check if teacher exists in the database
                if ($teacher == null) {

                    SendMessage::sendMessage($request['from'], 'That teacher was not found in the system', "parent", [$parent->id]);
                    return "";

                    //Check if there is more than one teacher in the database with the specified name
                } else if ($teacher->count() > 1) {

                    SendMessage::sendMessage($request['from'], 'Could you please specify a second name for the teacher', "parent", [$parent->id]);
                    return "";

                    //Set teacher to the one found teacher collection
                } else {

                    $teacher = $teacher->first();
                }
            }

            //More than one teacher specified
        } else {

            SendMessage::sendMessage($request['from'], 'Please specify a teacher you would like to meet with', "parent", [$parent->id]);
            return "";
        }

        //Check if datetime is present
        if ($data_obj->entities->datetime[0] != null) {

            $datetime_obj = $data_obj->entities->datetime[0];

            //Check if an interval is specified
            if ($datetime_obj->type == "interval") {

                $start_time = Carbon::create($datetime_obj->from->value)->format("Y-m-d H:i:s");

                //Check if the grain is hour
                if ($datetime_obj->to->grain == "hour") {

                    $end_time = Carbon::create($datetime_obj->to->value)->subHour()->format("Y-m-d H:i:s");

                    //Check if the grain is minute
                } else if ($datetime_obj->to->grain == "minute") {

                    $end_time = Carbon::create($datetime_obj->to->value)->subMinute()->format("Y-m-d H:i:s");
                }

                //Check if only a value was specified instead of an interval
            } else if ($datetime_obj->type == "value") {

                $start_time = Carbon::create($datetime_obj->value)->format("Y-m-d H:i:s");
                $end_time = Carbon::create($datetime_obj->value)->addHour()->format("Y-m-d H:i:s");
            }

            $start_of_day = Carbon::create($start_time);
            $start_of_day->hour = 8;
            $start_of_day->minute = 0;
            $start_of_day->second = 0;

            $end_of_day = Carbon::create($end_time);
            $end_of_day->hour = 18;
            $end_of_day->minute = 0;
            $end_of_day->second = 0;

            //Check if start time is set to 12am
            if (Carbon::create($start_time)->equalTo(Carbon::create($start_time)->startOfDay())) {

                SendMessage::sendMessage($request['from'], "Please specify a time for the meeting", "parent", [$parent->id]);
                return "";

                //Check if start time is before the start of the day
            } else if ($start_of_day->greaterThan(Carbon::create($start_time))) {

                SendMessage::sendMessage($request['from'], "The earliest start time for a meeting is 8am", "parent", [$parent->id]);
                return "";

                //Check if end time is after the end of the day
            } else if ($end_of_day->lessThan(Carbon::create($end_time))) {

                SendMessage::sendMessage($request['from'], "The teacher will not be available after 6pm", "parent", [$parent->id]);
                return "";
            }

            //Check if start time is in the past

            $now = Carbon::now('Africa/Nairobi');

            if (Carbon::create($start_time)->lessThan($now)) {

                SendMessage::sendMessage($request['from'], "Please specify a start time that isn't in the past", "parent", [$parent->id]);
                return "";
            }
            
            //Check if day is Sunday
            if(Carbon::create($start_time)->dayOfWeek==0){
                
                SendMessage::sendMessage($request['from'], "The teacher isn't available on Sunday", "parent", [$parent->id]);
                return "";
            }

            $events = Event::where(function ($query) use ($start_time, $end_time) {
                $query->where('start_date', "<=", $start_time)
                    ->where("end_date", ">=", $end_time);
            })
                ->orWhere(function ($query) use ($start_time, $end_time) {
                    $query->where('start_date', "<=", $start_time)
                        ->where('end_date', '>=', $start_time)
                        ->where('end_date', '<=', $end_time);
                })
                ->orWhere(function ($query) use ($start_time, $end_time) {
                    $query->where('start_date', '>=', $start_time)
                        ->where('start_date', '<=', $end_time)
                        ->where('end_date', '>=', $end_time);
                })
                ->orWhere(function ($query) use ($start_time, $end_time) {
                    $query->where('start_date', '>=', $start_time)
                        ->where('end_date', '<=', $end_time);
                })
                ->get();

            $events = $events->filter(function ($event, $key) {
                return ($event->rec_type == null);
            });

            //Check for recurring events
            if ($events->isEmpty()) {

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

                $recurring_events = $helper->getData($start_time, $end_time);

                //No recurring events, teacher is free
                if (empty($recurring_events)) {

                    HandleMeetTeacher::saveEvent($request, $start_time, $end_time, $teacher, $parent);
                    SendMessage::sendMessage($request['from'], "The meeting has been scheduled with the teacher", "parent", [$parent->id]);
                    return "";

                    //Recurring event detected
                } else {

                    //Check for uncaptured modified recurring events
                    foreach ($recurring_events as $recurring_event) {

                        $uncaptured_events = Event::where('event_pid', $recurring_event['id'])
                            ->where('start_date', '>=', Carbon::create($start_time)->startOfDay()->format("Y-m-d H:i:s"))
                            ->where('end_date', '<=', Carbon::create($end_time)->endOfDay()->format("Y-m-d H:i:s"))
                            ->get();

                        //No modified recurring events, teacher isn't free
                        if ($uncaptured_events->isEmpty()) {

                            SendMessage::sendMessage($request['from'], "The teacher isn't free at that time", "parent", [$parent->id]);
                            return "";

                            //Modified recurring events detected, teacher is free
                        } else {

                            HandleMeetTeacher::saveEvent($request, $start_time, $end_time, $teacher, $parent);
                            SendMessage::sendMessage($request['from'], "The meeting has been scheduled with the teacher", "parent", [$parent->id]);
                            return "";
                        }
                    }
                }

                //Event detected, teacher isn't free
            } else {

                SendMessage::sendMessage($request['from'], "The teacher isn't free at that time", "parent", [$parent->id]);
                return "";
            }
        }
    }

    public static function saveEvent($request, $start_time, $end_time, $teacher, $parent)
    {

        $event = new Event();

        $carbon_start_time = Carbon::create($start_time);
        $carbon_end_time = Carbon::create($end_time);
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

        //Get parent prefix
        if (strtolower($parent->role) == 'father') {

            $parent_prefix = "Mr.";
        } else if (strtolower($parent->role) == 'mother') {

            $parent_prefix = "Mrs.";
        }

        $start_minute = $carbon_start_time->minute < 10 ? "0" . $carbon_start_time->minute : $carbon_start_time->minute;
        $end_minute = $carbon_end_time->minute < 10 ? "0" . $carbon_end_time->minute : $carbon_end_time->minute;

        $event_text = "Meet with " . $parent_prefix . $parent->l_name . " at "
            . $carbon_start_time->hour . ":" . $start_minute
            . " to "
            . $carbon_end_time->hour . ":" . $end_minute;

        $event->teacher_id = $teacher->id;
        $event->text = $event_text;
        $event->start_date = $start_time;
        $event->end_date = $end_time;
        $event->parent_id = $parent->id;
        $event->save();

        $country_code = "+254";
        $phone_no = $country_code . ltrim($teacher->phone_number, $teacher->phone_number[0]);

        $sms_event_text = "Meeting with " . $parent_prefix . $parent->l_name
            . " on "
            . $carbon_start_time->day . "/" . $carbon_start_time->month . "/" . $carbon_start_time->year
            . " from "
            . $carbon_start_time->hour . ":" . $start_minute
            . " to "
            . $carbon_end_time->hour . ":" . $end_minute
            . " has been scheduled";

        //Send message to teacher
        SendMessage::sendMessage($phone_no, $sms_event_text, "user", [$teacher->id]);
    }
}
