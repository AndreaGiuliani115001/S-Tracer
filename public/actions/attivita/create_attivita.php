<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Attività.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $stato = $_POST['stato'];
    $progetto_id = $_POST['progetto_id'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    // Crea l’attività
    $attivita_id = Attività::create($conn, $nome, $descrizione, $stato);

    if ($attivita_id) {
        // Se esiste un progetto_id, crea il collegamento nella tabella progetti_attivita
        if ($progetto_id) {
            $stmt = $conn->prepare("INSERT INTO progetti_attivita (progetto_id, attivita_id, created_at) VALUES (:progetto_id, :attivita_id, NOW())");
            $stmt->bindParam(':progetto_id', $progetto_id);
            $stmt->bindParam(':attivita_id', $attivita_id);
            $stmt->execute();
        }

        header('Location: ../../dashboard_attivita.php?progetto_id='.$progetto_id.'&linea_produzione_id='.$linea_produzione_id.'&stato='.$stato.'&success=Attività creata');
    } else {
        header('Location: ../../dashboard_attivita.php?progetto_id='.$progetto_id.'&linea_produzione_id='.$linea_produzione_id.'&stato='.$stato.'&error=Errore durante la creazione');
    }
}
