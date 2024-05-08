<?php

namespace app\interfaces;

interface INotificationService
{
    public function sendPhoneNotification($phone, $message);
}
