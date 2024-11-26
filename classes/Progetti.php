<?php
class Progetti {

    public static function getAll($conn) {
        $query = "SELECT * FROM progetti";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($conn, $id) {
        $query = "SELECT * FROM progetti WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByOrdine($conn, $ordine_id)
    {
        $query = "SELECT * FROM progetti WHERE ordine_id = :ordine_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':ordine_id', $ordine_id, PDO::PARAM_INT); // Corretto il nome del placeholder e parametro
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function save($conn) {
        $query = "INSERT INTO progetti (matricola, nome, descrizione, foto) VALUES (:matricola, :nome, :descrizione, :foto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':matricola', $this->matricola);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descrizione', $this->descrizione);
        $stmt->bindParam(':foto', $this->foto);
        $stmt->execute();
    }

    // Getter e Setter (opzionale)
}
