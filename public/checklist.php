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

// Recupera l'ID della checklist
$checklist_id = $_GET['checklist_id'] ?? null;

// Recupera gli ID di attività e progetto passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;

// Recupera lo stato passato tramite GET
$stato = $_GET['stato'] ?? null;
$componente_id = $_GET['componente_id'];
$operazione_id = $_GET['operazione_id'];
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;


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
    <title><?= htmlspecialchars($checklist['nome']) ?></title>
</head>
<body>
<div class="full-screen-container">
    <div class="container mt-4">
        <!-- Card Principale della Checklist -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><?= htmlspecialchars($checklist['nome']) ?></h3>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-4"><?= htmlspecialchars($checklist['descrizione']) ?></h6>

                <form action="actions/submit_checklist.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>&componente_id=<?= $componente_id ?>&operazione_id=<?= $operazione_id ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="checklist_id" value="<?= $checklist_id ?>">

                    <?php $responses = []; ?>
                    <div class="mb-4">
                        <?php foreach ($domande as $domanda): ?>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM risposte WHERE domanda_id = :domanda_id");
                            $stmt->bindValue(':domanda_id', $domanda['id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $responses[$domanda['id']] = $stmt->fetch(PDO::FETCH_ASSOC);

                            ?>
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($domanda['testo']) ?></h5>
                                    <?php
                                    $response = $responses[$domanda['id']] ?? null;
                                    $is_completed = !empty($response);
                                    ?>
                                    <?php if(!empty($domanda['file_url'])): ?>
                                        <a href="assets/uploads/<?= htmlspecialchars($domanda['file_url']) ?>"
                                           target="_blank">Visualizza
                                            file</a>
                                    <?php endif;?>
                                    <!-- Input Dinamico -->
                                    <?php if ($domanda['tipo_risposta'] === 'testo'): ?>
                                        <textarea name="risposte[<?= $domanda['id'] ?>]" id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2" rows="3" <?= $is_completed ? 'disabled' : '' ?>><?= htmlspecialchars($response['testo'] ?? '') ?></textarea>
                                    <?php elseif ($domanda['tipo_risposta'] === 'file'): ?>
                                        <?php if ($is_completed): ?>
                                            <a href="<?= htmlspecialchars('assets/uploads/' . $response['file_url']) ?>" target="_blank">Visualizza file</a>
                                        <?php else: ?>
                                            <input type="file" name="risposte[<?= $domanda['id'] ?>]" id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2">
                                        <?php endif; ?>
                                    <?php elseif ($domanda['tipo_risposta'] === 'data'): ?>
                                        <input type="date" name="risposte[<?= $domanda['id'] ?>]" id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2" value="<?= htmlspecialchars($response['testo'] ?? '') ?>" <?= $is_completed ? 'disabled' : '' ?>>
                                    <?php elseif ($domanda['tipo_risposta'] === 'numero'): ?>
                                        <input type="number" name="risposte[<?= $domanda['id'] ?>]" id="domanda_<?= $domanda['id'] ?>" class="form-control mt-2" value="<?= htmlspecialchars($response['testo'] ?? '') ?>" <?= $is_completed ? 'disabled' : '' ?>>
                                    <?php elseif ($domanda['tipo_risposta'] === 'booleano'): ?>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="risposte[<?= $domanda['id'] ?>]" id="domanda_<?= $domanda['id'] ?>" value="1" class="form-check-input" <?= (!empty($response['testo']) && $response['testo'] === '1') ? 'checked' : '' ?> <?= $is_completed ? 'disabled' : '' ?>>
                                            <label class="form-check-label" for="domanda_<?= $domanda['id'] ?>">Sì</label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Invia Risposte</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Pulsante per tornare alla lista dei progetti -->
        <div class="mt-4 mb-4">
            <a href="dashboard_checklist.php?progetto_id=<?= $progetto_id ?>&linea_produzione_id=<?= $linea_produzione_id ?>&stato=<?= $stato ?>&attivita_id=<?= $attivita_id ?>&componente_id=<?= $componente_id ?>&operazione_id=<?= $operazione_id ?>" class="btn btn-primary btn-lg rounded-pill">
                <i class="fas fa-arrow-left text-white"></i>
            </a>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
</body>
</html>
