<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel">Modifica Linea di Produzione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/linea_produzione/update_linea.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome Linea:</label>
                        <input type="text" class="form-control" name="nome" id="edit_nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Cambia Foto:</label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save text-white" style="font-size: 24px;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
