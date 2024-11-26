<?php
session_start();
require_once '../includes/navbar.php'; // Include la navbar
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>GENE.SYS - Home</title>
</head>

<style>
    .card .fas, .card .fa {
        color: #27bcbc !important;
    }
</style>

<body>
<div class="full-screen-container">
    <div class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4">Benvenuto in GENE.SYS</h1>
                <p class="lead">Il sistema di gestione di processi industriali e manutentivi</p>
                <p>
                    Gene.SYS è un software per la digitalizzazione della raccolta dati di processi industriali e
                    manutentivi che caratterizzano tutta la vita di un manufatto.
                </p>
                <?php if (!isset($_SESSION['nome_utente'])): ?>
                    <!-- Bottone per accedere al sistema -->
                    <a href="login.php" class="btn btn-primary btn-rounded">Accedi al Sistema</a>
                <?php else: ?>
                    <!-- Bottone per tornare alla dashboard -->
                    <a href="dashboard.php" class="btn btn-primary btn-rounded">Torna alla Dashboard</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sezione Card -->
        <div class="row justify-content-center mt-5">
            <!-- Card Produzione -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center mb-4" style="border-radius: 10px;">
                    <div class="card-body">
                        <i class="fas fa-cogs fa-3x mb-3"></i>
                        <h5 class="card-title">Produzione</h5>
                    </div>
                </div>
            </div>

            <!-- Card Manutenzione -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center mb-4" style="border-radius: 10px;">
                    <div class="card-body">
                        <i class="fas fa-wrench fa-3x mb-3"></i>
                        <h5 class="card-title">Manutenzione</h5>
                    </div>
                </div>
            </div>

            <!-- Card Sostenibilità -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center mb-4" style="border-radius: 10px;">
                    <div class="card-body">
                        <i class="fas fa-leaf fa-3x mb-3"></i>
                        <h5 class="card-title">Sostenibilità</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php'; // Include la navbar
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
