<?php

class Domande
{

    public static function create(PDO $conn, $testo, $tipo_risposta, $file_url, $checklist_id)
    {
        $query = "INSERT INTO domande (testo, tipo_risposta, file_url, checklist_id) 
                  VALUES (:testo, :tipo_risposta, :file_url, :checklist_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':testo', $testo);
        $stmt->bindParam(':tipo_risposta', $tipo_risposta);
        $stmt->bindParam(':file_url', $file_url);
        $stmt->bindParam(':checklist_id', $checklist_id);
        return $stmt->execute();
    }


}