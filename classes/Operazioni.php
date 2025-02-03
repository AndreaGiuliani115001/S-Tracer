<?php

class Operazioni
{
    // Recupera tutti i componenti associati a una specifica attività
    public static function getByComponente(PDO $conn, $componente_id)
    {
        $query = "
            SELECT *
            FROM operazioni o
            INNER JOIN componenti_operazioni co ON o.id = co.operazione_id
            WHERE co.componente_id = :componente_id
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':componente_id', $componente_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($conn, $nome, $descrizione, $attivita_id)
    {
        $stmt = $conn->prepare("INSERT INTO operazioni (nome, descrizione, attivita_id) VALUES (:nome, :descrizione, :attivita_id)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':attivita_id', $attivita_id);
        $stmt->execute();
        return $conn->lastInsertId();  // Restituisce l'ID della nuova operazione
    }

    public static function delete($conn, $id)
    {
        $stmt = $conn->prepare("DELETE FROM operazioni WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // classes/Operazioni.php
    public static function update(PDO $conn, $id, $nome, $descrizione)
    {
        $query = "UPDATE operazioni SET nome = :nome, descrizione = :descrizione WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


}