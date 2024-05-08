<?php

namespace app\interfaces;

use app\models\Book;

interface ISubscriptionsService
{
    public function sendBookArrivalNotification(Book $book);
}
