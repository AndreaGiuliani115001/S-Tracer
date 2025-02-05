<?php

require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domanda_id = $_POST['domanda_id'];
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $operazione_id = $_POST['operazione_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $stato = $_POST['stato'];

    // Elimina la domanda e verifica se ci sono file associati
    if (Domande::delete($conn, $domanda_id)) {
        header('Location: ../../../dashboard_checklist.php?componente_id=' . $componente_id .
            '&operazione_id=' . $operazione_id .
            '&progetto_id=' . $progetto_id .
            '&attivita_id=' . $attivita_id .
            '&linea_produzione_id=' . $linea_produzione_id .
            '&stato=' . $stato .
            '&success=Domanda eliminata con successo');
    } else {
        header('Location: ../../../dashboard_checklist.php?error=Errore durante l\'eliminazione della domanda');
    }
}

