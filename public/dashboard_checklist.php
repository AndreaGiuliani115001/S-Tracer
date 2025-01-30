<?php
session_start();
require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera gli ID passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;
$stato = $_GET['stato'] ?? null;
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;
$componente_id = $_GET['componente_id'] ?? null;
$operazione_id = $_GET['operazione_id'] ?? null;

if (!$attivita_id || !$progetto_id) {
    die('ID attività o progetto non fornito.');
}

// Recupera le checklist in base al componente e all'operazione
$checklists = Checklist::getByComponenteEOperazione($conn, $componente_id, $operazione_id);

// Recupera la checklist selezionata (default: la prima checklist trovata)
$selected_checklist_id = $_GET['checklist_id'] ?? ($checklists[0]['id'] ?? null);
$selected_checklist = $selected_checklist_id ? Checklist::getByIdWithQuestions($conn, $selected_checklist_id) : null;

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Checklist</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="row mb-4">
            <!-- Colonna Sinistra: Lista delle Checklist -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Checklist Disponibili</h5>
                        <div class="d-flex align-items-center">
                            <!-- Bottone Modifica -->
                            <button type="button" class="btn btn-primary btn-rounded me-2">
                                <a href="#" class="btn-rounded m-1 text-decoration-none text-white">
                                    <i class="fas fa-plus text-white"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($checklists)): ?>
                            <ul class="list-group">
                                <?php foreach ($checklists as $checklist): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>&componente_id=<?= $componente_id ?>&operazione_id=<?= $operazione_id ?>&checklist_id=<?= $checklist['checklist_id'] ?>"
                                           class="text-decoration-none <?= ($selected_checklist_id == $checklist['checklist_id']) ? 'fw-bold' : '' ?>">
                                            <?= htmlspecialchars($checklist['checklist_nome']) ?>
                                        </a>
                                        <div class="btn-group p-2" role="group">
                                            <button type="button" class="btn btn-warning btn-rounded btn-sm">
                                                <a href="#" class="btn-rounded">
                                                    <i class="fas fa-pencil-alt text-white"></i>
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-rounded btn-sm">
                                                <a href="#" class="btn-rounded">
                                                    <i class="fas fa-trash text-white"></i>
                                                </a>
                                            </button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Nessuna checklist disponibile.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Colonna Destra: Dettagli della Checklist -->
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Domande e Risposte</h5>

                        <?php if(!empty($selected_checklist_id)): ?>
                        <!-- Bottone Visualizza compilazione -->
                        <button type="button" class="btn btn-primary btn-rounded me-2">
                            <a href="checklist.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?=  $attivita_id ?>&componente_id=<?= $componente_id ?>&operazione_id=<?= $operazione_id ?>&checklist_id=<?= $selected_checklist_id ?>" class="btn-rounded m-1 text-decoration-none text-white">
                                <i class="fas fa-eye text-white"></i> Visualizza compilazione
                            </a>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if ($selected_checklist): ?>
                            <h5><?= htmlspecialchars($selected_checklist['checklist']['nome']) ?></h5>
                            <p><?= htmlspecialchars($selected_checklist['checklist']['descrizione']) ?></p>
                            <ul class="list-group mt-3">
                                <?php foreach ($selected_checklist['domande'] as $domanda): ?>
                                    <li class="list-group-item">
                                        <strong><?= htmlspecialchars($domanda['testo']) ?></strong>
                                        <p class="text-muted">Tipo di
                                            risposta: <?= htmlspecialchars($domanda['tipo_risposta']) ?></p>
                                        <?php if (!empty($domanda['file_url'])): ?>
                                            <a href="<?= htmlspecialchars($domanda['file_url']) ?>" target="_blank">Visualizza
                                                file</a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Seleziona una checklist per vedere i dettagli.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- Pulsante per tornare alla lista dei progetti -->
        <div class="mb-4">
            <a href="dashboard_componenti.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>"
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
