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
require_once '../includes/status_helper.php';

// Recupera l'ID del progetto passato tramite GET
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;

$linea_produzione = LineeProduzione::getById($conn, $linea_produzione_id);
$progetto = Progetti::getById($conn, $progetto_id);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dettagli Progetto</title>
</head>
<body>
<div class="full-screen-container">
    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Dettagli del Progetto -->
        <div class="mb-4">
            <div class="card shadow-sm h-100 mb-4">
                <?php if ($progetto['foto'] == NULL): ?>
                    <img src="assets/uploads/placeholder.png" class="card-img-top" alt="placeholder.png">
                <?php else: ?>
                    <img src="assets/uploads/<?= htmlspecialchars($progetto['foto']) ?>" class="card-img-top"
                         alt="<?= htmlspecialchars($progetto['foto']) ?>">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Paragrafo a sinistra -->
                        <h2 class="card-title"><?= htmlspecialchars($linea_produzione['nome']) ?>
                            #<?= htmlspecialchars($progetto['matricola']) ?> </h2>

                        <!-- Bottoni a destra -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success btn-rounded">
                                <a href="dashboard_materiali.php?progetto_id=<?= $progetto['id'] ?>&linea_produzione_id=<?= $linea_produzione_id ?>"
                                   class="btn-rounded m-1">
                                    <i class="fas fa-cube text-white"></i> Materiali
                                </a>
                            </button>
                            <button type="button" class="btn <?= getStatusTypeColor($progetto['stato']) ?> btn-rounded">
                                <h6 class="card-title mb-0 rounded <?= getStatusTypeColor($progetto['stato']) ?>">
                                    <?= getStatusTypeIcon($progetto['stato']) ?> <?= htmlspecialchars($progetto['stato']) ?>
                                </h6>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-file-alt text-success me-2"></i> <strong>CIN:</strong></span>
                        <span><?= htmlspecialchars($progetto['CIN']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span><i class="fas fa-calendar-alt text-warning me-2"></i> <strong>Data di consegna:</strong></span>
                        <span><?= htmlspecialchars($progetto['data_di_consegna']) ?></span>
                    </div>
                </div>

            </div>

            <!-- Card Produzione -->
            <div class="card shadow-sm w-100 mb-4">
                <a href="dashboard_attivita.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=Produzione"
                   class="text-dark d-flex align-items-center">
                    <div class="card-body text-center">
                        <i class="fas fa-cogs fa-3x mb-3"></i>
                        <h5 class="card-title">Produzione</h5>
                        <p class="card-text">Visualizza i dettagli di produzione del progetto</p>
                    </div>
                </a>
            </div>

            <!-- Card Manutenzione -->
            <div class="card shadow-sm w-100 mb-4">
                <a href="dashboard_attivita.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=Manutenzione"
                   class="text-dark d-flex align-items-center">
                    <div class="card-body text-center">
                        <i class="fas fa-wrench fa-3x mb-3"></i>
                        <h5 class="card-title">Manutenzione</h5>
                        <p class="card-text">Gestisci la manutenzione del progetto</p>
                    </div>
                </a>
            </div>

            <!-- Card Sostenibilità -->
            <div class="card shadow-sm w-100 mb-4">
                <a href="dashboard_sostenibilita.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=Manutenzione" class="text-dark d-flex align-items-center">
                    <div class="card-body text-center">
                        <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Sostenibilità</h5>
                        <p class="card-text">Visualizza i dettagli di sostenibilità del progetto</p>
                    </div>
                </a>
            </div>

            <!-- Pulsante per tornare alla lista dei progetti -->
            <div>
                <a href="dashboard_progetti.php?linea_produzione_id=<?= $linea_produzione_id ?>"
                   class="btn btn-primary btn-lg rounded-pill">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>
</body>
</html>