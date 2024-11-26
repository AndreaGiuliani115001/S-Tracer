<?php
session_start();

if (!isset($_SESSION['nome_utente'])) {
    header('Location: login.php');
    exit;
}

$ordine_id = $_GET['ordine_id'];

require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';
require_once '../includes/status_helper.php';

$progetti = Progetti::getByOrdine($conn, $ordine_id);

?>
<style>
    i {
        color: white;
    }
</style>

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
                        <img src="../assets/uploads/<?= htmlspecialchars($progetto['foto']) ?>" class="card-img-top"
                             alt="<?= htmlspecialchars($progetto['nome']) ?>">

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><?= htmlspecialchars($progetto['nome']) ?> </h5>
                                <h6 class="card-title p-2 rounded <?= getStatusTypeColor($progetto['stato']) ?>">
                                    <?= getStatusTypeIcon($progetto['stato']) ?> <?= htmlspecialchars($progetto['stato']) ?>
                                </h6>
                            </div>
                            <p class="card-title text-secondary"><?= htmlspecialchars($progetto['matricola']) ?> </p>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($progetto['descrizione']) ?></p>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-user text-primary me-2"></i> <strong>Cliente:</strong></span>
                                <span><?= htmlspecialchars($progetto['cliente']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span><i class="fas fa-calendar-alt text-warning me-2"></i> <strong>Data di consegna:</strong></span>
                                <span><?= htmlspecialchars($progetto['data_di_consegna']) ?></span>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn btn-rounded">
                                    <a href="dashboard_progetto.php?progetto_id=<?= $progetto['id'] ?>&ordine_id=<?= $ordine_id ?>"
                                       class="btn-rounded m-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                                <button type="button" class="btn btn-warning btn-rounded">
                                    <a href="#?progetto_id=<?= $progetto['id'] ?>" class="btn-rounded m-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </button>
                                <button type="button" class="btn btn-danger btn-rounded">
                                    <a href="#?progetto_id=<?= $progetto['id'] ?>" class="btn-rounded m-1">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere un nuovo componente -->
            <div class="col mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x" style="color: #27bcbc;"></i>
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

<?php
require_once '../includes/footer.php';
?>
</body>
</html>

