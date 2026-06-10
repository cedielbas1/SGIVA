<div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmActionModalLabel">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="confirmActionModalMessage" class="mb-0">¿Estás seguro de continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmActionModalConfirm">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmModalEl = document.getElementById('confirmActionModal');
        if (!confirmModalEl) {
            return;
        }

        var confirmModalTitle = document.getElementById('confirmActionModalLabel');
        var confirmModalMessage = document.getElementById('confirmActionModalMessage');
        var confirmButton = document.getElementById('confirmActionModalConfirm');
        var confirmForm = null;
        var bsModal = null;

        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bsModal = new bootstrap.Modal(confirmModalEl);
        }

        function showModal(title, message) {
            if (confirmModalTitle) confirmModalTitle.textContent = title;
            if (confirmModalMessage) confirmModalMessage.textContent = message;
            if (bsModal) {
                bsModal.show();
            } else {
                if (window.confirm(message)) {
                    if (confirmForm) {
                        confirmForm.submit();
                    }
                }
            }
        }

        document.body.addEventListener('click', function (event) {
            var button = event.target.closest('.confirm-delete-button');
            if (!button) {
                return;
            }

            event.preventDefault();
            confirmForm = button.closest('form');
            if (!confirmForm) {
                return;
            }

            var title = button.dataset.confirmTitle || 'Confirmar eliminación';
            var message = button.dataset.confirmMessage || '¿Estás seguro de continuar?';
            showModal(title, message);
        });

        if (confirmButton) {
            confirmButton.addEventListener('click', function () {
                if (confirmForm) {
                    confirmForm.submit();
                }
                if (bsModal) {
                    bsModal.hide();
                }
            });
        }
    });
</script>
