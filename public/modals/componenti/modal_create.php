<div id="createComponenteModal" class="modal fade" tabindex="-1" aria-labelledby="createComponenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createComponenteModalLabel">Aggiungi Componente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/componenti/create_componente.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Componente:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="descrizione" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="descrizione" id="descrizione" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Componente:</label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
