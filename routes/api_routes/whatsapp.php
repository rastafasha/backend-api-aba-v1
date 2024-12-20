<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$accessToken = 'XXXXXX';

        $fbApiUrl = 'https://graph.facebook.com/v17.0/XXXXXXXXXXXXXXXXX/messages';

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => 'xxxxxxxxxxxxxxx',
            'type' => 'template',
            'template' => [
                'name' => 'recordatorio',
                'language' => [
                    'code' => 'es_MX',
                ],
                "components" =>  [
                    [
                        "type" =>  "header",
                        "parameters" =>  [
                            [
                                "type" =>  "text",
                                "text" =>  "JOSE CODE"
                            ]
                        ]
                    ],
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" =>  "1PM"
                            ],
                            [
                                "type" => "text",
                                "text" =>  "DAVID DOCTOR"
                            ],
                        ]
                    ],
                ],
            ],
        ];

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $ch = curl_init($fbApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        echo "HTTP Code: $httpCode\n";
        echo "Response:\n$response\n";
