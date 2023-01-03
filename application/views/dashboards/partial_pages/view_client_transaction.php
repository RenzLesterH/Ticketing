  <!-- Modal Header -->
  <div class="modal-header">
      <h4 class="modal-title" id="edit_form_transaction_modal_header">View Transaction Details</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <!-- Modal body -->
  <div class="modal-body p-4">
      <div class="alert alert-warning p-2" id="notification_warning" role="alert">
          <i class="fa-solid fa-circle-exclamation"></i> Inputs are disabled. Please click <strong>Edit</strong> Button to edit details.
      </div>
      <?php
            $received_at = json_decode($client_transaction[0]['received_at']);
      ?>
      <?php if($client_transaction[0]['progress'] !== "Approved"){ ?>
      <h4 class="mb-4 text-muted">Recieved by: <?= $received_at[0] ?></h4>
      <?php } ?>
      <form class="row g-3" autocomplete="off" method="post" action="<?= base_url(); ?>update_transaction/validate" id="edit_form_transaction">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
          <input type="hidden" value="<?= $client_transaction[0]['progress'] ?>" id="transacion_progress">
          <input type="text" name="id" value="<?= $client_transaction[0]['id'] ?>" hidden>
          <div class="col-md-4">
              <label for="input" class="form-label">First name</label>
              <input type="text" class="form-control bg-white" name="firstname" value="<?= $client_transaction[0]['firstname'] ?>" disabled>
          </div>
          <div class="col-md-4">
              <label for="input" class="form-label">Middle name</label>
              <input type="text" class="form-control bg-white" name="middlename" value="<?= $client_transaction[0]['middlename'] ?>" disabled>
          </div>
          <div class="col-md-4">
              <label for="input" class="form-label">Last name</label>
              <input type="text" class="form-control bg-white" name="lastname" value="<?= $client_transaction[0]['lastname'] ?>" disabled>
          </div>
          <div class="col-6">
              <label for="input" class="form-label">Barangay</label>
              <select id="barangay" name="barangay" class="bg-white form-select" disabled>
                  <option selected><?= $client_transaction[0]['barangay'] ?></option>
              </select>
          </div>
          <div class="col-6">
              <label for="input" class="form-label">Street/Zone</label>
              <input type="text" class="form-control bg-white" name="street_zone" value="<?= $client_transaction[0]['street_zone'] ?>" disabled>
          </div>
          <div class="col-5">
              <label for="input" class="form-label">Contact Number</label>
              <input type="number" class="form-control bg-white" name="contact" value="<?= $client_transaction[0]['contacts'] ?>" disabled>
          </div>
          <div class="col-md-7">
              <label for="inputState" class="form-label">Type of transaction</label>
              <select id="transactions" name="transaction" class="bg-white form-select" disabled>
                  <option selected><?= $client_transaction[0]['transaction'] ?></option>
              </select>
          </div>
          <?php if($this->session->userdata('user_level') === "1"){ ?>
          <div class="col-7 mb-2">
              <label class="form-check">
                <?php
                    $is_checked="";  
                    if($client_transaction[0]['has_requirements'] === "1"){
                    $is_checked="checked";
                } ?>
                  <input class="form-check-input" id="check_box_requirements" name="requirements" type="checkbox" value="0" disabled <?=$is_checked?>>
                  <span class="form-check-label">
                      Check if client has all the requirements.
                  </span>
          </div>
          <?php } ?>
          <?php if($client_transaction[0]['progress'] === "Approved"){
                $prepared_at = json_decode($client_transaction[0]['prepared_at']);
                $verified_at = json_decode($client_transaction[0]['verified_at']);
                $approve_at = json_decode($client_transaction[0]['approve_at']);
          ?>
          <div class="col-md-12">
                <h4>Transaction History</h4>
                <table class="table table-bordered mt-3">
                    <tbody>
                    <tr>
                        <td>Received by: <?= $received_at[0] ?></td>
                        <td>Date: <?= date("F j, Y", strtotime($received_at[1])) ?></td>
                    </tr>
                    <tr>
                        <td>Prepared by: <?= $prepared_at[0] ?></td>
                        <td>Date: <?= date("F j, Y", strtotime($prepared_at[1])) ?></td>
                    </tr>
                    <tr>
                        <td>Verified by: <?= $verified_at[0] ?></td>
                        <td>Date: <?= date("F j, Y", strtotime($verified_at[1])) ?></td>
                    </tr>
                    <tr>
                        <td>Approved by: <?= $approve_at[0] ?></td>
                        <td>Date: <?= date("F j, Y", strtotime($approve_at[1])) ?></td>
                    </tr>
                    </tbody>
                </table>
          </div>
          <?php } ?>
  </div>

  <!-- Modal footer -->
  <div class="modal-footer"> 
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button">Close</button>
      <button type="button" class="btn btn-info edit_button">Edit</button>
      <button type="submit" class="btn btn-success save_button" hidden>Save changes</button>
  </div>
  </form>