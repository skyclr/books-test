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
        $response = $this->client->get($this->url, [
            'query' => [
                'send' => $message,
                'to' => $phone,
                'apikey' => $this->apiKey,
            ]
        ]);
        
        if($response->getStatusCode() !== 200) {
            throw new \Exception("Cant send sms notification for phone $phone");
        }
        
        $responseJson = json_decode($response->getBody(), true);
        
        if(!empty($responseJson['error'])) {
            throw new \yii\db\Exception("Cant send sms notification for phone: " . $responseJson['error']['description'] ?? 'for unknown reason');
        }
    }
}
