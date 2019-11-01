<?php

namespace App\Classes;

use AfricasTalking\SDK\AfricasTalking;

class SendMessage
{

    public static function sendMessage($recipients, $message,$recipient_type,$recipient_ids)
    {

        if($recipient_type=="parent"){

            SaveMessage::saveParentMessageSent($recipient_ids,$message);            
        } else if($recipient_type=="user"){

            SaveMessage::saveUserMessageSent($recipient_ids,$message);
        }

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
}
