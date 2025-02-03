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

// Recupera gli ID di attività e progetto passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;

if (!$attivita_id || !$progetto_id) {
    die('ID attività o progetto non fornito.');
}

// Recupera i componenti in base all'attività e al progetto
$componenti = Componenti::getByAttivitaEProgetto($conn, $attivita_id, $progetto_id);

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
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Componenti</h4>
                <h5><?= count($componenti) ?></h5>
            </div>
        </div>

        <div class="row">
            <?php foreach ($componenti as $componente): ?>

                <!-- Card Componente -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if ($componente['foto'] == NULL): ?>
                            <img src="assets/uploads/placeholder.png" class="card-img-top" alt="placeholder.png">
                        <?php else: ?>
                            <img src="assets/uploads/<?= htmlspecialchars($componente['foto']) ?>" class="card-img-top"
                                 alt="<?= $componente['foto'] ?>">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title"><?= htmlspecialchars($componente['nome']) ?></h4>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><?= htmlspecialchars($componente['descrizione']) ?></span>
                            </div>
                            <br>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-warning btn-rounded"
                                        data-bs-toggle="modal" data-bs-target="#editComponenteModal"
                                        onclick="editComponente(<?= $componente['componente_id'] ?>, '<?= htmlspecialchars($componente['nome']) ?>', '<?= htmlspecialchars($componente['descrizione']) ?>', '<?= $progetto_id ?>', '<?= $attivita_id ?>', '<?= $stato ?>', '<?= $linea_produzione_id ?>')">
                                    <i class="fas fa-pencil-alt text-white m-1"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-rounded"
                                        data-bs-toggle="modal" data-bs-target="#deleteComponenteModal"
                                        onclick="deleteComponente(<?= $componente['componente_id'] ?>, '<?= $progetto_id ?>', '<?= $attivita_id ?>', '<?= $stato ?>', '<?= $linea_produzione_id ?>')">
                                    <i class="fas fa-trash text-white m-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Operazioni -->
                <div class="col-md-8 mb-4">

                    <?php
                    // Recupera le operazioni e calcola il conteggio prima di generare l'HTML
                    $operazioni = Operazioni::getByComponente($conn, $componente['componente_id']);
                    ?>

                    <div class="card shadow-sm h-100">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Operazioni per <?= htmlspecialchars($componente['nome']) ?></h5>

                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-primary btn-rounded"
                                        data-bs-toggle="modal" data-bs-target="#createOperazioneModal"
                                        onclick="createOperazione('<?= $componente['componente_id'] ?>', '<?= $progetto_id ?>', '<?= $attivita_id ?>', '<?= $stato ?>', '<?= $linea_produzione_id ?>')">
                                    <i class="fas fa-plus text-white"></i>
                                </button>
                            </div>

                        </div>
                        <div class="card-body scrollable">
                            <div class="row g-3">
                                <?php foreach ($operazioni as $operazione): ?>
                                    <div class="col-md-6 d-flex align-items-stretch">
                                        <div class="card shadow-sm w-100">
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title"><?= htmlspecialchars($operazione['nome']) ?></h6>
                                                <p class="card-text"><?= htmlspecialchars($operazione['descrizione']) ?></p>
                                                <div class="mt-auto">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-primary btn-rounded">
                                                            <a href="dashboard_checklist.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>&componente_id=<?= $componente['componente_id'] ?>&operazione_id=<?= $operazione['id'] ?>"
                                                               class="btn-rounded m-1">
                                                                <i class="fas fa-eye text-white"></i>
                                                            </a>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-rounded"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editOperazioneModal"
                                                                onclick="editOperazione(<?= $operazione['operazione_id'] ?>, '<?= htmlspecialchars($operazione['nome']) ?>', '<?= htmlspecialchars($operazione['descrizione']) ?>')">
                                                            <a class="btn-rounded m-1">
                                                                <i class="fas fa-pencil-alt text-white m-1"></i>
                                                            </a>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-rounded"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteOperazioneModal"
                                                                onclick="deleteOperazione('<?= $operazione['operazione_id'] ?>', '<?= $progetto_id ?>', '<?= $attivita_id ?>', '<?= $componente['componente_id'] ?>', '<?= $stato ?>', '<?= $linea_produzione_id ?>')">
                                                            <a class="btn-rounded m-1">
                                                                <i class="fas fa-trash text-white m-1"></i>
                                                            </a>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <!-- Card per aggiungere un nuovo componente -->
        <div class="mb-4">
            <div class="card shadow-sm d-flex justify-content-center align-items-center p-4" data-bs-toggle="modal"
                 data-bs-target="#createComponenteModal" style="cursor: pointer;">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <i class="fas fa-plus fa-3x"></i>
                    <h5 class="mt-2">Aggiungi Componente</h5>
                </div>
            </div>
        </div>

        <!-- Pulsante per tornare alla lista dei progetti -->
        <div class="mb-4">
            <a href="dashboard_attivita.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>"
               class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once '../includes/footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/componenti/modal_create.php'; ?>
<?php include 'modals/componenti/modal_edit.php'; ?>
<?php include 'modals/componenti/modal_delete.php'; ?>

<?php include 'modals/operazioni/modal_create.php'; ?>
<?php include 'modals/operazioni/modal_edit.php'; ?>
<?php include 'modals/operazioni/modal_delete.php'; ?>

<script>
    function editComponente(id, nome, descrizione, progetto_id, attivita_id, stato, linea_produzione_id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_descrizione').value = descrizione;
        document.getElementById('edit_progetto_id').value = progetto_id;
        document.getElementById('edit_attivita_id').value = attivita_id;
        document.getElementById('edit_stato').value = stato;
        document.getElementById('edit_linea_produzione_id').value = linea_produzione_id;
    }

    function deleteComponente(id, progetto_id, attivita_id, stato, linea_produzione_id) {
        document.getElementById('delete_id').value = id;
        document.getElementById('delete_progetto_id').value = progetto_id;
        document.getElementById('delete_attivita_id').value = attivita_id;
        document.getElementById('delete_stato').value = stato;
        document.getElementById('delete_linea_produzione_id').value = linea_produzione_id;
    }

    function createOperazione(componente_id, progetto_id, attivita_id, stato, linea_produzione_id) {
        document.getElementById('create_componente_id').value = componente_id;
        document.getElementById('create_progetto_id').value = progetto_id;
        document.getElementById('create_attivita_id').value = attivita_id;
        document.getElementById('create_stato').value = stato;
        document.getElementById('create_linea_produzione_id').value = linea_produzione_id;
    }

    function deleteOperazione(id, progetto_id, attivita_id, componente_id, stato, linea_produzione_id) {

        console.log("ID Operazione:", id);
        console.log("Progetto ID:", progetto_id);
        console.log("Attività ID:", attivita_id);
        console.log("Componente ID:", componente_id);
        console.log("Stato:", stato);
        console.log("Linea Produzione ID:", linea_produzione_id);

        document.getElementById('delete_operazione_id').value = id;
        document.getElementById('delete_progetto_id').value = progetto_id;
        document.getElementById('delete_attivita_id').value = attivita_id;
        document.getElementById('delete_componente_id').value = componente_id;
        document.getElementById('delete_stato').value = stato;
        document.getElementById('delete_linea_produzione_id').value = linea_produzione_id;
    }

    function editOperazione(id, nome, descrizione) {
        document.getElementById('edit_operazione_id').value = id;
        document.getElementById('edit_nome_operazione').value = nome;
        document.getElementById('edit_descrizione_operazione').value = descrizione;
    }



</script>

</body>
</html>