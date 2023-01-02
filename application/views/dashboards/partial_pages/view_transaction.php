<!-- Modal Header -->
<div class="modal-header">
      <h4 class="modal-title" id="edit_form_transaction_modal_header">Transaction No. <?= $client_transaction[0]['id'] ?></h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <!-- Modal body -->
  <div class="modal-body p-4">
        <?php
            $received_at = json_decode($client_transaction[0]['received_at']); 
        ?>
          <div class="col-md-12">
                <h4>Transaction Progress</h4>
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td>Received by: <?= $received_at[0] ?></td>
                            <td>Date: <?= date("F j, Y", strtotime($received_at[1])) ?></td>
                        </tr>
                        <?php 
                            if(isset($client_transaction[0]['prepared_at'])){ 
                            $prepared_at = json_decode($client_transaction[0]['prepared_at']);
                        ?>
                        <tr>
                            <td>Prepared by: <?= $prepared_at[0] ?></td>
                            <td>Date: <?= date("F j, Y", strtotime($prepared_at[1])) ?></td>
                        </tr>
                        <?php } ?>
                        <?php 
                            if(isset($client_transaction[0]['verified_at'])){ 
                            $verified_at = json_decode($client_transaction[0]['verified_at']);
                        ?>
                        <tr>
                            <td>Verified by: <?= $verified_at[0] ?></td>
                            <td>Date: <?= date("F j, Y", strtotime($verified_at[1])) ?></td>
                        </tr>
                        <?php } ?>
                        <?php 
                            if(isset($client_transaction[0]['approve_at'])){ 
                            $approve_at = json_decode($client_transaction[0]['approve_at']);
                        ?>
                        <tr>
                            <td>Approved by: <?= $approve_at[0] ?></td>
                            <td>Date: <?= date("F j, Y", strtotime($approve_at[1])) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
          </div>
  </div>

  <!-- Modal footer -->
  <div class="modal-footer"> 
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button">Close</button>
  </div>
  </form>