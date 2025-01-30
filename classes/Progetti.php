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

    public static function getByLineaProduzione($conn, $linea_produzione_id)
    {
        $query = "SELECT * FROM progetti WHERE linea_produzione_id = :linea_produzione_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':linea_produzione_id', $linea_produzione_id, PDO::PARAM_INT); // Corretto il nome del placeholder e parametro
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFoto($conn, $id) {
        $stmt = $conn->prepare("SELECT foto FROM progetti WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['foto'] : null;
    }


    public static function create($conn, $matricola, $CIN, $data_di_consegna, $stato, $foto, $linea_produzione_id) {
        $stmt = $conn->prepare("INSERT INTO progetti (matricola, CIN, data_di_consegna, stato, foto, created_at, linea_produzione_id)
                                VALUES (:matricola, :CIN, :data_di_consegna, :stato, :foto, NOW(), :linea_produzione_id)");
        $stmt->bindParam(':matricola', $matricola);
        $stmt->bindParam(':CIN', $CIN);
        $stmt->bindParam(':data_di_consegna', $data_di_consegna);
        $stmt->bindParam(':stato', $stato);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':linea_produzione_id', $linea_produzione_id);
        return $stmt->execute();
    }

    public static function update($conn, $id, $matricola, $CIN, $data_di_consegna, $stato, $linea_produzione_id, $foto = null) {
        if ($foto === null) {
            $stmt = $conn->prepare("UPDATE progetti SET matricola = :matricola, CIN = :CIN, data_di_consegna = :data_di_consegna, stato = :stato, linea_produzione_id = :linea_produzione_id WHERE id = :id");
        } else {
            $stmt = $conn->prepare("UPDATE progetti SET matricola = :matricola, CIN = :CIN, data_di_consegna = :data_di_consegna, stato = :stato, linea_produzione_id = :linea_produzione_id, foto = :foto WHERE id = :id");
            $stmt->bindParam(':foto', $foto);
        }

        $stmt->bindParam(':matricola', $matricola);
        $stmt->bindParam(':CIN', $CIN);
        $stmt->bindParam(':data_di_consegna', $data_di_consegna);
        $stmt->bindParam(':stato', $stato);
        $stmt->bindParam(':linea_produzione_id', $linea_produzione_id);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function delete($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM progetti WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
