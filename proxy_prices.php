<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: max-age=5');

// Use multiple free forex APIs for real-time data
$apis = [
    'exchangerate' => 'https://api.exchangerate-api.com/v4/latest/USD',
    'frankfurter' => 'https://api.frankfurter.app/latest?from=USD',
];

$data = null;
foreach ($apis as $name => $url) {
    $raw = false;
    
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 SkyTrade/1.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $raw = curl_exec($ch);
        curl_close($ch);
    }

    if (!$raw) {
        $ctx = stream_context_create(['http' => [
            'timeout' => 5, 'method' => 'GET',
            'header'  => "User-Agent: Mozilla/5.0 SkyTrade/1.0\r\n",
        ]]);
        $raw = @file_get_contents($url, false, $ctx);
    }

    if ($raw) {
        $decoded = json_decode($raw, true);
        if (isset($decoded['rates'])) {
            $data = $decoded;
            $data['source'] = $name;
            break;
        }
    }
}

// Fallback data if all APIs fail
if (!$data) {
    echo json_encode([
        'base' => 'USD',
        'source' => 'fallback',
        'date' => date('Y-m-d'),
        'rates' => [
            'EUR'=>0.9217,'GBP'=>0.7854,'JPY'=>157.50,'CHF'=>0.8980,
            'CAD'=>1.3620,'AUD'=>1.5244,'NZD'=>1.6584,'SGD'=>1.3480,
            'HKD'=>7.8200,'MXN'=>18.450,'THB'=>36.200,
        ]
    ]);
} else {
    echo json_encode($data);
}