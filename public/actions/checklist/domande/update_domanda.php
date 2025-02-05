<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domanda_id = $_POST['domanda_id'];
    $testo = $_POST['testo'];
    $tipo_risposta = $_POST['tipo_risposta'];
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $operazione_id = $_POST['operazione_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $stato = $_POST['stato'];

    // Gestione del caricamento file
    $file_url = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $target_dir = '../../../assets/uploads/';
        $file_name = basename($_FILES['file']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_url = $file_name;
        }
    }

    // Aggiorna la domanda
    if (Domande::update($conn, $domanda_id, $testo, $tipo_risposta, $file_url)) {
        header('Location: ../../../dashboard_checklist.php?componente_id=' . $componente_id .
            '&operazione_id=' . $operazione_id .
            '&progetto_id=' . $progetto_id .
            '&attivita_id=' . $attivita_id .
            '&linea_produzione_id=' . $linea_produzione_id .
            '&stato=' . $stato .
            '&success=Domanda aggiornata con successo');
    } else {
        header('Location: ../../../dashboard_checklist.php?error=Errore durante l\'aggiornamento della domanda');
    }
}
