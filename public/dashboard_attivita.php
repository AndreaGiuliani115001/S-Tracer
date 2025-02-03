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

// Recupera l'ID del progetto passato tramite GET
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;

if (!$progetto_id || !$stato) {
    die('ID progetto o stato non fornito.');
}

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
                                    <button type="button" class="btn btn-warning btn-rounded"
                                            data-bs-toggle="modal" data-bs-target="#editAttivitaModal"
                                            onclick="editAttivita(<?= $item['id'] ?>, '<?= htmlspecialchars($item['nome']) ?>', '<?= htmlspecialchars($item['descrizione']) ?>', '<?= htmlspecialchars($item['stato']) ?>', '<?= $progetto_id ?>', '<?= $linea_produzione_id ?>')">
                                        <a class="btn-rounded m-1">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#deleteAttivitaModal"
                                            onclick="deleteAttivita(<?= $item['id'] ?>, '<?= $progetto_id ?>', '<?= $linea_produzione_id ?>', '<?= htmlspecialchars($item['stato']) ?>')">
                                        <a class="btn-rounded m-1">
                                            <i class="fas fa-trash text-white"></i>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <p class="card-text"><?= htmlspecialchars($item['descrizione']) ?></p>
                            <a href="dashboard_componenti.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $item['id'] ?>"
                               class="btn btn-primary btn-rounded">
                                <i class="fas fa-cog text-white"></i> Visualizza Componenti
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere una nuova attività -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center p-4"
                     data-bs-toggle="modal" data-bs-target="#createAttivitaModal" style="cursor: pointer;">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-plus fa-3x"></i>
                        <h5 class="mt-2">Aggiungi Attività</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pulsante per tornare alla lista dei progetti -->
        <a href="dashboard_progetto.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>"
           class="btn btn-primary btn-lg rounded-pill">
            <i class="fas fa-arrow-left text-white"></i>
        </a>
    </div>
</div>

<!-- Footer -->
<?php require_once '../includes/footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/attivita/modal_create.php'; ?>
<?php include 'modals/attivita/modal_edit.php'; ?>
<?php include 'modals/attivita/modal_delete.php'; ?>

<script>

    function editAttivita(id, nome, descrizione, stato, progetto_id, linea_produzione_id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_descrizione').value = descrizione;
        document.getElementById('edit_stato').value = stato;
        document.getElementById('edit_progetto_id').value = progetto_id;
        document.getElementById('edit_linea_produzione_id').value = linea_produzione_id;
    }

    function deleteAttivita(id, progetto_id, linea_produzione_id, stato) {
        document.getElementById('delete_id').value = id;
        document.getElementById('delete_progetto_id').value = progetto_id;
        document.getElementById('delete_linea_produzione_id').value = linea_produzione_id;
        document.getElementById('delete_stato').value = stato;
    }
</script>

</body>
</html>

