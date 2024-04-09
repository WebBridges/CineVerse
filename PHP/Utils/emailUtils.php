<?php

function sendEmailMessage($subject, $message, $email){
    $sender = new \SendGrid\Mail\Mail();
    $sender->setFrom("webbridgemail@gmail.com", "noreply");
    $sender->setSubject($subject);
    $sender->addTo($email);
    $sender->addContent("text/html", $message);
    $sendgrid= new \SendGrid(getenv("MailApiKey"));
    $sendgrid->send($sender);
}

?>