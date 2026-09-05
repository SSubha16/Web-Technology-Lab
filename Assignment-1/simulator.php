<?php

// Tell browser that this is a Server-Sent Events stream
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Prevent PHP from stopping the script
set_time_limit(0);

// Initial values
$temperature = 25.0;
$humidity = 60.0;

while (true) {

    // Generate small random changes
    $temperature += (rand(-10, 10) / 10);
    $humidity += (rand(-20, 20) / 10);

    // Keep values within realistic limits
    $temperature = max(15, min(40, $temperature));
    $humidity = max(30, min(90, $humidity));

    // Current date and time
    $dateTime = date('Y-m-d H:i:s');

    // Data to send to client
    $data = [
        'datetime' => $dateTime,
        'temperature' => round($temperature, 2),
        'humidity' => round($humidity, 2)
    ];

    // Send data using SSE format
    echo "data: " . json_encode($data) . "\n\n";

    // Force data to be sent immediately
    ob_flush();
    flush();

    // Wait for 1 second
    sleep(1);
}
?>
