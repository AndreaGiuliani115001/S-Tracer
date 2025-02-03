<!-- Modal Crea Domanda -->
<div id="createDomandaModal" class="modal fade" tabindex="-1" aria-labelledby="createDomandaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createDomandaModalLabel">Crea Nuova Domanda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/checklist/domande/create_domanda.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="checklist_id" id="selected_checklist_id">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="operazione_id" value="<?= htmlspecialchars($_GET['operazione_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">


                    <div class="mb-3">
                        <label for="domanda_testo" class="form-label">Testo della Domanda</label>
                        <input type="text" class="form-control" id="domanda_testo" name="testo" required>
                    </div>

                    <div class="mb-3">
                        <label for="domanda_tipo" class="form-label">Tipo di Risposta</label>
                        <select class="form-control" id="domanda_tipo" name="tipo_risposta" required>
                            <option value="testo">Testo</option>
                            <option value="file">File</option>
                            <option value="data">Data</option>
                            <option value="numero">Numero</option>
                            <option value="booleano">Booleano</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="domanda_file" class="form-label">Allega un file (opzionale)</label>
                        <input type="file" class="form-control" id="domanda_file" name="file">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-success">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
