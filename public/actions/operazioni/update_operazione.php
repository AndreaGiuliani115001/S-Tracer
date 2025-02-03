<?php
require_once '../../../config/config.php';
require_once '../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];


    if (Operazioni::update($conn, $id, $nome, $descrizione)) {
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $_POST['progetto_id'] . '&attivita_id=' . $_POST['attivita_id'] . '&componente_id=' . $_POST['componente_id'] . '&stato=' . $_POST['stato'] . '&linea_produzione_id=' . $_POST['linea_produzione_id'] . '&success=Operazione aggiornata');
    } else {
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $_POST['progetto_id'] . '&attivita_id=' . $_POST['attivita_id'] . '&componente_id=' . $_POST['componente_id'] . '&stato=' . $_POST['stato'] . '&linea_produzione_id=' . $_POST['linea_produzione_id'] . '&error=Errore durante l\'aggiornamento dell\'operazione');
    }
}
