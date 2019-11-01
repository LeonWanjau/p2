<?php

namespace App\Http\Controllers\Project\Messages;

use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DHTMLX_Scheduler\Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\ProjectModels\ParentMessageReceived;
use App\ProjectModels\StudentParent;
use App\Classes\HandleMeetTeacher;
use App\Classes\SaveMessage;



class HandleMessagesController extends Controller
{

    public function receiveMessage(Request $request)
    {

        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.wit.ai/message', [
                'headers' => [
                    'Authorization' => 'Bearer ULL6S6AGXVJMPMXY2HLFHAWA7Z7QHF2V',
                    'Accept' => 'application/vnd.wit.20170307+json'
                ],
                'query' => [
                    'q' => $request['text'],
                    'msg_id' => $request['id']
                ]
            ]);

            $data_obj = json_decode($response->getBody());
            //dd($data_obj);

            $message = new ParentMessageReceived();

            $country_code = "+254";
            $phone_no = $request['from'];
            $trimmed_no = "0" . preg_replace("/^\+?{$country_code}/", '', $phone_no);

            $parent = StudentParent::where('phone_number', $trimmed_no)->first();

            if ($parent == null) {
                return "parent not found";
            }

            $message->msg_id = $request['id'];
            $message->message = $request['text'];
            $message->parent_id = $parent->id;
            $message->date_received = $request['date'];

            if (
                $data_obj != null && $data_obj->entities->intent[0]->value != null &&
                $data_obj->entities->intent[0]->confidence >= 0.8
            ) {
                $intent = $data_obj->entities->intent[0]->value;

                switch ($intent) {
                    case "meet teacher":
                        HandleMeetTeacher::handleMeetTeacher($data_obj, $request, $parent);
                        $message->intent = "meet_teacher";
                        break;
                }

                SaveMessage::saveParentMessageReceived(
                    $request['id'],
                    $request['text'],
                    $parent->id,
                    $request['date'],
                    $intent
                );
                return "";
            } else {

                $intent="unclassified";
                SaveMessage::saveParentMessageReceived(
                    $request['id'],
                    $request['text'],
                    $parent->id,
                    $request['date'],
                    $intent
                );
                return "";
            }
        } catch (Exception $e) {

            echo $e;
            return "";
        }
    }

    /*    
    public function sendMessage($recipients, $message)
    {
        $username = "sandbox";
        $api_key = "dd86d544f4930a538f1df27d523b92b250d53427b65b832af80ffe73ca019d04";

        $AT = new AfricasTalking($username, $api_key);

        $sms = $AT->sms();

        $from = "54544";

        try {

            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message,
                'from'    => $from
            ]);
        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();
        }
    }
*/
    /*
    public function handleMeetTeacher($data_obj, $request,$parent)
    {

        if ($data_obj->entities->datetime[0] != null) {

            $datetime_obj = $data_obj->entities->datetime[0];

            if ($datetime_obj->type == "interval") {

                $start_time = Carbon::create($datetime_obj->from->value)->format("Y-m-d H:i:s");

                if ($datetime_obj->to->grain == "hour") {

                    $end_time = Carbon::create($datetime_obj->to->value)->subHour()->format("Y-m-d H:i:s");
                } else if ($datetime_obj->to->grain == "minute") {

                    $end_time = Carbon::create($datetime_obj->to->value)->subMinute()->format("Y-m-d H:i:s");
                }
            } else if ($datetime_obj->type == "value") {

                $start_time = Carbon::create($datetime_obj->value)->format("Y-m-d H:i:s");
                $end_time = Carbon::create($datetime_obj->value)->addHour()->format("Y-m-d H:i:s");
            }

            $start_of_day=Carbon::create($start_time);
            $start_of_day->hour=8;
            $start_of_day->minute=0;
            $start_of_day->second=0;

            $end_of_day=Carbon::create($end_time);
            $end_of_day->hour=18;
            $end_of_day->minute=0;
            $end_of_day->second=0;;
            
            if(Carbon::create($start_time)->equalTo(Carbon::create($start_time)->startOfDay())){
                echo "Please specify a time for the meeting";
                return "";
            }else if($start_of_day->greaterThan(Carbon::create($start_time))){
                echo "Please specify a starting time at or greater than 8am";
                return "";
            }else if($end_of_day->lessThan(Carbon::create($end_time))){
                echo "The teacher will not be available after 6pm";
                return "";
            }

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

            $events = $events->filter(function ($event, $key) {
                return ($event->rec_type == null);
            });

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

                if (empty($recurring_events)) {

                    echo "teacher free";
                } else {

                    foreach ($recurring_events as $recurring_event) {

                        $uncaptured_events = Event::where('event_pid', $recurring_event['id'])
                            ->where('start_date', '>=', Carbon::create($start_time)->startOfDay()->format("Y-m-d H:i:s"))
                            ->where('end_date', '<=', Carbon::create($end_time)->endOfDay()->format("Y-m-d H:i:s"))
                            ->get();

                        if (empty($uncaptured_events)) {

                            //return
                            echo "teacher not free uncaptured";
                        } else {

                            echo "teacher free uncaptured";
                        }
                    }
                }
            } else {
                echo $events;
                echo "teacher not free";
            }
        }
    }
*/
    public function saveEvent()
    { }
}
