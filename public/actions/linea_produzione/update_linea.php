<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/LineeProduzione.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $foto = $_FILES['foto'];

    // Controlla se è stata caricata una nuova foto
    $nomeFoto = null;
    if (!empty($foto['name'])) {
        // Recupera il nome della foto precedente
        $fotoPrecedente = LineeProduzione::getFoto($conn, $id);

        // Elimina la foto precedente se esiste
        if ($fotoPrecedente) {
            $filePathPrecedente = __DIR__ . "/../../../public/assets/uploads/" . $fotoPrecedente;
            if (file_exists($filePathPrecedente)) {
                unlink($filePathPrecedente);
            }
        }

        // Genera un nome unico per la nuova foto
        $nomeFoto = uniqid() . '-' . basename($foto['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $nomeFoto;

        // Sposta il file nella directory di upload
        if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
            header('Location: ../../dashboard.php?error=Errore durante il caricamento della nuova foto');
            exit;
        }
    }

    // Aggiorna i dati nel database
    if (LineeProduzione::update($conn, $id, $nome, $nomeFoto)) {
        header('Location: ../../dashboard.php?success=Modifica completata');
    } else {
        header('Location: ../../dashboard.php?error=Errore durante la modifica');
    }
}
