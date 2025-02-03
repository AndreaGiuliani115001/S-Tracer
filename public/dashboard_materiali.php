<?php
session_start();

if (!isset($_SESSION['nome_utente'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera l'ID del componente passato tramite GET
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera l'ID del componente passato tramite GET
$componente_id = $_GET['componente_id'] ?? null;

// tipo di entità passata progetto/componente
$tipo_entita = $_GET['tipo_entita'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$ordine_id = $_GET['ordine_id'] ?? null;


if ($tipo_entita == 'Progetto') {
    // Usa la classe Materiale per recuperare i materiali associati al progetto
    $materiali = Materiali::getByProgetto($conn, $progetto_id);
} else {
    // Usa la classe Materiale per recuperare i materiali associati al componente
    $materiali = Materiali::getByComponente($conn, $componente_id);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Materiali</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <?php
                // Controllo del valore e visualizzazione dell'HTML corrispondente
                if ($tipo_entita == "Componente") {
                    echo '<h4>Totale Materiali per il Componente</h4>';
                } elseif ($tipo_entita == "Progetto") {
                    echo '<h4>Totale Materiali per il Progetto</h4>';
                }
                ?>

                <h5><?= count($materiali) ?></h5>
            </div>
        </div>

        <div class="row">
            <?php foreach ($materiali as $materiale): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($materiale['nome']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($materiale['descrizione']) ?></p>
                            <p class="card-text">Quantità
                                utilizzata: <?= htmlspecialchars($materiale['quantita_utilizzata']) ?> <?= htmlspecialchars($materiale['unita_misura']) ?></p>
                            <p class="card-text">Costo Unitario:
                                €<?= htmlspecialchars($materiale['costo_unitario']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere un nuovo materiale -->
            <div class="col mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center">
                    <a href="#"
                       class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x" style="color: #27bcbc;"></i>
                            <h5 class="mt-2">Aggiungi Materiale</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <a href="dashboard_progetto.php?progetto_id=<?= $progetto_id ?>&ordine_id=<?= $ordine_id ?>"
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
