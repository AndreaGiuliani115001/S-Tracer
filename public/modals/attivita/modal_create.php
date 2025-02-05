<div id="createAttivitaModal" class="modal fade" tabindex="-1" aria-labelledby="createAttivitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createAttivitaModalLabel">Aggiungi Attività</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/attivita/create_attivita.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="descrizione" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="descrizione" id="descrizione" rows="3" required></textarea>
                    </div>

                    <input type="hidden" name="stato" id="stato" value="<?= htmlspecialchars($stato) ?>">
                    <input type="hidden" name="progetto_id" id="progetto_id" value="<?= htmlspecialchars($progetto_id) ?>">
                    <input type="hidden" name="linea_produzione_id" id="linea_produzione_id" value="<?= $linea_produzione_id ?>">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
