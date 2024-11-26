<?php

class Materiali
{
    // Recupera tutti i materiali
    public static function getAll(PDO $conn)
    {
        $query = "SELECT * FROM materiali";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recupera i materiali associati a un componente specifico
    public static function getByProgetto(PDO $conn, $progetto_id)
    {
        $query = "
            SELECT m.nome, m.descrizione, mp.quantita_utilizzata, m.unita_misura, m.costo_unitario
            FROM materiali m
            JOIN materiali_progetti mp ON m.id = mp.materiale_id
            WHERE mp.progetto_id = :progetto_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByComponente($conn, $componente_id) {
        $query = "
            SELECT m.nome, m.descrizione, mc.quantita_utilizzata, m.unita_misura, m.costo_unitario 
                   FROM materiali m
                   JOIN materiali_componenti mc ON m.id = mc.materiale_id 
            WHERE mc.componente_id = :componente_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componente_id', $componente_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserisce un nuovo materiale
    public static function create(PDO $conn, $nome, $descrizione, $quantita_disponibile, $unita_misura, $costo_unitario)
    {
        $query = "
            INSERT INTO materiali (nome, descrizione, quantita_disponibile, unita_misura, costo_unitario)
            VALUES (:nome, :descrizione, :quantita_disponibile, :unita_misura, :costo_unitario)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':quantita_disponibile', $quantita_disponibile);
        $stmt->bindParam(':unita_misura', $unita_misura);
        $stmt->bindParam(':costo_unitario', $costo_unitario);
        return $stmt->execute();
    }


}
