<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Componenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    var_dump('id: '. $id);
    $nome = $_POST['nome'];
    var_dump('nome: ' . $nome);
    $descrizione = $_POST['descrizione'];
    var_dump('descrizione: '. $descrizione);
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    // Se è stata caricata una nuova foto, salviamo quella nuova
    $fotoNome = null;
    if (!empty($_FILES['foto']['name'])) {
        // Elimina la vecchia foto se esiste
        $oldFoto = Componenti::getFoto($conn, $id);
        if ($oldFoto) {
            $oldFilePath = __DIR__ . "/../../../public/assets/uploads/" . $oldFoto;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Carica la nuova foto
        $fotoNome = uniqid() . '-' . basename($_FILES['foto']['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $fotoNome;
        move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile);
    }

    // Aggiorna il componente
    if (Componenti::update($conn, $id, $nome, $descrizione, $fotoNome)) {
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&success=Componente aggiornato');
    } else {
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&error=Errore durante l\'aggiornamento');
    }
}
