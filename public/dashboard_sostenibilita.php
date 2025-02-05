<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['nome_utente'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera l'ID del progetto dalla query string
$progetto_id = $_GET['progetto_id'];
$linea_produzione_id = $_GET['linea_produzione_id'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Sostenibilità</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">

        <!-- Card Materiali -->
        <a href="dashboard_materiali.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>" class="text-decoration-none">
            <div class="card shadow-sm w-100 text-center mb-4" style="cursor: pointer;">
                <div class="card-body">
                    <i class="fas fa-cube fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Materiali</h5>
                    <p class="card-text">Scopri di cosa è fatto il prodotto per il recupero e il riciclo delle materie
                        prime.</p>
                </div>
            </div>
        </a>


        <!-- Card Carbon Footprint -->
        <div class="card shadow-sm w-100 text-center mb-4">
            <div class="card-body">
                <i class="fas fa-leaf fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Carbon Footprint di Prodotto</h5>
                <p class="card-text">Scopri l'impatto del tuo prodotto.</p>
            </div>
        </div>

        <!-- Card Design for Disassembly -->
        <div class="card shadow-sm w-100 text-center mb-4">
            <div class="card-body">
                <i class="fas fa-puzzle-piece fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Design for Disassembly</h5>
                <p class="card-text">Scopri come separare i componenti per un riciclo consapevole.</p>
            </div>
        </div>

        <!-- Card Digital Product Passport (DPP) -->
        <div class="card shadow-sm w-100 text-center mb-4">
            <div class="card-body">
                <i class="fas fa-id-card fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Digital Product Passport (DPP)</h5>
                <p class="card-text">Visualizza tutte le informazioni digitali del prodotto per la tracciabilità e la
                    sostenibilità.</p>
            </div>
        </div>
        <!-- Pulsante per tornare alla lista dei progetti -->
        <div class="mb-4">
            <a href="dashboard_progetto.php?linea_produzione_id=<?= $linea_produzione_id ?>&progetto_id=<?= $progetto_id ?>"
               class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>
</body>
</html>
