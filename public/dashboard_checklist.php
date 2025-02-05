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

// Recupera il componente_operazione_id
$componente_operazione_id = ComponentiOperazioni::getComponenteOperazioneId($conn, $componente_id, $operazione_id);

if (!$componente_operazione_id) {
    die('Errore: relazione componente-operazione non trovata.');
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
                            <!-- Bottone Crea checklist -->
                            <button type="button" class="btn btn-primary btn-rounded me-2"
                                    onclick="openCreateChecklistModal(<?= $componente_operazione_id ?>)">
                                <i class="fas fa-plus text-white"></i>
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
                                            <button type="button" class="btn btn-warning btn-rounded btn-sm"
                                                    onclick="openEditChecklistModal('<?= $checklist['checklist_id'] ?>', '<?= htmlspecialchars($checklist['checklist_nome']) ?>', '<?= htmlspecialchars($checklist['checklist_descrizione']) ?>')">
                                                <a class="btn-rounded m-1">
                                                    <i class="fas fa-pencil-alt text-white"></i>
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-rounded btn-sm"
                                                    onclick="openDeleteChecklistModal('<?= $checklist['checklist_id'] ?>')">
                                                <a class="btn-rounded m-1">
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

                        <?php if (!empty($selected_checklist_id)): ?>
                            <!-- Bottone Visualizza compilazione -->
                            <button type="button" class="btn btn-primary btn-rounded me-2">
                                <a href="checklist.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>&componente_id=<?= $componente_id ?>&operazione_id=<?= $operazione_id ?>&checklist_id=<?= $selected_checklist_id ?>"
                                   class="btn-rounded m-1 text-decoration-none text-white">
                                    <i class="fas fa-signature text-white"></i> compilazione
                                </a>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if ($selected_checklist): ?>
                            <h5><?= htmlspecialchars($selected_checklist['checklist']['nome']) ?></h5>
                            <p><?= htmlspecialchars($selected_checklist['checklist']['descrizione']) ?></p>
                            <ul class="list-group mt-3 mb-3">

                                <?php foreach ($selected_checklist['domande'] as $domanda): ?>
                                    <?php
                                    // Verifica se esistono risposte associate a questa domanda
                                    $haRisposte = Risposte::esistonoRispostePerDomanda($conn, $domanda['id']);
                                    ?>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= htmlspecialchars($domanda['testo']) ?></strong>
                                            <p class="text-muted">Tipo di
                                                risposta: <?= htmlspecialchars($domanda['tipo_risposta']) ?></p>

                                            <?php if (!empty($domanda['file_url'])): ?>
                                                <a href="assets/uploads/<?= htmlspecialchars($domanda['file_url']) ?>"
                                                   target="_blank">Visualizza
                                                    file</a>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Pulsanti per modificare o eliminare la domanda solo se non ci sono risposte associate -->
                                        <?php if (!$haRisposte): ?>
                                            <div class="btn-group" role="group">
                                                <!-- Pulsante Modifica -->
                                                <button type="button" class="btn btn-warning btn-rounded btn-sm"
                                                        onclick="openEditDomandaModal('<?= $domanda['id'] ?>', '<?= htmlspecialchars($domanda['testo']) ?>', '<?= $domanda['tipo_risposta'] ?>')">
                                                    <a class="btn-rounded m-1">
                                                        <i class="fas fa-pencil-alt text-white"></i>
                                                    </a>
                                                </button>

                                                <!-- Pulsante Elimina -->
                                                <button type="button" class="btn btn-danger btn-rounded btn-sm"
                                                        onclick="openDeleteDomandaModal('<?= $domanda['id'] ?>')">
                                                    <a class="btn-rounded m-1">
                                                        <i class="fas fa-trash text-white"></i>
                                                    </a>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Bottone per aggiungere una nuova domanda -->
                            <button type="button" class="btn btn-primary btn-rounded mb-3"
                                    onclick="openCreateDomandaModal('<?= $selected_checklist_id ?>')">
                                <i class="fas fa-plus text-white"></i> Aggiungi Domanda
                            </button>

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

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/checklist/modal_create.php'; ?>
<?php include 'modals/checklist/modal_edit.php'; ?>
<?php include 'modals/checklist/modal_delete.php'; ?>

<?php include 'modals/checklist/domande/modal_create.php'; ?>
<?php include 'modals/checklist/domande/modal_edit.php'; ?>
<?php include 'modals/checklist/domande/modal_delete.php'; ?>

<script>
    function openCreateChecklistModal(componente_operazione_id) {
        document.getElementById('componente_operazione_id').value = componente_operazione_id;
        new bootstrap.Modal(document.getElementById('createChecklistModal')).show();
    }

    function openCreateDomandaModal(selected_checklist_id) {
        document.getElementById('selected_checklist_id').value = selected_checklist_id;
        new bootstrap.Modal(document.getElementById('createDomandaModal')).show();
    }

    function openDeleteChecklistModal(checklistId) {
        document.getElementById('delete_checklist_id').value = checklistId;
        new bootstrap.Modal(document.getElementById('deleteChecklistModal')).show();
    }

    function openEditChecklistModal(checklistId, checklistNome, checklistDescrizione) {
        document.getElementById('edit_checklist_id').value = checklistId;
        document.getElementById('edit_nome').value = checklistNome;
        document.getElementById('edit_descrizione').value = checklistDescrizione;
        new bootstrap.Modal(document.getElementById('editChecklistModal')).show();
    }

    function openDeleteDomandaModal(domandaId) {
        document.getElementById('delete_domanda_id').value = domandaId;
        new bootstrap.Modal(document.getElementById('deleteDomandaModal')).show();
    }

    function openEditDomandaModal(domandaId, domandaTesto, domandaTipoRisposta) {
        document.getElementById('edit_domanda_id').value = domandaId;
        document.getElementById('edit_domanda_testo').value = domandaTesto;
        document.getElementById('edit_domanda_tipo_risposta').value = domandaTipoRisposta;
        new bootstrap.Modal(document.getElementById('editDomandaModal')).show();
    }


</script>


</body>
</html>
