<?php

class MaterialeComponente
{
    public static function create(PDO $conn, $componente_id, $materiale_id, $quantita_utilizzata)
    {
        $query = "INSERT INTO materiali_componenti (componente_id, materiale_id, quantita_utilizzata, created_at) 
                  VALUES (:componente_id, :materiale_id, :quantita_utilizzata, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componente_id', $componente_id, PDO::PARAM_INT);
        $stmt->bindParam(':materiale_id', $materiale_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantita_utilizzata', $quantita_utilizzata);
        return $stmt->execute();
    }

    public static function update(PDO $conn, $id_materiale_componente, $materiale_id, $quantita_utilizzata)
    {
        $query = "UPDATE materiali_componenti 
              SET materiale_id = :materiale_id, quantita_utilizzata = :quantita_utilizzata 
              WHERE id = :id_materiale_componente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':materiale_id', $materiale_id);
        $stmt->bindParam(':quantita_utilizzata', $quantita_utilizzata);
        $stmt->bindParam(':id_materiale_componente', $id_materiale_componente);
        return $stmt->execute();
    }

    public static function updateQuantita(PDO $conn, $id_materiale_componente, $nuova_quantita_utilizzata)
    {
        $query = "UPDATE materiali_componenti 
                  SET quantita_utilizzata = :quantita_utilizzata 
                  WHERE id = :id_materiale_componente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':quantita_utilizzata', $nuova_quantita_utilizzata);
        $stmt->bindParam(':id_materiale_componente', $id_materiale_componente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getById(PDO $conn, $id_materiale_componente)
    {
        $query = "SELECT mc.quantita_utilizzata, mc.materiale_id 
                  FROM materiali_componenti mc 
                  WHERE mc.id = :id_materiale_componente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materiale_componente', $id_materiale_componente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public static function deleteById(PDO $conn, $id_materiale_componente)
    {
        $query = "DELETE FROM materiali_componenti WHERE id = :id_materiale_componente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_materiale_componente', $id_materiale_componente, PDO::PARAM_INT);
        return $stmt->execute();

    }


}
