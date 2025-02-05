<div id="editComponenteModal" class="modal fade" tabindex="-1" aria-labelledby="editComponenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editComponenteModalLabel">Modifica Componente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/componenti/update_componente.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="progetto_id" id="edit_progetto_id">
                    <input type="hidden" name="attivita_id" id="edit_attivita_id">
                    <input type="hidden" name="stato" id="edit_stato">
                    <input type="hidden" name="linea_produzione_id" id="edit_linea_produzione_id">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome Componente:</label>
                        <input type="text" class="form-control" name="nome" id="edit_nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descrizione" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="descrizione" id="edit_descrizione" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Sostituisci Foto (opzionale):</label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
