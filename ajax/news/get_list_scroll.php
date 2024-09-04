<?php
include dirname(__DIR__, 2).'/config.php';
$limit = 10; // Количество новостей на одной странице
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, title, date_published FROM news ORDER BY date_published DESC LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div>
    <ul id="news-list">

    </ul>
</div>
<button id="btn-more" class="btn" onclick="loadNews()">Więcej</button>

<script>
let page = 1;
const limit = 10;
let endOfNews = false;

function loadNews() {
    if (endOfNews) return;

    fetch(`load_more.php?page=${page}&limit=${limit}`)
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "END") {
                endOfNews = true;
                document.getElementById('btn-more').remove();
                document.getElementById('news-list').innerHTML += "<p>Nie ma więcej nowości.</p>";
            } else {
                document.getElementById('news-list').innerHTML += data;

                // Проверка, достаточно ли контента на экране
                if (document.body.scrollHeight <= window.innerHeight) {
                page++;
                loadNews();  // Загрузка дополнительного контента, если нужно
                }
            }
        })
    }

// Изначальная загрузка
document.addEventListener('DOMContentLoaded', function() {
    loadNews();
});

// Загрузка при прокрутке
window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        page++;
        loadNews();
    }
};
</script>