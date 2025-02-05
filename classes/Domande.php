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

    public static function delete(PDO $conn, $domanda_id)
    {
        // Recupera l'eventuale file associato alla domanda
        $queryFile = "SELECT file_url FROM domande WHERE id = :domanda_id";
        $stmtFile = $conn->prepare($queryFile);
        $stmtFile->bindParam(':domanda_id', $domanda_id, PDO::PARAM_INT);
        $stmtFile->execute();
        $file = $stmtFile->fetch(PDO::FETCH_ASSOC);

        // Se esiste un file associato, lo elimina fisicamente
        if ($file && !empty($file['file_url'])) {
            $filePath = '../../../assets/uploads/' . $file['file_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Elimina la domanda dal database
        $query = "DELETE FROM domande WHERE id = :domanda_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':domanda_id', $domanda_id, PDO::PARAM_INT);
        return $stmt->execute();

    }

    public static function update(PDO $conn, $domanda_id, $testo, $tipo_risposta, $file_url = null)
    {
        if ($file_url) {
            // Aggiorna anche il file associato
            $query = "UPDATE domande 
                      SET testo = :testo, tipo_risposta = :tipo_risposta, file_url = :file_url 
                      WHERE id = :domanda_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':file_url', $file_url);
        } else {
            // Aggiorna solo il testo e il tipo di risposta
            $query = "UPDATE domande 
                      SET testo = :testo, tipo_risposta = :tipo_risposta 
                      WHERE id = :domanda_id";
            $stmt = $conn->prepare($query);
        }

        $stmt->bindParam(':testo', $testo);
        $stmt->bindParam(':tipo_risposta', $tipo_risposta);
        $stmt->bindParam(':domanda_id', $domanda_id, PDO::PARAM_INT);

        return $stmt->execute();
    }


}