<?php

namespace App\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;

class LineBotService extends LINEBot
{
    /** @var string */
    private $channelSecret;
    /** @var HTTPClient */
    private $httpClient;

    public function __construct(
        HTTPClient $httpClient,
        array $args
    ) {
        parent::__construct($httpClient, $args);
        $this->httpClient = $httpClient;
        $this->channelSecret = $args['channelSecret'];
    }

    //送信されたメッセージを取得するAPI
    public function getMessageContent($messageId)
    {
        return $this->httpClient->get('https://api-data.line.me/v2/bot/message/' . urlencode($messageId) . '/content');
    }
}
