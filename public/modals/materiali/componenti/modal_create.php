<div class="modal fade" id="createMaterialeComponenteModal" tabindex="-1" aria-labelledby="createMaterialeComponenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="createMaterialeComponenteModalLabel">Aggiungi Materiale al Componente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/materiali/componenti/create_materiale_componente.php" method="POST">
                    <input type="hidden" name="componente_id">
                    <input type="hidden" name="progetto_id">
                    <input type="hidden" name="linea_produzione_id">
                    <input type="hidden" name="attivita_id">
                    <input type="hidden" name="stato">

                    <div class="mb-3">
                        <label for="materiale_id" class="form-label">Materiale Disponibile</label>
                        <select class="form-select" id="materiale_id" name="materiale_id" required>
                            <?php foreach (Materiali::getDisponibili($conn) as $materiale): ?>
                                <option value="<?= $materiale['id'] ?>">
                                    <?= htmlspecialchars($materiale['nome']) ?> (<?= $materiale['quantita_disponibile'] ?> <?= $materiale['unita_misura'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantita_utilizzata" class="form-label">Quantità da Utilizzare</label>
                        <input type="number" step="0.01" class="form-control" id="quantita_utilizzata" name="quantita_utilizzata" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
