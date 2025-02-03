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

$linea_produzione_id = $_GET['linea_produzione_id'];

$progetti = Progetti::getByLineaProduzione($conn, $linea_produzione_id);
$linea_produzione = LineeProduzione::getById($conn, $linea_produzione_id);
$linee_produzione = LineeProduzione::getAll($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Progetti</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Progetti</h4>
                <h5><?= count($progetti) ?></h5>
            </div>
        </div>

        <div class="row">
            <?php foreach ($progetti as $progetto): ?>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if ($progetto['foto'] == NULL): ?>
                            <img src="assets/uploads/placeholder.png" class="card-img-top" alt="placeholder.png">
                        <?php else: ?>
                            <img src="assets/uploads/<?= htmlspecialchars($progetto['foto']) ?>" class="card-img-top"
                                 alt="<?= htmlspecialchars($progetto['foto']) ?>">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title"><?= htmlspecialchars($linea_produzione['nome']) ?>
                                    #<?= htmlspecialchars($progetto['matricola']) ?> </h4>
                                <h6 class="card-title p-2 rounded <?= getStatusTypeColor($progetto['stato']) ?>">
                                    <?= getStatusTypeIcon($progetto['stato']) ?> <?= htmlspecialchars($progetto['stato']) ?>
                                </h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-file-alt text-success me-2"></i><strong>CIN:</strong></span>
                                <span><?= htmlspecialchars($progetto['CIN']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span><i class="fas fa-calendar-alt text-warning me-2"></i><strong>Data di consegna:</strong></span>
                                <span><?= htmlspecialchars($progetto['data_di_consegna']) ?></span>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn btn-rounded">
                                    <a href="dashboard_progetto.php?progetto_id=<?= $progetto['id'] ?>&linea_produzione_id=<?= $linea_produzione_id ?>"
                                       class="btn-rounded m-1">
                                        <i class="fas fa-eye text-white"></i>
                                    </a>
                                </button>
                                <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal"
                                        data-bs-target="#editProgettoModal">
                                    <a onclick="editProgetto(<?= $progetto['id'] ?>, '<?= $progetto['matricola'] ?>', '<?= $progetto['CIN'] ?>', '<?= $progetto['data_di_consegna'] ?>', '<?= $progetto['stato'] ?>', '<?= $progetto['linea_produzione_id'] ?>')"
                                       class="btn-rounded m-1">
                                        <i class="fas fa-pencil-alt text-white m-1"></i>
                                    </a>
                                </button>
                                <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteProgettoModal">
                                    <a onclick="deleteProgetto(<?= $progetto['id'] ?>, <?= $progetto['linea_produzione_id'] ?>)" class="btn-rounded m-1">
                                        <i class="fas fa-trash text-white m-1"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere un nuovo componente -->
            <div class="col mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center p-4" data-bs-toggle="modal"
                     data-bs-target="#createProgettoModal" style="cursor: pointer;">
                    <a class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x"></i>
                            <h5 class="mt-2">Aggiungi Progetto</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Pulsante per tornare alla lista dei progetti -->
        <div>
            <a href="dashboard.php" class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include i modali per CRUD -->
<?php include 'modals/progetti/modal_create.php'; ?>
<?php include 'modals/progetti/modal_edit.php'; ?>
<?php include 'modals/progetti/modal_delete.php'; ?>

<script>
    function editProgetto(id, matricola, CIN, data_di_consegna, stato, linea_produzione_id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_matricola').value = matricola;
        document.getElementById('edit_CIN').value = CIN;
        document.getElementById('edit_data_di_consegna').value = data_di_consegna;
        document.getElementById('edit_stato').value = stato;
        document.getElementById('edit_linea_produzione_id').value = linea_produzione_id;
    }

    function deleteProgetto(id, lineaProduzioneId) {
        document.getElementById('delete_id').value = id;
        document.getElementById('delete_linea_produzione_id').value = lineaProduzioneId;
    }

</script>


</body>
</html>

