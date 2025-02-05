<div id="createProgettoModal" class="modal fade" tabindex="-1" aria-labelledby="createProgettoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createProgettoModalLabel">Aggiungi Progetto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/progetti/create_progetto.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="matricola" class="form-label">Matricola:</label>
                        <input type="text" class="form-control" name="matricola" required>
                    </div>

                    <div class="mb-3">
                        <label for="CIN" class="form-label">CIN:</label>
                        <input type="text" class="form-control" name="CIN" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_di_consegna" class="form-label">Data di Consegna:</label>
                        <input type="date" class="form-control" name="data_di_consegna" required>
                    </div>

                    <div class="mb-3">
                        <label for="stato" class="form-label">Stato:</label>
                        <select class="form-control" name="stato" required>
                            <option value="Da Iniziare">Da Iniziare</option>
                            <option value="In Corso">In Corso</option>
                            <option value="Completato">Completato</option>
                            <option value="In Pausa">In Pausa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Carica Foto:</label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                    </div>

                    <input type="hidden" name="linea_produzione_id" id="linea_produzione_id" value="<?= $linea_produzione_id ?>">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
