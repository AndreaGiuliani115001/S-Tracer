<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Attività.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $stato = $_POST['stato'];

    // Elimina l'attività e il collegamento dalla tabella progetti_attivita (se esiste)
    if (Attività::delete($conn, $id)) {
        $stmt = $conn->prepare("DELETE FROM progetti_attivita WHERE attivita_id = :attivita_id");
        $stmt->bindParam(':attivita_id', $id);
        $stmt->execute();

        header('Location: ../../dashboard_attivita.php?progetto_id=' . $progetto_id . '&linea_produzione_id=' . $linea_produzione_id . '&stato='. $stato .'&success=Attività eliminata');
    } else {
        header('Location: ../../dashboard_attivita.php?progetto_id=' . $progetto_id . '&linea_produzione_id=' . $linea_produzione_id . '&stato='.$stato .'&error=Errore durante l\'eliminazione');
    }
    exit;
}
