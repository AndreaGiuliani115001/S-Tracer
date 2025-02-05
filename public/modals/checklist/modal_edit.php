<div class="modal fade" id="editChecklistModal" tabindex="-1" aria-labelledby="editChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editChecklistModalLabel">Modifica Checklist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/checklist/update_checklist.php" method="POST">
                    <input type="hidden" id="edit_checklist_id" name="checklist_id">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="operazione_id" value="<?= htmlspecialchars($_GET['operazione_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome Checklist</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descrizione" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="edit_descrizione" name="descrizione" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
