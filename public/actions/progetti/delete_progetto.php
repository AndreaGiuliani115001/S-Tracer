<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Progetti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    // Recupera il nome della foto associata al progetto e la elimina se esiste
    $foto = Progetti::getFoto($conn, $id);
    if ($foto) {
        $filePath = __DIR__ . "/../../../public/assets/uploads/" . $foto;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Elimina il progetto
    if (Progetti::delete($conn, $id)) {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'success=Progetto eliminato');
    } else {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'error=Errore durante l\'eliminazione');
    }
}
