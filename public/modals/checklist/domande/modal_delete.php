<div class="modal fade" id="deleteDomandaModal" tabindex="-1" aria-labelledby="deleteDomandaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteDomandaModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare questa domanda? Se associata a file, verranno rimossi anche dal sistema.
            </div>
            <div class="modal-footer">
                <form action="actions/checklist/domande/delete_domanda.php" method="POST">
                    <input type="hidden" id="delete_domanda_id" name="domanda_id">
                    <input type="hidden" name="progetto_id" value="<?= htmlspecialchars($_GET['progetto_id'] ?? '') ?>">
                    <input type="hidden" name="attivita_id" value="<?= htmlspecialchars($_GET['attivita_id'] ?? '') ?>">
                    <input type="hidden" name="componente_id" value="<?= htmlspecialchars($_GET['componente_id'] ?? '') ?>">
                    <input type="hidden" name="operazione_id" value="<?= htmlspecialchars($_GET['operazione_id'] ?? '') ?>">
                    <input type="hidden" name="stato" value="<?= htmlspecialchars($_GET['stato'] ?? '') ?>">
                    <input type="hidden" name="linea_produzione_id" value="<?= htmlspecialchars($_GET['linea_produzione_id'] ?? '') ?>">

                    <button type="submit" class="btn btn-danger">Conferma</button>
                </form>
            </div>
        </div>
    </div>
</div>