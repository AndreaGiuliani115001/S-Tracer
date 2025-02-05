<div id="editProgettoModal" class="modal fade" tabindex="-1" aria-labelledby="editProgettoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editProgettoModalLabel">Modifica Progetto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/progetti/update_progetto.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_matricola" class="form-label">Matricola:</label>
                        <input type="text" class="form-control" name="matricola" id="edit_matricola" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_CIN" class="form-label">CIN:</label>
                        <input type="text" class="form-control" name="CIN" id="edit_CIN" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_data_di_consegna" class="form-label">Data di Consegna:</label>
                        <input type="date" class="form-control" name="data_di_consegna" id="edit_data_di_consegna" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_stato" class="form-label">Stato:</label>
                        <select class="form-control" name="stato" id="edit_stato" required>
                            <option value="Da Iniziare">Da Iniziare</option>
                            <option value="In Corso">In Corso</option>
                            <option value="Completato">Completato</option>
                            <option value="In Pausa">In Pausa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_linea_produzione_id" class="form-label">Linea di Produzione:</label>
                        <select class="form-control" name="linea_produzione_id" id="edit_linea_produzione_id" required>
                            <?php foreach ($linee_produzione as $linea): ?>
                                <option value="<?= $linea['id'] ?>"><?= $linea['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Cambia Foto (opzionale):</label>
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
