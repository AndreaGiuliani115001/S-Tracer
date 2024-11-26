<?php
session_start();


if (!isset($_SESSION['nome_utente'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera l'ID del progetto passato tramite GET
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$ordine_id = $_GET['ordine_id'] ?? null;

if (!$progetto_id || !$stato) {
    die('ID progetto o stato non fornito.');
}

// Recupera il nome del progetto (opzionale, se necessario)
$progetto = Progetti::getById($conn, $progetto_id);

// Recupera le attività associate al progetto
$attivita = Attività::getByProgetto($conn, $progetto_id, $stato);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Attività</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Attività</h4>
                <h5><?= count($attivita) ?></h5>
            </div>
        </div>
        <div class="row">
            <?php foreach ($attivita as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <!-- Paragrafo a sinistra -->
                                <h5 class="card-title"><?= htmlspecialchars($item['nome']) ?></h5>

                                <!-- Bottoni a destra -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-rounded">
                                        <a href="#?progetto_id=<?= $ordine['id'] ?>" class="btn-rounded m-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-rounded">
                                        <a href="#?progetto_id=<?= $ordine['id'] ?>" class="btn-rounded m-1">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <p class="card-text"><?= htmlspecialchars($item['descrizione']) ?></p>
                            <a href="dashboard_componenti.php?attivita_id=<?= $item['id'] ?>&progetto_id=<?= $progetto_id ?>&ordine_id=<?= $ordine_id ?>&stato=<?= $stato ?>"
                               class="btn btn-primary btn-rounded">
                                <i class="fas fa-cog"></i> Visualizza Componenti
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere una nuova attività -->
            <div class="col-md-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center h-100 p-4">
                    <a href="#"
                       class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x" style="color: #27bcbc;"></i>
                            <h5 class="mt-2">Aggiungi Attività</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Pulsante per tornare alla lista dei progetti -->
        <div class="mt-4">
            <a href="dashboard_progetto.php?progetto_id=<?= $progetto_id ?>&ordine_id=<?= $ordine_id ?>"
               class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

