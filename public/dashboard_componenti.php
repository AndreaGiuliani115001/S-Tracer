<?php
session_start();
require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera gli ID di attività e progetto passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$ordine_id = $_GET['ordine_id'] ?? null;

if (!$attivita_id || !$progetto_id) {
    die('ID attività o progetto non fornito.');
}

// Recupera i dati dei componenti, operazioni e checklist
$data = Componenti::getComponentiOperazioniChecklist($conn, $attivita_id, $progetto_id);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Componenti</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <!-- <h2 class="mb-4">Componenti e Operazioni - Attività <?= htmlspecialchars($attivita_id) ?></h2> -->
        <?php
        $count = 0;
        $current_componente = null;
        foreach ($data

        as $row):
        if ($row['componente_id'] !== $current_componente): $count++;
        if ($current_componente !== null):
        ?>
    </div>
</div>
<?php endif;
$current_componente = $row['componente_id']; ?>
<div class="card shadow-sm mb-4">
    <div class="card-body text-center">
        <h4>Totale Componenti</h4>
        <h5><?= $count ?></h5>
    </div>
</div>
<!-- Card Componente -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Paragrafo a sinistra -->
            <h4 class="mb-0"><?= htmlspecialchars($row['componente_nome']) ?></h4>

            <!-- Bottoni a destra -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-success btn-rounded">
                    <a href="dashboard_materiali.php?progetto_id=<?=$progetto_id?>&componente_id=<?= $row['componente_id'] ?>&ordine_id=<?= $ordine_id ?>&tipo_entita=Componente" class="btn-rounded">
                        <i class="fas fa-cube"></i>
                    </a>
                </button>
                <button type="button" class="btn btn-warning btn-rounded">
                    <a href="#" class="btn-rounded">
                        <i class="fas fa-pencil-alt" id="materiali"></i>
                    </a>
                </button>
                <button type="button" class="btn btn-danger btn-rounded">
                    <a href="#" class="btn-rounded">
                        <i class="fas fa-trash"></i>
                    </a>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php endif; ?>
            <!-- Card Operazione -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($row['operazione_nome']) ?></h5>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <?php if (!empty($row['checklist_nome'])): ?>
                                <a href="checklist.php?checklist_id=<?= $row['checklist_id'] ?>"
                                   class="btn btn-outline-primary btn-lg btn-rounded">
                                    <i class="fas fa-list"></i>
                                    <?= htmlspecialchars($row['checklist_nome']) ?>
                                </a>
                            <?php else: ?>
                                <span class="btn btn-outline-secondary btn-sm disabled">
                                            <i class="fas fa-exclamation-circle"></i> Nessuna Checklist
                                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if ($current_componente !== null): ?>
        </div>
    </div>
</div>
<!-- Pulsante per tornare alla lista dei progetti -->
    <div class="mt-4">
        <a href="dashboard_attività.php?progetto_id=<?= $progetto_id ?>&ordine_id=<?= $ordine_id ?>&stato=<?= $stato ?>"
           class="btn btn-primary btn-lg rounded-pill">
            <i class="fas fa-arrow-left text-white"></i>
        </a>
    </div>
<?php endif; ?>
</div>
<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



