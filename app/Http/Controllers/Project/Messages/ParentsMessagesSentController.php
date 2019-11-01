<?php

namespace App\Http\Controllers\Project\Messages;

use App\Http\Controllers\Controller;
use App\ProjectModels\ParentMessageSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ParentsMessagesSentController extends Controller
{

    public function showViewParentsMessagesSent()
    {

        return view('project_views.messages.view_parents_messages_sent');
    }

    public function returnAllSentMessages()
    {

        $messages = ParentMessageSent::all();

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

        $message = ParentMessageSent::find($data['id']);
        $message->delete();

        return response()->json([]);
    }

    public function returnParentsToMessages(Request $request){

       $parents= DB::table('parents_to_messages_sent')
        ->join('parents','parents.id','=','parents_to_messages_sent.parent_id')
        ->where('message_id',$request['id'])
        ->select('parents.id','parents.f_name','parents.l_name')
        ->get();

        return response()->json([
            'data'=>$parents
        ]);
    }
}
