<?php

class Ordini
{
    // Recupera tutti gli ordini
    public static function getAll(PDO $conn)
    {
        $query = "SELECT o.*, p.nome AS progetto_nome 
                  FROM ordini o
                  LEFT JOIN progetti p ON o.id = p.ordine_id
                  ORDER BY o.created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recupera un ordine specifico
    public static function getById(PDO $conn, $id)
    {
        $query = "SELECT o.*, p.nome AS progetto_nome 
                  FROM ordini o
                  LEFT JOIN progetti p ON o.id = p.ordine_id
                  WHERE o.id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Recupera gli ordini associati a un progetto
    public static function getByProgetto(PDO $conn, $progetto_id)
    {
        $query = "SELECT o.* 
                  FROM ordini o
                  WHERE o.id = (SELECT ordine_id FROM progetti WHERE id = :progetto_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserisce un nuovo ordine
    public static function create(PDO $conn, $numero_ordine, $matricola, $data_di_consegna, $ddt)
    {
        $query = "INSERT INTO ordini (numero_ordine, matricola, data_di_consegna, ddt) 
                  VALUES (:numero_ordine, :matricola, :data_di_consegna, :ddt)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':numero_ordine', $numero_ordine);
        $stmt->bindParam(':matricola', $matricola);
        $stmt->bindParam(':data_di_consegna', $data_di_consegna);
        $stmt->bindParam(':ddt', $ddt);
        return $stmt->execute();
    }
}
