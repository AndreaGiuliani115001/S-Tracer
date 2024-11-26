<?php
require_once '../config/config.php';
require_once '../autoload.php';

try {
    // Test 1: Recuperare tutti i componenti
    $componenti = Progetti::getAll($conn);
    echo "Test 1: Recuperare tutti i componenti:\n";
    print_r($componenti);

    // Test 2: Inserire un nuovo componente
    echo "Test 2: Inserire un nuovo componente:\n";
    Progetti::insert($conn, 'MATR001', 'Motore', 'Motore per imbarcazioni', 'motore.jpg');
    echo "Progetti inserito con successo.\n";

    // Test 3: Recuperare componente per ID
    echo "Test 3: Recuperare componente per ID:\n";
    $componente = Progetti::getById($conn, 1);
    print_r($componente);

    // Test 4: Aggiornare un componente
    echo "Test 4: Aggiornare un componente:\n";
    Progetti::update($conn, 1, 'MATR001', 'Motore Aggiornato', 'Motore aggiornato per imbarcazioni', 'motore_agg.jpg');
    echo "Progetti aggiornato con successo.\n";

    // Test 5: Eliminare un componente
    echo "Test 5: Eliminare un componente:\n";
    Progetti::delete($conn, 1);
    echo "Progetti eliminato con successo.\n";

} catch (Exception $e) {
    echo "Errore durante il test: " . $e->getMessage();
}

