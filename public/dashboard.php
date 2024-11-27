<?php
session_start();
require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera tutti gli ordini
$ordini = Ordini::getAll($conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Ordini</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Ordini</h4>
                <h5><?= count($ordini) ?></h5>
            </div>
        </div>
        <div class="row">
            <?php foreach ($ordini as $ordine): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Paragrafo a sinistra -->
                                <h5 class="card-title mb-0">
                                    Ordine: <?= htmlspecialchars($ordine['numero_ordine']) ?></h5>

                                <!-- Bottoni a destra -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-rounded">
                                        <a href="#?progetto_id=<?= $ordine['id'] ?>" class="btn-rounded">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-rounded">
                                        <a href="#?progetto_id=<?= $ordine['id'] ?>" class="btn-rounded">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Progetto:</strong> <?= htmlspecialchars($ordine['progetto_nome'] ?? 'Non associato') ?>
                            </p>
                            <p class="card-text "><i class="fas fa-calendar-alt text-warning"></i> <strong>Data di
                                    Creazione:</strong> <?= htmlspecialchars($ordine['created_at']) ?></p>
                            <p class="card-text "><i class="fas fa-calendar-alt text-warning"></i> <strong>Data di
                                    Consegna:</strong> <?= htmlspecialchars($ordine['data_di_consegna']) ?></p>
                            <?php if ($ordine['ddt'] && $ordine['ordine']): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="<?= htmlspecialchars($ordine['ddt']) ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-file-alt"></i> DDT
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="<?= htmlspecialchars($ordine['ordine']) ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-file-alt"></i> Ordine
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="dashboard_progetti.php?ordine_id=<?= $ordine['id'] ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-folder"></i> Progetti
                                        </a>
                                    </button>
                                </div>
                            <?php elseif (!$ordine['ddt'] && $ordine['ordine']): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger btn btn-rounded">
                                        <a class="btn-rounded m-1">X</a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="<?= htmlspecialchars($ordine['ordine']) ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-file-alt"></i> Ordine
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="dashboard_progetti.php?ordine_id=<?= $ordine['id'] ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-folder"></i> Progetti
                                        </a>
                                    </button>
                                </div>
                            <?php elseif (!$ordine['ordine'] && $ordine['ddt']): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="<?= htmlspecialchars($ordine['ddt']) ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-file-alt"></i> DDT
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn btn-rounded">
                                        <a class="btn-rounded m-1">X</a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="dashboard_progetti.php?ordine_id=<?= $ordine['id'] ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-folder"></i> Progetti
                                        </a>
                                    </button>
                                </div>
                            <?php elseif (!$ordine['ordine'] && !$ordine['ddt']): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger btn btn-rounded">
                                        <a class="btn-rounded m-1">X</a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn btn-rounded">
                                        <a class="btn-rounded m-1">X</a>
                                    </button>
                                    <button type="button" class="btn btn-primary btn btn-rounded">
                                        <a href="dashboard_progetti.php?ordine_id=<?= $ordine['id'] ?>"
                                           class="btn-rounded m-1">
                                            <i class="fas fa-folder"></i> Progetti
                                        </a>
                                    </button>
                                </div>
                            <?php endif; ?>
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
                            <h5 class="mt-2">Aggiungi Ordine</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
