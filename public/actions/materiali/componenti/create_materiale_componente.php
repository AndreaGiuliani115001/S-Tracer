<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $componente_id = $_POST['componente_id'];
    $materiale_id = $_POST['materiale_id'];
    $quantita_utilizzata = $_POST['quantita_utilizzata'];

    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];
    $attivita_id = $_POST['attivita_id'];
    $stato = $_POST['stato'];

    // Verifica della disponibilità del materiale
    $materiale = Materiali::getById($conn, $materiale_id);

    if ($materiale && $materiale['quantita_disponibile'] >= $quantita_utilizzata) {
        // Inserisci nella tabella materiali_componenti
        if (MaterialeComponente::create($conn, $componente_id, $materiale_id, $quantita_utilizzata)) {
            // Aggiorna la quantità disponibile nella tabella materiali
            Materiali::scaricaQuantita($conn, $materiale_id, $quantita_utilizzata);
            header('Location: ../../../dashboard_materiali.php?progetto_id=' . $progetto_id .
                '&linea_produzione_id=' . $linea_produzione_id .
                '&componente_id=' . $componente_id .
                '&attivita_id=' . $attivita_id .
                '&stato=' . $stato .
                '&success=Materiale aggiunto con successo');
        } else {
            header('Location: ../../../dashboard_dashboard_materiali.php?error=Errore durante l\'aggiunta del materiale');
        }
    } else {
        header('Location: ../../../dashboard_materiali.php?error=Quantità insufficiente per il materiale selezionato');
    }
}
