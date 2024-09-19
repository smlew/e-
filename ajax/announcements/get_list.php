<?php
include dirname(__DIR__, 2).'/config.php';

$limit = 10; // Количество новостей на одной странице
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, title, date_published FROM announcements ORDER BY date_published DESC LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);
?>

<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <a href="get_article.php?id=<?php echo $row['id']; ?>">
            <?php echo $row['title']; ?> - <?php echo date('d-m-Y', strtotime($row['date_published'])); ?>
        </a>
    </li>
<?php endwhile; ?>
</ul>

<?php
$totalResult = $mysqli->query("SELECT COUNT(*) AS total FROM announcements")->fetch_assoc()['total'];
$totalPages = ceil($totalResult / $limit);
?>

<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>

<style>
    .pagination a {
        margin: 0 5px;
        padding: 8px 16px;
        text-decoration: none;
        color: #007BFF;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #007BFF;
        color: white;
    }
</style>
