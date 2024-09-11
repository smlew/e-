<?php
    include dirname(__DIR__, 2).'/config.php';

    $limit = (int)$_GET['limit'];
    $page = (int)$_GET['page'];
    $offset = ($page - 1) * $limit;

    $sql = "SELECT id, title,

    CASE
        WHEN LENGTH(text) > 128 THEN CONCAT(LEFT(text, 128), '...')
        ELSE text
    END AS text,
    
    date_published, image_path FROM news ORDER BY date_published DESC LIMIT $limit OFFSET $offset";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
                <div class="card mb-3 list-element" style="max-width: 900px;" onclick="location.href='announcement.php?id=<?php echo $row['id'];?>';">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo $row['image_path'];?>" style="max-width: 300px;" class="img-fluid rounded-start" alt="...">
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title'];?></h5>
                                <p class="card-text"><?php echo $row['text'];?></p>
                                <p>
                                    <small class="text-body-secondary">
                                        <?php echo date('d-m-Y', strtotime($row['date_published']))?>
                                    </small>
                                </p>
                            </div>
                        
                        </div>
                    
                    </div>
                </div>
            <?php
        }
    } else {
        echo "END";
    }
    $mysqli->close();
?>