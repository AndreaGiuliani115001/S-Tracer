<?php


class ComponentiOperazioni {
    public static function getComponenteOperazioneId(PDO $conn, $componente_id, $operazione_id) {
        $query = "SELECT id FROM componenti_operazioni 
                  WHERE componente_id = :componente_id AND operazione_id = :operazione_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componente_id', $componente_id);
        $stmt->bindParam(':operazione_id', $operazione_id);
        $stmt->execute();
        return $stmt->fetchColumn();  // Restituisce l'id se trovato, altrimenti null
    }
}
