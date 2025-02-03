<?php

class Risposte
{// classes/Risposte.php

    public static function esistonoRispostePerDomanda(PDO $conn, $domanda_id)
    {
        $query = "SELECT COUNT(*) FROM risposte WHERE domanda_id = :domanda_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':domanda_id', $domanda_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;

    }


}