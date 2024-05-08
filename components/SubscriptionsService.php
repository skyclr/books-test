<?php

namespace app\components;

use app\models\Subscription;
use interfaces\INotificationService;
use yii\base\Component;

class SubscriptionsService extends Component implements \interfaces\ISubscriptionsService
{
    private INotificationService $notificationService;

    public function __construct(INotificationService $notificationService, $config = [])
    {
        $this->notificationService = $notificationService;
        parent::__construct($config);
    }

    /**
     * Should be moved to background, but not in this realization
     * @param \app\models\Book $book
     * @return void
     */
    public function sendBookArrivalNotification(\app\models\Book $book)
    {
        $query = Subscription::find()
            ->where(['bookId' => $book])
            ->with(['book']);
        
        /** @var Subscription $subscription */
        foreach($query->batch(500) as $subscription)
        {
            $this->notificationService->sendPhoneNotification($subscription->phone, "Book \"{$subscription->book->name}\" you was waiting for is arrived!");
        }
    }
}
