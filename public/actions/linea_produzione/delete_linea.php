<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/LineeProduzione.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $foto = LineeProduzione::getFoto($conn, $id);

    // Elimina la foto precedente se esiste
    if ($foto) {
        $filePath = __DIR__ . "/../../../public/assets/uploads/" . $foto;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    if (LineeProduzione::delete($conn, $id)) {
        header('Location: ../../dashboard.php?success=Eliminazione completata');
    } else {
        header('Location: ../../dashboard.php?error=Errore durante l\'eliminazione');
    }
}
