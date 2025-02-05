<div class="modal fade" id="editDomandaModal" tabindex="-1" aria-labelledby="editDomandaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editDomandaModalLabel">Modifica Domanda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/checklist/domande/update_domanda.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_domanda_id" name="domanda_id">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="operazione_id" value="<?= htmlspecialchars($_GET['operazione_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <div class="mb-3">
                        <label for="edit_domanda_testo" class="form-label">Testo Domanda</label>
                        <input type="text" class="form-control" id="edit_domanda_testo" name="testo" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_domanda_tipo_risposta" class="form-label">Tipo di Risposta</label>
                        <select class="form-select" id="edit_domanda_tipo_risposta" name="tipo_risposta" required>
                            <option value="testo">Testo</option>
                            <option value="file">File</option>
                            <option value="data">Data</option>
                            <option value="numero">Numero</option>
                            <option value="booleano">Booleano</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_domanda_file" class="form-label">Aggiorna File (opzionale)</label>
                        <input type="file" class="form-control" id="edit_domanda_file" name="file">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
