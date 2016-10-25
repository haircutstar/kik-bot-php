KIK Messenger Bot PHP API
=========================

This is Bot API implementation for KIK Messenger. 

To create start create echo.php

  $bot = new KikApi("Bot name", "bot api key");
  $bot->setConfiguration('http://url:port/kik/echo.php');
  

Each incoming message is signed to make sure kik is sending it. To validate the message is coming from kik use validateMessageSignature method.

if(isNull($inputData) || !$bot->validateMessageSignature($inputData)){
   header('HTTP/1.0 403 Forbidden');
   return;
}

Full example of echo bot is included
