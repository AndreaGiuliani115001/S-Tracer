<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../classes/Operazioni.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $attivita_id = $_POST['attivita_id'];
    $componente_id = $_POST['componente_id'];
    $progetto_id = $_POST['progetto_id'];
    $stato = $_POST['stato'];
    $linea_produzione_id = $_POST['linea_produzione_id'];

    try {
        $conn->beginTransaction();

        // Crea l'operazione
        $operazione_id = Operazioni::create($conn, $nome, $descrizione, $attivita_id);

        // Associa l'operazione al componente
        $stmt = $conn->prepare("INSERT INTO componenti_operazioni (componente_id, operazione_id, created_at) VALUES (:componente_id, :operazione_id, NOW())");
        $stmt->bindParam(':componente_id', $componente_id);
        $stmt->bindParam(':operazione_id', $operazione_id);
        $stmt->execute();

        $conn->commit();
        header('Location: ../../dashboard_componenti.php?progetto_id=' . $progetto_id . '&attivita_id=' . $attivita_id . '&stato=' . $stato . '&linea_produzione_id=' . $linea_produzione_id . '&success=Operazione creata');
    } catch (Exception $e) {
        $conn->rollBack();
        die('Errore: ' . $e->getMessage());
    }
}
