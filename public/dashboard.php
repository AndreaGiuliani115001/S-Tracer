<?php
session_start();
require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera tutti gli ordini
$linee_produzione = LineeProduzione::getAll($conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard Linee di Produzione</title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h4>Totale Linee di Produzione</h4>
                <h5><?= count($linee_produzione) ?></h5>
            </div>
        </div>
        <div class="row">
            <?php foreach ($linee_produzione as $linea_produzione): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Paragrafo a sinistra -->
                                <h5 class="card-title mb-0">
                                    <?= htmlspecialchars($linea_produzione['nome']) ?></h5>

                                <!-- Bottoni a destra -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        <a onclick="editLinea(<?= $linea_produzione['id'] ?>, '<?= $linea_produzione['nome'] ?>')"
                                           class="btn-rounded">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                        <a onclick="deleteLinea(<?= $linea_produzione['id'] ?>)" class="btn-rounded">
                                            <i class="fas fa-trash text-white"></i>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($linea_produzione['foto'] == NULL): ?>
                                <img src="assets/uploads/placeholder.png" class="card-img-top" alt="placeholder.png">
                            <?php else: ?>
                                <img src="assets/uploads/<?= htmlspecialchars($linea_produzione['foto']) ?>"
                                     class="card-img-top"
                                     alt="<?= htmlspecialchars($linea_produzione['foto']) ?>">
                            <?php endif; ?>
                            <br>
                            <button type="button" class="btn btn-primary btn-rounded">
                                <a href="dashboard_progetti.php?linea_produzione_id=<?= $linea_produzione['id'] ?>"
                                   class="btn-rounded">
                                    <i class="fas fas fa-folder text-white"></i> Progetti
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Card per aggiungere un nuovo componente -->
            <div class="col mb-4">
                <div class="card shadow-sm d-flex justify-content-center align-items-center p-4"
                     data-bs-toggle="modal" data-bs-target="#createModal" style="cursor: pointer;">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-plus fa-3x"></i>
                        <h5 class="mt-2">Aggiungi Linea</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include i modali -->
<?php include 'modals/linea_produzione/modal_create.php'; ?>
<?php include 'modals/linea_produzione/modal_edit.php'; ?>
<?php include 'modals/linea_produzione/modal_delete.php'; ?>

<script>

    function editLinea(id, nome) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nome').value = nome;
    }

    function deleteLinea(id) {
        document.getElementById('delete_id').value = id;
    }
</script>

</body>
</html>

