<?php
include dirname(__DIR__, 2).'/config.php';

$sql = "
    SELECT
        events.id           AS event_id,
        events.title        AS event_title,
        events.description  AS event_description,
        events.start_date   AS event_start_date,
        events.end_date     AS event_end_date,
        events.recurrence   AS event_recurrence,
        multifamily_residential.block AS block
    FROM
        events
    INNER JOIN multifamily_residential ON events.address_id = multifamily_residential.id
    WHERE
        multifamily_residential.id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param('i', $_SESSION['address_id']);
$stmt->execute();

$resultad = $stmt->get_result();


$events = [];

while ($row = mysqli_fetch_assoc($resultad)) {
    
    $event = [
        'id'            => $row['event_id'],
        'allDay'        => false,
        'hasEnd'        => true,
        'title'         => $row['event_title'],
        'start'         => $row['event_start_date'],
        'end'           => $row['event_end_date'],
        'description'   => $row['event_description'],   
    ];

    if (!empty($row['event_recurrence'])) {
        $recurrenceParts = explode(',', $row['event_recurrence']);
        $freq = $recurrenceParts[0];
        $byweekday = array_slice($recurrenceParts, 1);

        $event['rrule'] = [
            'dtstart' => $row['event_start_date'],
            'freq' => strtolower($freq),
            'byweekday' => array_map('strtolower', $byweekday)
        ];
    }
    
    $events[] = $event;
}

echo json_encode($events);

?>
