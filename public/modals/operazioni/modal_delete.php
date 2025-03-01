<div id="deleteOperazioneModal" class="modal fade" tabindex="-1" aria-labelledby="deleteOperazioneModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteOperazioneModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questa operazione? L'operazione è irreversibile.</p>
                <form action="actions/operazioni/delete_operazione.php" method="POST">
                    <input type="hidden" name="id" id="delete_operazione_id">
                    <input type="hidden" name="progetto_id" id="delete_progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" id="delete_attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" id="delete_componente_id" >
                    <input type="hidden" name="stato" id="delete_stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" id="delete_linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Conferma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
