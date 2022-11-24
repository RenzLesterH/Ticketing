<div class="modal-header">
    <h1 class="modal-title fs-3" id="client_form_modal"></h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="prepare_client_form" autocomplete="off" method="post" action="<?= base_url(); ?>prepare_client_transaction/validate">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" value="<?=$client_id?>" name="prepare_client_form_id">
    <div class="modal-body ps-4 pe-4">
        <label for="input" class="form-label">Prepared by:</label>
        <input type="text" class="form-control p-1" name="prepared_by" required>
    </div>
    <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success submit_prepared_form">Prepare now</button>
    </div>
</form>