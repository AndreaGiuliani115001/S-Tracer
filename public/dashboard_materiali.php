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

$progetto_id = $_GET['progetto_id'] ?? null;
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;
$componente_id = $_GET['componente_id'] ?? null;

if (!empty($componente_id)) {
    $attivita_id = $_GET['attivita_id'] ?? null;
    $stato = $_GET['stato'] ?? null;
    $materiali = Materiali::getByComponente($conn, $componente_id);
} else {
    $materiali = Materiali::getByProgetto($conn, $progetto_id);
    $materiali_per_componente = [];
    foreach ($materiali as $materiale) {
        $comp_id = $materiale['componente_id'];
        $materiali_per_componente[$comp_id]['componente_nome'] = $materiale['componente_nome'];
        $materiali_per_componente[$comp_id]['materiali'][] = $materiale;
    }
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
    <style>
        .componente-header {
            background-color: #00263e;
            color: white;
            padding: 10px 15px;
            border-radius: 10px 10px 0 0;
        }

        .componente-section {
            background-color: white;
            margin-bottom: 30px;
            border-radius: 15px;
            overflow: hidden;
        }

    </style>
    <title>Dashboard Materiali</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <?php if (!empty($componente_id)): ?>
                    <h4>Totale Materiali per il Componente</h4>
                    <h5 class="total-count"><?= count($materiali) ?></h5>
                <?php else: ?>
                    <h4>Materiali suddivisi per Componente</h4>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($componente_id)): ?>
            <div class="row">
                <?php foreach ($materiali as $materiale): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0"><?= htmlspecialchars($materiale['nome']) ?></h5>

                                    <!-- Bottoni modifica ed eliminazione -->
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm btn-rounded"
                                                onclick="openEditQuantitaModal(
                                                        '<?= $materiale['id_materiale_componente'] ?>',
                                                        '<?= $materiale['quantita_utilizzata'] ?>',
                                                        '<?= $progetto_id ?>',
                                                        '<?= $linea_produzione_id ?>',
                                                        '<?= $componente_id ?>',
                                                        '<?= $attivita_id ?>',
                                                        '<?= $stato ?>')">
                                            <a class="btn-rounded m-1">
                                                <i class="fas fa-pencil-alt text-white"></i>
                                            </a>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm btn-rounded"
                                                onclick="openDeleteMaterialeComponenteModal(
                                                        '<?= $materiale['id_materiale_componente'] ?>',
                                                        '<?= $materiale['quantita_utilizzata'] ?>',
                                                        '<?= $materiale['materiale_id'] ?>',
                                                        '<?= $progetto_id ?>',
                                                        '<?= $linea_produzione_id ?>',
                                                        '<?= $componente_id ?>',
                                                        '<?= $attivita_id ?>',
                                                        '<?= $stato ?>')">
                                            <a class="btn-rounded m-1">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </button>

                                    </div>
                                </div>

                                <p class="card-text mt-2"><?= htmlspecialchars($materiale['descrizione']) ?></p>
                                <p class="card-text">Quantità
                                    utilizzata: <?= htmlspecialchars($materiale['quantita_utilizzata']) ?> <?= htmlspecialchars($materiale['unita_misura']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="col mb-4">
                    <div class="card shadow-sm d-flex justify-content-center align-items-center p-4"
                         style="cursor: pointer;"
                         onclick="openCreateMaterialeComponenteModal(
                                 '<?= $componente_id ?>',
                                 '<?= $progetto_id ?>',
                                 '<?= $linea_produzione_id ?>',
                                 '<?= $attivita_id ?>',
                                 '<?= $stato ?>')">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x"></i>
                            <h5 class="mt-2">Aggiungi Materiale</h5>
                        </div>
                    </div>
                </div>


            </div>
        <?php else: ?>
            <?php foreach ($materiali_per_componente as $comp_id => $dati_componente): ?>
                <div class="componente-section shadow-sm">
                    <div class="componente-header">
                        <h5><?= htmlspecialchars($dati_componente['componente_nome']) ?></h5>
                    </div>
                    <div class="p-3">
                        <div class="row">
                            <?php foreach ($dati_componente['materiali'] as $materiale): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($materiale['materiale_nome']) ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($materiale['materiale_descrizione']) ?></p>
                                            <p class="card-text">Quantità
                                                utilizzata: <?= htmlspecialchars($materiale['quantita_utilizzata']) ?> <?= htmlspecialchars($materiale['unita_misura']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="mb-4">
            <a href="<?= !empty($componente_id) ? "dashboard_componenti.php?componente_id=$componente_id&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&attivita_id=$attivita_id&stato=$stato" : "dashboard_progetto.php?progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id" ?>"
               class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/materiali/componenti/modal_create.php'; ?>
<?php include 'modals/materiali/componenti/modal_edit.php'; ?>
<?php include 'modals/materiali/componenti/modal_delete.php'; ?>

<script>
    function openCreateMaterialeComponenteModal(componenteId, progettoId, lineaProduzioneId, attivitaId, stato) {
        document.querySelector('[name="componente_id"]').value = componenteId;
        document.querySelector('[name="progetto_id"]').value = progettoId;
        document.querySelector('[name="linea_produzione_id"]').value = lineaProduzioneId;
        document.querySelector('[name="attivita_id"]').value = attivitaId;
        document.querySelector('[name="stato"]').value = stato;
        new bootstrap.Modal(document.getElementById('createMaterialeComponenteModal')).show();
    }

    function openEditQuantitaModal(idMaterialeComponente, quantitaUtilizzata, progettoId, lineaProduzioneId, componenteId, attivitaId, stato) {
        document.getElementById('edit_id_materiale_componente').value = idMaterialeComponente;
        document.getElementById('edit_quantita_utilizzata').value = quantitaUtilizzata;

        // Precompila i campi nascosti per il reindirizzamento
        document.getElementById('edit_progetto_id').value = progettoId;
        document.getElementById('edit_linea_produzione_id').value = lineaProduzioneId;
        document.getElementById('edit_componente_id').value = componenteId;
        document.getElementById('edit_attivita_id').value = attivitaId;
        document.getElementById('edit_stato').value = stato;

        new bootstrap.Modal(document.getElementById('editQuantitaModal')).show();
    }

    function openDeleteMaterialeComponenteModal(idMaterialeComponente, quantitaUtilizzata, materialeId, progettoId, lineaProduzioneId, componenteId, attivitaId, stato) {
        document.getElementById('delete_id_materiale_componente').value = idMaterialeComponente;
        document.getElementById('delete_quantita_utilizzata').value = quantitaUtilizzata;
        document.getElementById('delete_materiale_id').value = materialeId;
        document.getElementById('delete_progetto_id').value = progettoId;
        document.getElementById('delete_linea_produzione_id').value = lineaProduzioneId;
        document.getElementById('delete_componente_id').value = componenteId;
        document.getElementById('delete_attivita_id').value = attivitaId;
        document.getElementById('delete_stato').value = stato;

        new bootstrap.Modal(document.getElementById('deleteMaterialeComponenteModal')).show();
    }


</script>

</body>
</html>
