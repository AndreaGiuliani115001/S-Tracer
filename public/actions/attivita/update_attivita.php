<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Attività.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $stato = $_POST['stato'];
    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    if (Attività::update($conn, $id, $nome, $descrizione, $stato)) {
        header('Location: ../../dashboard_attivita.php?progetto_id='.$progetto_id.'&linea_produzione_id='.$linea_produzione_id.'&stato='.$stato.'&success=Attività modificata');
    } else {
        header('Location: ../../dashboard_attivita.php?progetto_id='.$progetto_id.'&linea_produzione_id='.$linea_produzione_id.'&stato='.$stato.'&error=Errore durante la modifica');
    }
}
