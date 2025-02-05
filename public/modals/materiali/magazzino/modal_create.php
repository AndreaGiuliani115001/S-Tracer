<div class="modal fade" id="createMaterialeModal" tabindex="-1" aria-labelledby="createMaterialeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createMaterialeModalLabel">Crea Nuovo Materiale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/materiali/magazzino/create_materiale.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Materiale</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="descrizione" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="descrizione" name="descrizione" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="quantita_disponibile" class="form-label">Quantità Disponibile</label>
                        <input type="number" step="0.01" class="form-control" id="quantita_disponibile" name="quantita_disponibile" required>
                    </div>

                    <div class="mb-3">
                        <label for="unita_misura" class="form-label">Unità di Misura</label>
                        <select class="form-select" id="unita_misura" name="unita_misura" required>
                            <option value="kg">Kg</option>
                            <option value="m">Metri</option>
                            <option value="l">Litri</option>
                            <option value="pz">Pezzi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="costo_unitario" class="form-label">Costo Unitario (€)</label>
                        <input type="number" step="0.01" class="form-control" id="costo_unitario" name="costo_unitario" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn bg-success"><i class="fas fa-save text-white" style="font-size: 24px;"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
