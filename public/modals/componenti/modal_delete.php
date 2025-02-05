<div id="deleteComponenteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteComponenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteComponenteModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questo componente? L'operazione è irreversibile.</p>
                <form action="actions/componenti/delete_componente.php" method="POST">
                    <input type="hidden" name="id" id="delete_id">
                    <input type="hidden" name="progetto_id" id="delete_progetto_id">
                    <input type="hidden" name="attivita_id" id="delete_attivita_id">
                    <input type="hidden" name="stato" id="delete_stato">
                    <input type="hidden" name="linea_produzione_id" id="delete_linea_produzione_id">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Conferma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
