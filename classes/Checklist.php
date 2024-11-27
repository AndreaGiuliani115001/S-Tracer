<?php

class Checklist
{
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
                }, $result)
            ];
        }

        return null;
    }
}
