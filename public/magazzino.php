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

$materiali = Materiali::getAll($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Materiali</h4>
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
                            <p class="card-text">Quantità disponibile: <?= htmlspecialchars($materiale['quantita_disponibile']) ?> <?= htmlspecialchars($materiale['unita_misura']) ?></p>
                            <p class="card-text">Costo Unitario: <?= htmlspecialchars($materiale['costo_unitario']) ?> €</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere un nuovo materiale -->
            <div class="col mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-plus fa-3x"></i>
                            <h5 class="mt-2">Aggiungi Materiale</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>
</body>
</html>

