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

    public static function create($conn, $nome, $descrizione, $foto) {
        $stmt = $conn->prepare("INSERT INTO componenti (nome, descrizione, foto, created_at) VALUES (:nome, :descrizione, :foto, NOW())");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':foto', $foto);

        if ($stmt->execute()) {
            return $conn->lastInsertId();  // Restituisce l'ID del componente appena creato
        }

        return false;
    }

    public static function update($conn, $id, $nome, $descrizione, $foto = null) {
        $sql = "UPDATE componenti SET nome = :nome, descrizione = :descrizione";

        if ($foto !== null) {
            $sql .= ", foto = :foto";
        }

        $sql .= " WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descrizione', $descrizione);
        $stmt->bindParam(':id', $id);

        if ($foto !== null) {
            $stmt->bindParam(':foto', $foto);
        }

        return $stmt->execute();
    }

    public static function getFoto($conn, $id) {
        $stmt = $conn->prepare("SELECT foto FROM componenti WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['foto'] : null;
    }

    public static function delete($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM componenti WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


}
