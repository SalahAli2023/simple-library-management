<?php
class SMSNotification implements NotificationInterface {
    public function send($recipient, $message) {
        //This send an SMS
        return "SMS sent to $recipient: $message";
    }
}