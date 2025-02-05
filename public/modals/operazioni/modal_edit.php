<div id="editOperazioneModal" class="modal fade" tabindex="-1" aria-labelledby="editOperazioneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editOperazioneModalLabel">Modifica Operazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/operazioni/update_operazione.php" method="POST">
                    <!-- ID operazione (nascosto) -->
                    <input type="hidden" name="id" id="edit_operazione_id">

                    <!-- Progetto ID, Attività ID, Componente ID, Stato, Linea Produzione ID -->
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome Operazione</label>
                        <input type="text" class="form-control" name="nome" id="edit_nome_operazione" required>
                    </div>

                    <!-- Descrizione -->
                    <div class="mb-3">
                        <label for="edit_descrizione" class="form-label">Descrizione</label>
                        <textarea class="form-control" name="descrizione" id="edit_descrizione_operazione" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
