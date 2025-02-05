<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materiale_id = $_POST['materiale_id'];

    // Elimina il materiale dal database
    if (Materiali::delete($conn, $materiale_id)) {
        header('Location: ../../../magazzino.php?success=Materiale eliminato con successo');
    } else {
        header('Location: ../../../magazzino.php?error=Errore durante l\'eliminazione del materiale');
    }
}
