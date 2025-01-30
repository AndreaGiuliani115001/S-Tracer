<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Progetti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $matricola = $_POST['matricola'];
    $CIN = $_POST['CIN'];
    $data_di_consegna = $_POST['data_di_consegna'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $foto = $_FILES['foto'];

    // Gestisci il caricamento della nuova foto (se presente)
    $nomeFoto = null;
    if (!empty($foto['name'])) {
        $fotoPrecedente = Progetti::getFoto($conn, $id);
        if ($fotoPrecedente) {
            $filePathPrecedente = __DIR__ . "/../../../public/assets/uploads/" . $fotoPrecedente;
            if (file_exists($filePathPrecedente)) {
                unlink($filePathPrecedente);
            }
        }

        $nomeFoto = uniqid() . '-' . basename($foto['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $nomeFoto;

        if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
            header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'error=Errore durante il caricamento della nuova foto');
            exit;
        }
    }

    if (Progetti::update($conn, $id, $matricola, $CIN, $data_di_consegna, $stato, $linea_produzione_id, $nomeFoto)) {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'success=Progetto modificato');
    } else {
        header('Location: ../../dashboard_progetti.php?linea_produzione_id='.$linea_produzione_id.'error=Errore durante la modifica');
    }
}
