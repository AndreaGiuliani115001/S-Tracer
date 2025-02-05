<div id="editAttivitaModal" class="modal fade" tabindex="-1" aria-labelledby="editAttivitaModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAttivitaModalLabel">Modifica Attività</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/attivita/update_attivita.php" method="POST">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="edit_nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descrizione" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="descrizione" id="edit_descrizione" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_stato" class="form-label">Stato:</label>
                        <select class="form-control" name="stato" id="edit_stato" required>
                            <option value="Produzione">Produzione</option>
                            <option value="Manutenzione">Manutenzione</option>
                        </select>
                    </div>

                    <input type="hidden" name="progetto_id" id="edit_progetto_id">
                    <input type="hidden" name="linea_produzione_id" id="edit_linea_produzione_id">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
