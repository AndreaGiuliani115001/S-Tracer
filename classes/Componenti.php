<?php

class Componenti
{
    // Recupera tutti i componenti associati a una specifica attività
    public static function getByAttivita(PDO $conn, $attivita_id)
    {
        $query = "SELECT c.*, p.nome AS progetto_nome 
                  FROM componenti c
                  JOIN componenti_attivita ca ON c.id = ca.componente_id
                  JOIN progetti p ON c.progetto_id = p.id
                  WHERE ca.attivita_id = :attivita_id
                  ORDER BY c.created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':attivita_id', $attivita_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recupera tutti i componenti associati a una specifica attività e progetto
    public static function getByAttivitaEProgetto(PDO $conn, $attivita_id, $progetto_id)
    {
        $query = "
            SELECT DISTINCT *
            FROM componenti c
            INNER JOIN componenti_progetti cp ON c.id = cp.componente_id
            INNER JOIN progetti_attivita pa ON cp.progetto_id = pa.progetto_id
            INNER JOIN componenti_attivita ca ON c.id = ca.componente_id
            WHERE cp.progetto_id = :progetto_id 
              AND pa.attivita_id = :attivita_id
              AND ca.attivita_id = :attivita_id
        ";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->bindValue(':attivita_id', $attivita_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public
static function getComponentiOperazioniChecklist($conn, $attivita_id, $progetto_id)
{
    $query = "
            SELECT c.id AS componente_id, 
                   c.nome AS componente_nome, 
                   o.id AS operazione_id, 
                   o.nome AS operazione_nome, 
                   cl.id AS checklist_id, 
                   cl.nome AS checklist_nome
            FROM componenti_operazioni co
            JOIN componenti c ON co.componente_id = c.id
            JOIN operazioni o ON co.operazione_id = o.id
            LEFT JOIN checklist cl ON co.checklist_id = cl.id
            WHERE o.attivita_id = :attivita_id
              AND c.progetto_id = :progetto_id
            ORDER BY c.id, o.id;
        ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':attivita_id', $attivita_id, PDO::PARAM_INT);
    $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
