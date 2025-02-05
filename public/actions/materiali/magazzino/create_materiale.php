<?php
require_once '../../../../config/config.php';
require_once '../../../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $quantita_disponibile = $_POST['quantita_disponibile'];
    $unita_misura = $_POST['unita_misura'];
    $costo_unitario = $_POST['costo_unitario'];

    // Creazione del nuovo materiale
    if (Materiali::create($conn, $nome, $descrizione, $quantita_disponibile, $unita_misura, $costo_unitario)) {
        header('Location: ../../../magazzino.php?success=Materiale creato con successo');
    } else {
        header('Location: ../../../magazzino.php?error=Errore durante la creazione del materiale');
    }
}
