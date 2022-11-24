<?php
    $transaction_status_label = "Prepared by:";
    $transaction_status_button = "Prepare now";
    if ($this->session->userdata('user_level') === "3") {
        $transaction_status_label = "Verified by:";
        $transaction_status_button = "Verify now";
    }else if ($this->session->userdata('user_level') === "4") {
        $transaction_status_label = "Approved by:";
        $transaction_status_button = "Approve now";
    }
?>
<div class="modal-header">
    <h1 class="modal-title fs-3" id="client_form_modal"></h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="update_client_status" autocomplete="off" method="post" action="<?= base_url(); ?>client_transaction/validate">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" value="<?= $client_id ?>" name="client_form_id">
    <div class="modal-body ps-4 pe-4">
        <label for="input" class="form-label"><?= $transaction_status_label ?></label>
        <?php if ($this->session->userdata('user_level') === "4") { ?>
            <input type="text" class="form-control p-1" name="updated_by" value="Loren May" disabled>
        <?php }else{ ?>
            <input type="text" class="form-control p-1" name="updated_by" required>
        <?php }?>
    </div>  
    <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success submit_client_transaction_form"><?= $transaction_status_button ?></button>
    </div>
</form>