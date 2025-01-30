<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/LineeProduzione.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $foto = $_FILES['foto'];

    // Gestisci l’upload della foto (se presente)
    $nomeFoto = null;
    if (!empty($foto['name'])) {
        // Genera un nome unico per la foto
        $nomeFoto = uniqid() . '-' . basename($foto['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $nomeFoto;

        // Sposta il file nella directory di upload
        if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
            header('Location: ../../dashboard.php?error=Errore durante il caricamento della foto');
            exit;
        }
    }

    // Crea la nuova linea di produzione
    if (LineeProduzione::create($conn, $nome, $nomeFoto)) {
        header('Location: ../../dashboard.php?success=Linea di produzione creata');
    } else {
        header('Location: ../../dashboard.php?error=Errore durante la creazione');
    }
}
