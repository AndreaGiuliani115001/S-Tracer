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
}