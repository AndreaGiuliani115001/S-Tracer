<div class="modal fade" id="editMaterialeModal" tabindex="-1" aria-labelledby="editMaterialeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editMaterialeModalLabel">Modifica Materiale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/materiali/magazzino/update_materiale.php" method="POST">
                    <input type="hidden" id="edit_materiale_id" name="materiale_id">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome Materiale</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descrizione" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="edit_descrizione" name="descrizione" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_quantita_disponibile" class="form-label">Quantità Disponibile</label>
                        <input type="number" step="0.01" class="form-control" id="edit_quantita_disponibile" name="quantita_disponibile" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_unita_misura" class="form-label">Unità di Misura</label>
                        <select class="form-select" id="edit_unita_misura" name="unita_misura" required>
                            <option value="kg">Kg</option>
                            <option value="m">Metri</option>
                            <option value="l">Litri</option>
                            <option value="pz">Pezzi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_costo_unitario" class="form-label">Costo Unitario (€)</label>
                        <input type="number" step="0.01" class="form-control" id="edit_costo_unitario" name="costo_unitario" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary bg-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
