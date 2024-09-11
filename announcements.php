<?php
    include 'config.php';
    $limit = 10; // Количество новостей на одной странице
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT id, title, date_published FROM news ORDER BY date_published DESC LIMIT $limit OFFSET $offset";
    $result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogłoszenia</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    include 'nav-bar.php';
?>

<div class="container-xl">
    <h2 class="header-announcement">Ogłoszenia</h2>
    <hr>
    <div class="news-list-class" id="news-list">

    </div>
    <button id="btn-more" class="btn btn-secondary btn-more" type="button" onclick="loadNews()">Więcej</button>
</div>

<?php
    include 'footer.php';
?>

<script>
    let page = 1;
    const limit = 6;
    let endOfNews = false;

    function loadNews() {
        if (endOfNews) return;

            fetch(`ajax/news/load_more.php?page=${page}&limit=${limit}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "END") {
                    endOfNews = true;
                    document.getElementById('btn-more').remove();
                    document.getElementById('news-list').innerHTML += "<p>Nie ma więcej ogłoszeń.</p>";
                } else {
                    document.getElementById('news-list').innerHTML += data;

                    // Проверка, достаточно ли контента на экране
                    if (document.body.scrollHeight <= window.innerHeight) {

                        loadNews();  // Загрузка дополнительного контента, если нужно
                    }
                }
            })
            page++;
    }

    // Изначальная загрузка
    document.addEventListener('DOMContentLoaded', function() {
        loadNews();
    });

    // Загрузка при прокрутке
    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            loadNews();
        }
    };
</script>
<script src="./js/login-script.js"></script>    
</body>
</html>





