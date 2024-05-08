<?php

use app\interfaces\INotificationService;
use GuzzleHttp\Client;
use yii\base\Component;

class SmsPilotNotificationService extends Component implements INotificationService
{
    private Client $client;
    public string $apiKey;
    public string $url;

    public function __construct(Client $client, $config = [])
    {
        $this->client = $client;
        parent::__construct($config);
    }

    public function sendPhoneNotification($phone, $message)
    {
        $this->client->get($this->url, [
            'query' => [
                'send' => $message,
                'to' => $phone,
                'apikey' => $this->apiKey,
            ]
        ]);
    }
}
