<?php

include_once dirname(__FILE__).'/../bootstrap.php';

use lib\KikApi;
use objects\Message;

function isNull($data) {
    if (!isset($data)) {
        return false;
    }
    switch ($data) {
        case 'unknown': // continue
        case 'undefined': // continue
        case 'null': // continue
        case 'NULL': // continue
        case NULL:
        case null:
            return true;
    }
    return false;
}


$bot = new KikApi("Bot name", "bot api key");
$bot->setConfiguration('http://url:port/kik/echo.php');

$inputJSON = file_get_contents('php://input');
if(isNull($inputJSON) || !$bot->validateMessageSignature($inputJSON)){
   return;
}

$data = json_decode( $inputJSON, true );

foreach ($data['messages'] as $message) {

    switch($message['type']) {

        // When user start chat with bot
        case 'start-chatting':
            sendHelpMessage($bot, $message);
            break;

        // Receive message from user
        default:

               // Send message to user
                    $bot->send(new Message([
                        'type' => Message::TYPE_TEXT,
                        'body' => $message['body'],
                        'to' => $message['from'],
                        'chatId' => $message['chatId'],
                    ]));
    }
}

/**
 * Send help message to Userwith suggested items
 *
 * @param $bot
 * @param $message
 */
function sendHelpMessage($bot, $message)
{
    $bot->send(new Message([
        'type' => Message::TYPE_TEXT,
        'body' => "Please select suggested item.",
        'to' => $message['from'],
        'chatId' => $message['chatId'],
        'keyboards' => [
            [
                'type' => 'suggested',
                'responses' => [
                    [
                        'type' => 'text',
                        'body' => 'Talk back'
                    ]
                ]
            ]
        ]
    ]));
}