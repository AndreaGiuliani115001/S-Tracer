<?php

class LineeProduzione
{
    // Recupera tutti gli ordini
    public static function getAll(PDO $conn)
    {
        $query = "SELECT * 
                  FROM linee_produzione 
                  ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFoto($conn, $id) {
        $stmt = $conn->prepare("SELECT foto FROM linee_produzione WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['foto'] : null;
    }


    // Recupera un ordine specifico
    public static function getById(PDO $conn, $id)
    {
        $query = "SELECT *
                  FROM linee_produzione
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Recupera gli ordini associati a un progetto
    public static function getByProgetto(PDO $conn, $progetto_id)
    {
        $query = "SELECT o.* 
                  FROM linee_produzione o
                  WHERE o.id = (SELECT linea_produzione_id FROM progetti WHERE id = :progetto_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':progetto_id', $progetto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($conn, $nome, $foto = null) {
        $stmt = $conn->prepare("INSERT INTO linee_produzione (nome, foto, created_at) VALUES (:nome, :foto, NOW())");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':foto', $foto);
        return $stmt->execute();
    }

    public static function update($conn, $id, $nome, $nomeFoto = null) {
        // Se non è stata caricata una nuova foto, aggiorna solo il nome
        if ($nomeFoto === null) {
            $stmt = $conn->prepare("UPDATE linee_produzione SET nome = :nome WHERE id = :id");
        } else {
            $stmt = $conn->prepare("UPDATE linee_produzione SET nome = :nome, foto = :foto WHERE id = :id");
            $stmt->bindParam(':foto', $nomeFoto);
        }

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function delete(PDO $conn, $id)
    {
        $stmt = $conn->prepare("DELETE FROM linee_produzione WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
