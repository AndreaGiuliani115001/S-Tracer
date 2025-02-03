<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Componenti.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $progetto_id = $_POST['progetto_id'];
    $attivita_id = $_POST['attivita_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    $fotoNome = null;

    // Carica la foto del componente
    if (!empty($_FILES['foto']['name'])) {
        $fotoNome = uniqid() . '-' . basename($_FILES['foto']['name']);
        $targetDir = __DIR__ . '/../../../public/assets/uploads/';
        $targetFile = $targetDir . $fotoNome;
        move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile);
    }

    // Crea il componente
    $componente_id = Componenti::create($conn, $nome, $descrizione, $fotoNome);

    if ($componente_id) {
        // Associa il componente al progetto
        $stmt = $conn->prepare("INSERT INTO componenti_progetti (componente_id, progetto_id, created_at) VALUES (:componente_id, :progetto_id, NOW())");
        $stmt->bindParam(':componente_id', $componente_id);
        $stmt->bindParam(':progetto_id', $progetto_id);
        $stmt->execute();

        // Associa il componente all’attività
        $stmt = $conn->prepare("INSERT INTO componenti_attivita (componente_id, attivita_id, created_at) VALUES (:componente_id, :attivita_id, NOW())");
        $stmt->bindParam(':componente_id', $componente_id);
        $stmt->bindParam(':attivita_id', $attivita_id);
        $stmt->execute();

        header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&success=Componente creato');
    } else {
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&error=Errore durante la creazione');
    }
}
