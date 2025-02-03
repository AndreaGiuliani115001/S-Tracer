<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Operazioni.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    try {

        $conn->beginTransaction();

        // Elimina l'operazione
        if (Operazioni::delete($conn, $id)) {
            $conn->commit();
            header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&success=Operazione eliminata');
        } else {
            $conn->rollBack();
            header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&error=Errore durante l\'eliminazione');
        }
    } catch (Exception $e) {
        $conn->rollBack();
        die('Errore: ' . $e->getMessage());
    }
}
