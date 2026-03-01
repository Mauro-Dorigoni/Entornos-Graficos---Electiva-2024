<div class="modal fade" id="confirmActionModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-0" style="background-color: #006633; color: white; padding: 1rem 1.5rem;">
        <img src="../assets/LogoPromoShopFondoVerde.png" alt="PS" style="width: 45px; margin-right: 15px;">
        <h2 class="modal-title font-weight-bold" id="confirmModalLabel" style="margin: 0; color:#CC6600; font-size: 1.5rem;">Confirmar Acción</h2>
      </div>

      <div class="modal-body text-center" style="background-color: #eae8e0; padding: 2.5rem 2rem;">
        <div id="confirmModalBody" class="mb-4">
        </div>

        <div class="d-flex justify-content-center" style="gap: 15px;">
          <a href="#" class="btn px-4 py-2 font-weight-bold" data-bs-dismiss="modal" data-dismiss="modal"
            style="background-color: #6c757d; color: white; border: none; border-radius: 8px; cursor: pointer;">
          Cancelar
          </a>
          <a id="confirmModalBtnAction" href="#" class="btn px-4 py-2 font-weight-bold"
            style="background-color: #CC6600; color: white; border: none; border-radius: 8px; text-decoration: none;">
            Aceptar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function openConfirmModal(mensaje, url, titulo = "Confirmar Acción") {
    const modalElement = document.getElementById('confirmActionModal');
    if (!modalElement) return;

    modalElement.querySelector('#confirmModalLabel').innerText = titulo;
    modalElement.querySelector('#confirmModalBody').innerHTML = `<p style='font-size: 18px; color: #333;'>${mensaje}</p>`;
    modalElement.querySelector('#confirmModalBtnAction').href = url;

    // Usamos la instancia de Bootstrap 5 (que ya viene en el bundle)
    const bsConfirmModal = new bootstrap.Modal(modalElement);
    bsConfirmModal.show();




  }
</script>