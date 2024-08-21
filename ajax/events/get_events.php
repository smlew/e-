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
        'description'   => $row['description'],   
        // 'rrule'         => ['freq' => 'NULL', 'byweekday' => 'NULL']
    ];

    if (!empty($row['recurrence'])) {
        $recurrenceParts = explode(',', $row['recurrence']);
        $freq = $recurrenceParts[0]; // "WEEKLY"
        $byweekday = array_slice($recurrenceParts, 1); // ["MO", "TH"]

        $event['rrule'] = [
            'freq' => strtolower($freq),
            'byweekday' => array_map('strtolower', $byweekday)
        ];

        
    }

    $events[] = $event;
}

echo json_encode($events);

?>
