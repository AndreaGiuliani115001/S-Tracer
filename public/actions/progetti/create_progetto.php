<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Progetti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricola = $_POST['matricola'];
    $CIN = $_POST['CIN'];
    $data_di_consegna = $_POST['data_di_consegna'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $foto = $_FILES['foto'];

    // Gestisci l’upload della foto
    $nomeFoto = null;
    if (!empty($foto['name'])) {
        $nomeFoto = uniqid() . '-' . basename($foto['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $nomeFoto;

        if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
            header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'error=Errore durante il caricamento della foto');
            exit;
        }
    }

    if (Progetti::create($conn, $matricola, $CIN, $data_di_consegna, $stato, $nomeFoto, $linea_produzione_id)) {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'success=Progetto creato');
    } else {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'error=Errore durante la creazione');
    }
}

