<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Elimina Linea di Produzione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questa linea di produzione?</p>
                <form action="actions/linea_produzione/delete_linea.php" method="POST">
                    <input type="hidden" name="id" id="delete_id">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Conferma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
