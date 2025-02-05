<div class="modal fade" id="deleteMaterialeModal" tabindex="-1" aria-labelledby="deleteMaterialeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteMaterialeModalLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare questo materiale? L'operazione è irreversibile.
            </div>
            <div class="modal-footer">
                <form action="actions/materiali/magazzino/delete_materiale.php" method="POST">
                    <input type="hidden" id="delete_materiale_id" name="materiale_id">
                    <button type="submit" class="btn btn-danger">Conferma</button>
                </form>
            </div>
        </div>
    </div>
</div>
