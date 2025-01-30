<?php

class Checklist
{

    public static function getByComponenteEOperazione($conn, $componente_id, $operazione_id)
    {
        $query = "
    SELECT 
        cl.id AS checklist_id, 
        cl.nome AS checklist_nome, 
        cl.descrizione AS checklist_descrizione, 
        cl.componente_operazione_id AS checklist_componente_operazione_id, 
        cl.created_at AS checklist_created_at,
        co.id AS componente_operazione_id, 
        co.componente_id AS componente_id, 
        co.operazione_id AS operazione_id, 
        co.created_at AS componente_operazione_created_at
    FROM checklist cl
    INNER JOIN componenti_operazioni co ON cl.componente_operazione_id = co.id
    WHERE co.componente_id = :componente_id
      AND co.operazione_id = :operazione_id
";


        $stmt = $conn->prepare($query);
        $stmt->bindValue(':componente_id', $componente_id, PDO::PARAM_INT);
        $stmt->bindValue(':operazione_id', $operazione_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Usa fetchAll per ottenere tutte le righe
    }


    // Metodo per recuperare la checklist e le sue domande
    public static function getByIdWithQuestions($conn, $checklist_id)
    {
        $query = "
        SELECT 
            c.nome AS checklist_nome,
            c.descrizione AS checklist_descrizione,
            d.id AS domanda_id,
            d.testo AS domanda_testo,
            d.tipo_risposta AS domanda_tipo_risposta,
            d.file_url AS domanda_file_url
        FROM checklist c
        LEFT JOIN domande d ON c.id = d.checklist_id
        WHERE c.id = :checklist_id
    ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':checklist_id', $checklist_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Struttura il risultato in un array associativo con checklist e domande
        if ($result) {
            // Filtra le righe con domande valide (id non null)
            $domande = array_filter($result, function ($row) {
                return !empty($row['domanda_id']); // Filtra solo le righe con una domanda valida
            });

            return [
                'checklist' => [
                    'nome' => $result[0]['checklist_nome'] ?? 'N/A',
                    'descrizione' => $result[0]['checklist_descrizione'] ?? 'N/A',
                ],
                'domande' => array_map(function ($row) {
                    return [
                        'id' => $row['domanda_id'],
                        'testo' => $row['domanda_testo'],
                        'tipo_risposta' => $row['domanda_tipo_risposta'],
                        'file_url' => $row['domanda_file_url']
                    ];
                }, $domande) // Usa l'array filtrato
            ];
        }

        return null;
    }

}
