<?php
include dirname(__DIR__, 2).'/config.php';

$limit = (int)$_GET['limit'];
$page = (int)$_GET['page'];
$offset = ($page - 1) * $limit;

$sql = "SELECT id, title, date_published FROM news ORDER BY date_published DESC LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<li><a href="get_article.php?id='.$row['id'].'">'.$row['title'].' - '.date('d-m-Y', strtotime($row['date_published'])).'</a></li>';
    }
} else {
    echo "END";
}
$mysqli->close();
?>