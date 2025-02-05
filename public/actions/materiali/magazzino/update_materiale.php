<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materiale_id = $_POST['materiale_id'];
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $quantita_disponibile = $_POST['quantita_disponibile'];
    $unita_misura = $_POST['unita_misura'];
    $costo_unitario = $_POST['costo_unitario'];

    // Aggiorna il materiale
    if (Materiali::update($conn, $materiale_id, $nome, $descrizione, $quantita_disponibile, $unita_misura, $costo_unitario)) {
        header('Location: ../../../magazzino.php?success=Materiale aggiornato con successo');
    } else {
        header('Location: ../../../magazzino.php?error=Errore durante l\'aggiornamento del materiale');
    }
}
