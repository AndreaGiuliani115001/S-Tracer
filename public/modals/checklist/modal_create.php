<div id="createChecklistModal" class="modal fade" tabindex="-1" aria-labelledby="createChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createChecklistModalLabel">Nuova Checklist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/checklist/create_checklist.php" method="POST">
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="componente_operazione_id" id="componente_operazione_id">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="operazione_id" value="<?= htmlspecialchars($_GET['operazione_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="nome_checklist" class="form-label">Nome Checklist</label>
                        <input type="text" class="form-control" name="nome" id="nome_checklist" required>
                    </div>

                    <!-- Descrizione -->
                    <div class="mb-3">
                        <label for="descrizione_checklist" class="form-label">Descrizione</label>
                        <textarea class="form-control" name="descrizione" id="descrizione_checklist" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Crea Checklist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
