<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = 'bb04e95fee7b5efb74ab0b35c3da006d';
    private $api_key_secret = 'e94286018f9be1b103f0bb5932ecdbec';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mike_theviper@outlook.com",
                        'Name' => "La boutique de mike"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 4005895,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}