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
    public static function create($conn, $nome, $descrizione, $stato) {
        $stmt = $conn->prepare("INSERT INTO attivita (nome, descrizione, stato, created_at) VALUES (:nome, :descrizione, :stato, NOW())");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':stato', $stato);

        if ($stmt->execute()) {
            return $conn->lastInsertId();  // Restituisce l’ID dell’attività appena creata
        }

        return false;
    }

    public static function update($conn, $id, $nome, $descrizione, $stato) {
        $stmt = $conn->prepare("UPDATE attivita SET nome = :nome, descrizione = :descrizione, stato = :stato WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':stato', $stato);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function delete($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM attivita WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


}