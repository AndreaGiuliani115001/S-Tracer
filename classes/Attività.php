<?php

class Attività
{
    // Recupera tutte le attività
    public static function getAll(PDO $conn)
    {
        $query = "SELECT * FROM attivita ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByProgetto(PDO $conn, $progetto_id, $stato)
    {
        $query = "
        SELECT a.*
        FROM attivita a
        JOIN progetti_attivita pa ON a.id = pa.attivita_id
        WHERE pa.progetto_id = :progetto_id AND a.stato = :stato
        ORDER BY a.created_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->bindParam(':stato', $stato, PDO::PARAM_STR); // Assumi che stato sia un intero
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Inserisce una nuova attività
    public static function create(PDO $conn, $nome, $descrizione)
    {
        $query = "INSERT INTO attivita (nome, descrizione) VALUES (:nome, :descrizione)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        return $stmt->execute();
    }
}