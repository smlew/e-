<?php
    if($_SESSION['logged'] && isset($_SESSION['username'])){

        if ($_SESSION['admin']) {
            $sql = "
                SELECT 
                    users.username AS username, 
                    multifamily_residential.address AS address, 
                    multifamily_residential.block AS block
                FROM 
                    users
                INNER JOIN 
                    administrators ON users.id = administrators.user_id
                INNER JOIN 
                    multifamily_residential ON administrators.address_id = multifamily_residential.id
                WHERE 
                    users.id = '{$_SESSION['user_id']}';
            ";
        } else {
        $sql = "SELECT 
                    users.username AS username, 
                    multifamily_residential.address AS address
                FROM 
                    users
                LEFT JOIN 
                    apartments ON users.apartment_id = apartments.id
                LEFT JOIN 
                    multifamily_residential ON apartments.address_id = multifamily_residential.id
                WHERE 
                    users.id = '{$_SESSION['user_id']}';
                ";
        }
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
    }
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-xl">
        <a class="navbar-brand" href="index.php">E-Osiedle</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="announcements.php">Ogłoszenia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar.php">Kalendarz</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if((isset($_SESSION['admin']) and $_SESSION['admin'] == true ) or ($_SESSION['logged']) == false) { echo htmlspecialchars('disabled'); } ?>" href="report_submit.php">Zgłoś usterkę</a>
                </li>
                <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-panel.php">Panel administracyjny</a>
                        </li>
                    <?php
                    }

                    if ($_SESSION['owner']) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="owner-panel.php">Panel właściciela</a>
                        </li>
                        <?php
                    }
                ?>
                

            </ul>
            <span class="navbar-text address">
                <?php echo $row['address']?>
            </span>
            <!-- <form class="d-flex nav-search-form" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
            <?php
                if($_SESSION['logged'] && isset($_SESSION['username'])){
            ?>
                <div class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle user-action">
                        <?php 
                            echo $row['username'];
                        ?>
                        <b class="caret"></b>
                    </a>
                    <div class="dropdown-menu">
                        
                        <a href="#" class="dropdown-item">Profile</a>
                        <div class="divider dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
            <?php } else {?>
                <button type="button" class="btn btn-primary" onclick="loadLoginWindow()">Zaloguj się</button>
            <?php
                }
            ?>
        </div>
    </div>
</nav>