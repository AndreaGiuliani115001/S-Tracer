<div id="deleteProgettoModal" class="modal fade" tabindex="-1" aria-labelledby="deleteProgettoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteProgettoModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questo progetto? L'operazione è irreversibile.</p>
                <form action="actions/progetti/delete_progetto.php" method="POST">
                    <input type="hidden" name="id" id="delete_id">
                    <input type="hidden" name="linea_produzione_id" id="delete_linea_produzione_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
