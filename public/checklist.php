<?php
session_start();
require_once '../config/config.php';
require_once '../autoload.php';
require_once '../includes/navbar.php';

// Recupera l'ID della checklist
$checklist_id = $_GET['checklist_id'] ?? null;

// Recupera gli ID di attività e progetto passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;

// Recupera l'ID dell'ordine passato tramite GET
$ordine_id = $_GET['ordine_id'] ?? null;

$check = $_GET['check'] ?? null;

if (!$checklist_id) {
    die('ID checklist non fornito.');
}

// Recupera la checklist e le sue domande
$checklist_data = Checklist::getByIdWithQuestions($conn, $checklist_id);

if (!$checklist_data) {
    die('Checklist non trovata.');
}

$checklist = $checklist_data['checklist'];
$domande = $checklist_data['domande'];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Checklist: <?= htmlspecialchars($checklist['nome']) ?></title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <!-- Card Principale della Checklist -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Paragrafo a sinistra -->
                    <h3 class="mb-0"><?= htmlspecialchars($checklist['nome']) ?></h3>

                    <!-- Bottoni a destra -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-warning btn-rounded">
                            <a href="#" class="btn-rounded">
                                <i class="fas fa-pencil-alt" id="materiali"></i>
                            </a>
                        </button>
                        <button type="button" class="btn btn-danger btn-rounded">
                            <a href="#" class="btn-rounded">
                                <i class="fas fa-trash"></i>
                            </a>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <h6 class="mb-4"><?= htmlspecialchars($checklist['descrizione']) ?></h6>

                <form action="submit_checklist.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="checklist_id" value="<?= $checklist_id ?>">

                    <!-- Card interna per ogni domanda -->
                    <div class="mb-4">
                        <?php foreach ($domande as $domanda): ?>
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($domanda['testo']) ?></h5>

                                    <!-- Input Dinamico basato su tipo_risposta -->
                                    <?php if ($domanda['tipo_risposta'] === 'testo'): ?>
                                        <textarea name="risposte[<?= $domanda['id'] ?>]"
                                                  id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2" rows="3"
                                                  placeholder="Inserisci la tua risposta"></textarea>

                                    <?php elseif ($domanda['tipo_risposta'] === 'file'): ?>
                                        <input type="file" name="risposte[<?= $domanda['id'] ?>]"
                                               id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2">

                                    <?php elseif ($domanda['tipo_risposta'] === 'scelta'): ?>
                                        <select name="risposte[<?= $domanda['id'] ?>]"
                                                id="domanda_<?= $domanda['id'] ?>" class="form-select mt-2">
                                            <option value="">Seleziona un'opzione</option>
                                            <option value="opzione1">Opzione 1</option>
                                            <option value="opzione2">Opzione 2</option>
                                            <option value="opzione3">Opzione 3</option>
                                        </select>

                                    <?php elseif ($domanda['tipo_risposta'] === 'data'): ?>
                                        <input type="date" name="risposte[<?= $domanda['id'] ?>]"
                                               id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2">

                                    <?php elseif ($domanda['tipo_risposta'] === 'numero'): ?>
                                        <input type="number" name="risposte[<?= $domanda['id'] ?>]"
                                               id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2"
                                               placeholder="Inserisci un valore numerico">

                                    <?php elseif ($domanda['tipo_risposta'] === 'booleano'): ?>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="risposte[<?= $domanda['id'] ?>]"
                                                   id="domanda_<?= $domanda['id'] ?>" value="1"
                                                   class="form-check-input">
                                            <label class="form-check-label"
                                                   for="domanda_<?= $domanda['id'] ?>">Sì</label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- linea separatore da togliere -->
                            <?php if ($domanda['tipo_risposta'] === 'data'): ?>
                                <hr class="border border-primary">
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if($checklist_id == 17):?>
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                            <tr>
                                <th>Ore</th>
                                <th>Temperatura Forno °C</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>08:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>08:30</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>09:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>10:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>11:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>12:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>13:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            <tr>
                                <td>14:00</td>
                                <td><input type="text" class="form-check-input w-50 rounded"></td>
                            </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Invia Risposte</button>
                    </div>

                </form>
            </div>
        </div>

        <?php if (empty($check)): ?>
            <!-- Pulsante per tornare alla lista dei progetti -->
            <div class="mt-4">
                <a href="dashboard_componenti.php?progetto_id=<?= $progetto_id ?>&attivita_id=<?= $attivita_id ?>&ordine_id=<?= $ordine_id ?>&stato=<?= $stato ?>"
                   class="btn btn-primary btn-lg rounded-pill">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
            </div>
        <?php else: ?>
            <!-- Pulsante per tornare alla lista dei progetti -->
            <div class="mt-4 mb-4">
                <a href="dashboard_attività.php?progetto_id=<?= $progetto_id ?>&attivita_id=<?= $attivita_id ?>&ordine_id=<?= $ordine_id ?>&stato=<?= $stato ?>"
                   class="btn btn-primary btn-lg rounded-pill">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



