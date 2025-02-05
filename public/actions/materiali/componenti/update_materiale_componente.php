<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materiale_componente = $_POST['id_materiale_componente'];
    $nuova_quantita_utilizzata = $_POST['quantita_utilizzata'];

    // Recupera i parametri per il reindirizzamento
    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $componente_id = $_POST['componente_id'];
    $attivita_id = $_POST['attivita_id'];
    $stato = $_POST['stato'];

    // Recupera la quantità attuale e il materiale associato
    $relazione = MaterialeComponente::getById($conn, $id_materiale_componente);
    $quantita_attuale = $relazione['quantita_utilizzata'];
    $materiale_id = $relazione['materiale_id'];

    // Calcola la differenza tra la nuova quantità e quella attuale
    $differenza = $nuova_quantita_utilizzata - $quantita_attuale;

    if ($differenza > 0) {
        // Stiamo aumentando la quantità utilizzata
        $materiale = Materiali::getById($conn, $materiale_id);
        if ($materiale['quantita_disponibile'] >= $differenza) {
            MaterialeComponente::updateQuantita($conn, $id_materiale_componente, $nuova_quantita_utilizzata);
            Materiali::scaricaQuantita($conn, $materiale_id, $differenza);
            header("Location: ../../../dashboard_materiali.php?success=Quantità aggiornata con successo&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
        } else {
            header("Location: ../../../dashboard_materiali.php?error=Quantità insufficiente nel magazzino&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
        }
    } elseif ($differenza < 0) {
        // Stiamo diminuendo la quantità utilizzata
        MaterialeComponente::updateQuantita($conn, $id_materiale_componente, $nuova_quantita_utilizzata);
        Materiali::restituisciQuantita($conn, $materiale_id, abs($differenza));
        header("Location: ../../../dashboard_materiali.php?success=Quantità aggiornata con successo&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
    } else {
        header("Location: ../../../dashboard_materiali.php?info=Nessuna modifica effettuata&progetto_id=$progetto_id&linea_produzione_id=$linea_produzione_id&componente_id=$componente_id&attivita_id=$attivita_id&stato=$stato");
    }
}
