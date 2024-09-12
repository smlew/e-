<?php

include 'config.php';

if (!$_SESSION['logged'] and !isset($_SESSION['user_id'])) {
    header("Location: /index.php");
}

$id = $_GET['id'];

$sql = 'SELECT title, text, image_path, date_published FROM news WHERE id=?';
$stmt = $mysqli -> prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($title, $text, $image_path, $date_published);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Ogłoszenie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .image img {
            max-width: 600px;
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .back-button {
            margin-bottom: 20px;
        }



    </style>
</head>
<body>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="javascript:history.back()" class="btn btn-outline-primary back-button" >
            &larr; Powrtót
        </a>
    </div>

    <h1 class="mb-3"><?php echo $title; ?></h1>
    <p class="text-muted"><?php echo date('d-m-Y H:i', strtotime($date_published)); ?></p>
    
    <?php if ($image_path): ?>
        <div class="text-center image">
            <img src="<?php echo $image_path; ?>" alt="Obraz związany z ogłoszeniem" class="img-fluid">
        </div>
    <?php endif; ?>
    
    <div class="mt-3">
        <?php echo nl2br($text); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
