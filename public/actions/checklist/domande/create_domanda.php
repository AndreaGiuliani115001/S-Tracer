<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checklist_id = $_POST['checklist_id'];
    $testo = $_POST['testo'];
    $tipo_risposta = $_POST['tipo_risposta'];
    $file_url = null;  // Di default è nullo, nel caso in cui non venga caricato nessun file
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $operazione_id = $_POST['operazione_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];


    // Gestione upload file se presente
    if (!empty($_FILES['file']['name'])) {


        $upload_dir = '../../../assets/uploads/';
        $file_name = time() . '-' . basename($_FILES['file']['name']);
        $target_file = $upload_dir . $file_name;


        // Sposta il file nella directory di destinazione
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_url = $file_name;  // Salviamo solo il nome del file nel DB
        } else {
            header('Location: ../../../dashboard_checklist.php?checklist_id=' . $checklist_id . '&error=Errore durante il caricamento del file');
            exit;
        }
    }

    // Inserisci la nuova domanda
    if (Domande::create($conn, $testo, $tipo_risposta, $file_url, $checklist_id)) {
        header('Location: ../../../dashboard_checklist.php?checklist_id=' . $checklist_id . '&progetto_id=' . $progetto_id .
            '&attivita_id=' . $attivita_id .
            '&linea_produzione_id=' . $linea_produzione_id .
            '&stato=' . $stato . '&componente_id=' . $componente_id . '&operazione_id=' . $operazione_id . '&success=Domanda creata');
    } else {
        header('Location: ../../../dashboard_checklist.php?checklist_id=' . $checklist_id . '&error=Errore durante la creazione della domanda');
    }
}
