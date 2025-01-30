<?php
session_start();
require_once '../../config/config.php';
require_once '../../autoload.php';

// Recupera i dati inviati dal form
$checklist_id = $_POST['checklist_id'];
$risposte = $_POST['risposte'] ?? [];
$uploaded_files = $_FILES['risposte'] ?? [];


// Recupera gli ID di attività e progetto passati tramite GET
$attivita_id = $_GET['attivita_id'] ?? null;
$progetto_id = $_GET['progetto_id'] ?? null;
$stato = $_GET['stato'] ?? null;
$componente_id = $_GET['componente_id'];
$operazione_id = $_GET['operazione_id'];
$linea_produzione_id = $_GET['linea_produzione_id'] ?? null;


// Controlla se la checklist esiste
$checklist_data = Checklist::getByIdWithQuestions($conn, $checklist_id);
if (!$checklist_data) {
    die('Checklist non trovata.');
}

// Percorso alla directory di upload
$upload_dir = __DIR__ . '/../assets/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true); // Crea la directory se non esiste
}

// Itera sulle domande della checklist
foreach ($checklist_data['domande'] as $domanda) {
    $domanda_id = $domanda['id'];

    // Controlla se esiste già una risposta
    $stmt = $conn->prepare("SELECT * FROM risposte WHERE domanda_id = :domanda_id");
    $stmt->bindValue(':domanda_id', $domanda_id, PDO::PARAM_INT);
    $stmt->execute();
    $existing_response = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_response) {
        continue; // Salta se esiste già una risposta
    }

    // Recupera il testo della risposta
    $risposta_testo = $risposte[$domanda_id] ?? null;
    $file_url = null;


    // Gestisci il caricamento del file
    if (isset($_FILES['risposte']['name'][$domanda_id]) && !empty($_FILES['risposte']['name'][$domanda_id])) {
        $file_tmp = $_FILES['risposte']['tmp_name'][$domanda_id];
        $original_file_name = $_FILES['risposte']['name'][$domanda_id];
        $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
        $file_name = md5(uniqid()) . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;


        if (move_uploaded_file($file_tmp, $file_path)) {
            $file_url = $file_name;
        } else {
            die("Errore durante il caricamento del file: $original_file_name");
        }
    }

    // Salta se non c'è né testo né file
    if (empty($risposta_testo) && empty($file_url)) {
        continue;
    }


    // Inserisci la risposta nel database
    $stmt = $conn->prepare("
        INSERT INTO risposte (testo, file_url, domanda_id, created_at)
        VALUES (:testo, :file_url, :domanda_id, NOW())
    ");
    $stmt->bindValue(':testo', $risposta_testo, PDO::PARAM_STR);
    $stmt->bindValue(':file_url', $file_url, PDO::PARAM_STR);
    $stmt->bindValue(':domanda_id', $domanda_id, PDO::PARAM_INT);
    $stmt->execute();

}

// Reindirizza l'utente alla pagina della checklist
header("Location: ../checklist.php?progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&stato=$stato&attivita_id=$attivita_id&componente_id=$componente_id&operazione_id=$operazione_id&checklist_id=$checklist_id");
exit;
