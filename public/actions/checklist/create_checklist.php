<?php
require_once '../../../config/config.php';
require_once '../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupero dei dati dal form POST
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $componente_operazione_id = $_POST['componente_operazione_id'];
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $operazione_id = $_POST['operazione_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    // Creazione della checklist tramite la classe Checklist
    if (Checklist::create($conn, $nome, $descrizione, $componente_operazione_id)) {
        // Reindirizzamento corretto con tutti i valori necessari
        header('Location: ../../dashboard_checklist.php?componente_id=' . $componente_id .
            '&operazione_id=' . $operazione_id .
            '&progetto_id=' . $progetto_id .
            '&attivita_id=' . $attivita_id .
            '&linea_produzione_id=' . $linea_produzione_id .
            '&stato=' . $stato .
            '&success=Checklist creata');
    } else {
        header('Location: ../../dashboard_checklist.php?error=Errore durante la creazione della checklist');
    }
}
