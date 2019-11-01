<?php

namespace App\Http\Controllers\Project\Messages;

use App\Http\Controllers\Controller;
use App\ProjectModels\ParentMessageReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ParentsMessagesReceivedController extends Controller
{

    public function showViewParentsMessagesReceived()
    {
        return view('project_views.messages.view_parents_messages_received');
    }

    public function returnAllReceivedMessages()
    {
        $messages = DB::table('parents_messages_received')
            ->join('parents', 'parents.id', '=', 'parents_messages_received.parent_id')
            ->select('parents_messages_received.*', 'parents.phone_number')
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
        $message = ParentMessageReceived::find($data['id']);
        $message->delete();

        return response()->json([]);
    }
}
