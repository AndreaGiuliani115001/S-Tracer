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


    public static function getByProgetto(PDO $conn, $progetto_id)
    {
        $query = "
        SELECT 
            m.nome AS materiale_nome, 
            m.descrizione AS materiale_descrizione, 
            mc.quantita_utilizzata, 
            m.unita_misura, 
            c.id AS componente_id, 
            c.nome AS componente_nome
        FROM materiali m
        JOIN materiali_componenti mc ON m.id = mc.materiale_id
        JOIN componenti c ON mc.componente_id = c.id
        JOIN componenti_progetti cp ON c.id = cp.componente_id
        WHERE cp.progetto_id = :progetto_id
        ORDER BY c.id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getByComponente($conn, $componente_id)
    {
        $query = "
        SELECT mc.id AS id_materiale_componente, m.id AS materiale_id, 
               m.nome, m.descrizione, mc.quantita_utilizzata, 
               m.unita_misura
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

    public static function update(PDO $conn, $materiale_id, $nome, $descrizione, $quantita_disponibile, $unita_misura, $costo_unitario)
    {
        $query = "UPDATE materiali 
                  SET nome = :nome, descrizione = :descrizione, quantita_disponibile = :quantita_disponibile, 
                      unita_misura = :unita_misura, costo_unitario = :costo_unitario 
                  WHERE id = :materiale_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':quantita_disponibile', $quantita_disponibile);
        $stmt->bindParam(':unita_misura', $unita_misura);
        $stmt->bindParam(':costo_unitario', $costo_unitario);
        $stmt->bindParam(':materiale_id', $materiale_id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public static function delete(PDO $conn, $materiale_id)
    {
        $query = "DELETE FROM materiali WHERE id = :materiale_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':materiale_id', $materiale_id, PDO::PARAM_INT);
        return $stmt->execute();

    }

    public static function getDisponibili(PDO $conn)
    {
        $query = "SELECT id, nome, quantita_disponibile, unita_misura FROM materiali WHERE quantita_disponibile > 0 ORDER BY nome";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(PDO $conn, $materiale_id)
    {
        $query = "SELECT id, nome, quantita_disponibile, unita_misura FROM materiali WHERE id = :materiale_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':materiale_id', $materiale_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function scaricaQuantita(PDO $conn, $materiale_id, $quantita_utilizzata)
    {
        $query = "UPDATE materiali SET quantita_disponibile = quantita_disponibile - :quantita_utilizzata WHERE id = :materiale_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':quantita_utilizzata', $quantita_utilizzata);
        $stmt->bindParam(':materiale_id', $materiale_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function restituisciQuantita(PDO $conn, $materiale_id, $quantita)
    {
        $query = "UPDATE materiali SET quantita_disponibile = quantita_disponibile + :quantita WHERE id = :materiale_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':quantita', $quantita);
        $stmt->bindParam(':materiale_id', $materiale_id);
        return $stmt->execute();
    }




}
