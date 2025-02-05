<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materiale_componente = $_POST['id_materiale_componente'];
    $quantita_utilizzata = $_POST['quantita_utilizzata'];
    $materiale_id = $_POST['materiale_id'];

    // Recupera i parametri per il reindirizzamento
    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $componente_id = $_POST['componente_id'];
    $attivita_id = $_POST['attivita_id'];
    $stato = $_POST['stato'];

    try {
        // Inizio transazione
        $conn->beginTransaction();

        // Restituisci la quantità al magazzino
        Materiali::restituisciQuantita($conn, $materiale_id, $quantita_utilizzata);

        // Elimina la relazione utilizzando il metodo della classe
        MaterialeComponente::deleteById($conn, $id_materiale_componente);

        // Conferma la transazione
        $conn->commit();

        header("Location: ../../../dashboard_materiali.php?success=Materiale eliminato con successo&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
    } catch (Exception $e) {
        // Rollback in caso di errore
        $conn->rollBack();
        header("Location: ../../../dashboard_materiali.php?error=Errore durante l'eliminazione del materiale&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
    }
}
