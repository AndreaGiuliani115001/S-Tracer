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
                    <div class="card shadow-sm h-100 <?= ($materiale['quantita_disponibile'] == 0) ? 'border border-2 border-danger' : '' ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($materiale['nome']) ?></h5>

                                <div class="btn-group" role="group">

                                    <!-- Bottone Modifica -->
                                    <button type="button" class="btn btn-warning btn-sm btn-rounded"
                                            onclick="openEditMaterialeModal('<?= $materiale['id'] ?>', '<?= htmlspecialchars($materiale['nome']) ?>',
                                                    '<?= htmlspecialchars($materiale['descrizione']) ?>', '<?= $materiale['quantita_disponibile'] ?>',
                                                    '<?= $materiale['unita_misura'] ?>', '<?= $materiale['costo_unitario'] ?>')">
                                        <a class="btn-rounded m-1">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
                                    </button>

                                    <!-- Bottone Eliminazione -->
                                    <button type="button" class="btn btn-danger btn-sm btn-rounded"
                                            onclick="openDeleteMaterialeModal('<?= $materiale['id'] ?>')">
                                        <a class="btn-rounded m-1">
                                            <i class="fas fa-trash text-white"></i>
                                        </a>
                                    </button>

                                </div>
                            </div>

                            <p class="card-text mt-2"><?= htmlspecialchars($materiale['descrizione']) ?></p>
                            <p class="card-text <?= ($materiale['quantita_disponibile'] == 0) ? 'bg-danger bg-gradient text-white rounded p-2' : '' ?>">
                                Quantità
                                disponibile: <?= htmlspecialchars($materiale['quantita_disponibile']) ?> <?= htmlspecialchars($materiale['unita_misura']) ?></p>
                            <p class="card-text">Costo Unitario: <?= htmlspecialchars($materiale['costo_unitario']) ?>
                                €</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Card per aggiungere un nuovo materiale -->
            <div class="col mb-4 ">
                <div class="card shadow-sm d-flex justify-content-center align-items-center p-4"
                     style="cursor: pointer;"
                     onclick="openCreateMaterialeModal()">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-plus fa-3x"></i>
                        <h5 class="mt-2">Aggiungi Materiale</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../includes/footer.php';
?>


<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/materiali/magazzino/modal_create.php'; ?>
<?php include 'modals/materiali/magazzino/modal_edit.php'; ?>
<?php include 'modals/materiali/magazzino/modal_delete.php'; ?>

<script>

    function openCreateMaterialeModal() {
        new bootstrap.Modal(document.getElementById('createMaterialeModal')).show();
    }

    function openEditMaterialeModal(id, nome, descrizione, quantitaDisponibile, unitaMisura, costoUnitario) {
        document.getElementById('edit_materiale_id').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_descrizione').value = descrizione;
        document.getElementById('edit_quantita_disponibile').value = quantitaDisponibile;
        document.getElementById('edit_unita_misura').value = unitaMisura;
        document.getElementById('edit_costo_unitario').value = costoUnitario;
        new bootstrap.Modal(document.getElementById('editMaterialeModal')).show();
    }

    function openDeleteMaterialeModal(materialeId) {
        document.getElementById('delete_materiale_id').value = materialeId;
        new bootstrap.Modal(document.getElementById('deleteMaterialeModal')).show();
    }

</script>
</body>
</html>

