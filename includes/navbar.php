<?php
$is_logged_in = isset($_SESSION['nome_utente']);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-transparent">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="assets/uploads/logoGenesis.png" alt="Logo" style="width: 40px; height: 40px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if ($is_logged_in): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard <i class="fas fa-home text-black"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="magazzino.php">Magazzino <i class="fas fa-warehouse text-black"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout <i class="fas fa-sign-out-alt text-black"></i>
                        </a>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login <i class="fas fa-user"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

