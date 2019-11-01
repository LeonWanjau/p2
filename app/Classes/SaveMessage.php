<?php

namespace App\Classes;

use App\ProjectModels\ParentMessageSent;
use App\ProjectModels\ParentMessageReceived;
use App\ProjectModels\UserMessageSent;
use Illuminate\Support\Facades\DB;

class SaveMessage
{

    public static function saveUserMessageSent($user_ids, $text)
    {

        $message = new UserMessageSent();
        $message->message = $text;
        $message->save();

        foreach ($user_ids as $user_id) {
            DB::table('users_to_messages_sent')->insert([
                'user_id' => $user_id,
                'message_id' => $message->id
            ]);
        }
    }

    public static function saveParentMessageReceived($msg_id, $msg, $parent_id, $date_received, $intent)
    {

        $message = new ParentMessageReceived();
        $message->msg_id = $msg_id;
        $message->message = $msg;
        $message->parent_id = $parent_id;
        $message->date_received = $date_received;
        $message->intent = $intent;

        $message->save();
    }

    public static function saveParentMessageSent($parent_ids, $msg)
    {

        $message = new ParentMessageSent();
        $message->message = $msg;
        $message->save();

        foreach ($parent_ids as $parent_id) {
            DB::table('parents_to_messages_sent')->insert([
                'parent_id' => $parent_id,
                'message_id' => $message->id
            ]);
        }
    }
}
