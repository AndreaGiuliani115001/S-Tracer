<div class="modal fade" id="editQuantitaModal" tabindex="-1" aria-labelledby="editQuantitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editQuantitaModalLabel">Modifica Quantità Utilizzata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/materiali/componenti/update_materiale_componente.php" method="POST">
                    <input type="hidden" id="edit_id_materiale_componente" name="id_materiale_componente">

                    <!-- Campi nascosti per il reindirizzamento -->
                    <input type="hidden" id="edit_progetto_id" name="progetto_id">
                    <input type="hidden" id="edit_linea_produzione_id" name="linea_produzione_id">
                    <input type="hidden" id="edit_componente_id" name="componente_id">
                    <input type="hidden" id="edit_attivita_id" name="attivita_id">
                    <input type="hidden" id="edit_stato" name="stato">

                    <div class="mb-3">
                        <label for="edit_quantita_utilizzata" class="form-label">Quantità da Utilizzare</label>
                        <input type="number" step="0.01" class="form-control" id="edit_quantita_utilizzata" name="quantita_utilizzata" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
