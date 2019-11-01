<?php

namespace App\Http\Controllers\Project\Messages;

use App\Http\Controllers\Controller;
use App\ProjectModels\UserMessageSent;
use App\ProjectModels\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeachersMessagesSentController extends Controller
{

    public function showViewTeachersMessagesSent()
    {

        return view('project_views.messages.view_teachers_messages_sent');
    }

    public function returnAllMessages()
    {

        $messages = DB::table('users_to_messages_sent')
            ->join('users', 'users.id', '=', 'users_to_messages_sent.user_id')
            ->join('users_messages_sent', 'users_messages_sent.id', '=', 'users_to_messages_sent.message_id')
            ->where('users.role_id', 1)
            ->select('users_messages_sent.id', 'users_messages_sent.message')
            ->get();

        return response()->json([
            'data' => $messages
        ]);
    }

    public function action(Request $request)
    {

        if ($request['action'] == 'remove') {
            return $this->delete(array_values($request['data'])[0]);
        }
    }

    public function delete($data)
    {

        $message = UserMessageSent::find($data['id']);
        $message->delete();

        return response()->json([]);
    }

    public function returnTeachersToMessages(Request $request){

        $teachers= DB::table('users_to_messages_sent')
         ->join('users','users.id','=','users_to_messages_sent.user_id')
         ->where('message_id',$request['id'])
         ->select('users.id','users.f_name','users.l_name')
         ->get();
 
         return response()->json([
             'data'=>$teachers
         ]);
     }
}
