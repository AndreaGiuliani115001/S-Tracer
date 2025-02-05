<div class="modal fade" id="deleteMaterialeComponenteModal" tabindex="-1" aria-labelledby="deleteMaterialeComponenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteMaterialeComponenteModalLabel">Elimina Materiale dal Componente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questo materiale dal componente? La quantità sarà restituita al magazzino.</p>

                <form action="actions/materiali/componenti/delete_materiale_componente.php" method="POST">
                    <input type="hidden" id="delete_id_materiale_componente" name="id_materiale_componente">
                    <input type="hidden" id="delete_quantita_utilizzata" name="quantita_utilizzata">
                    <input type="hidden" id="delete_materiale_id" name="materiale_id">

                    <!-- Campi per il reindirizzamento -->
                    <input type="hidden" id="delete_progetto_id" name="progetto_id">
                    <input type="hidden" id="delete_linea_produzione_id" name="linea_produzione_id">
                    <input type="hidden" id="delete_componente_id" name="componente_id">
                    <input type="hidden" id="delete_attivita_id" name="attivita_id">
                    <input type="hidden" id="delete_stato" name="stato">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Conferma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
