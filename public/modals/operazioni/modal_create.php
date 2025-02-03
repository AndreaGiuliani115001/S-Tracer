<div id="createOperazioneModal" class="modal fade" tabindex="-1" aria-labelledby="createOperazioneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createOperazioneModalLabel">Crea Nuova Operazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/operazioni/create_operazione.php" method="POST">
                    <input type="hidden" name="attivita_id" id="create_attivita_id">
                    <input type="hidden" name="componente_id" id="create_componente_id">
                    <input type="hidden" name="progetto_id" id="create_progetto_id">
                    <input type="hidden" name="stato" id="create_stato">
                    <input type="hidden" name="linea_produzione_id" id="create_linea_produzione_id">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Operazione:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="descrizione" class="form-label">Descrizione:</label>
                        <textarea class="form-control" name="descrizione" id="descrizione" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Crea Operazione</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
