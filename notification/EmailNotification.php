<?php
class EmailNotification implements NotificationInterface {
    public function send($recipient, $message) {
        //This would send an email
        return "Email sent to $recipient: $message";
    }
}