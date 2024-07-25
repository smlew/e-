<?php
include dirname(__DIR__, 2).'/config.php';

$sql = "SELECT * FROM events";
$result = $mysqli->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $event = [
        'id'            => $row['id'],
        'title'         => $row['title'],
        'start'         => $row['start_date'],
        'end'           => $row['end_date'],
        'description'   => $row['description']
    ];

    // Check for recurrence
    if (!empty($row['recurrence'])) {
        $event['rrule'] = [
            'freq' => 'weekly',
            'byweekday' => explode(',', substr($row['recurrence'], 8))
        ];
    }

    $events[] = $event;
}

echo json_encode($events);
?>
