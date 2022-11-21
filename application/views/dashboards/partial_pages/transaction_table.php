<h1 class="h3 mb-3">Client Transactions</h1>
<?php if (!empty($this->session->flashdata('success'))) { ?>
    <div class="alert alert-success alert-dismissible fade show p-2" role="alert">
        <i class="fa-solid fa-circle-check"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<div class="col-15 col-lg-12 col-xxl-13 d-flex mx-auto">

    <div class="card flex-fill">
        <div class="card-body p-4 border">
            <table id="transcation_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Transaction No.</th>
                        <th>Transaction Type</th>
                        <th>Status</th>
                        <th>Reveived by</th>
                        <th>Reveived date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client_transactions as $client_transaction) {
                        $received_at = json_decode($client_transaction['received_at']); //convert to readable format.
                    ?>
                        <tr>
                            <td><?= $client_transaction['firstname'] . " " . $client_transaction['middlename'] . " " . $client_transaction['lastname']  ?></td>
                            <td><?= $client_transaction['transaction_code'] ?></td>
                            <td><?= $client_transaction['transaction'] ?></td>
                            <td> 
                            <?php if ($client_transaction['progress'] === "On Going") { ?>  
                                <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span>
                            <?php }else{ ?>
                                <span class="badge bg-warning"><?= $client_transaction['progress'] ?></span>
                            <?php } ?>
                            </td>
                            <td><?= $received_at[0] ?></td>
                            <td><?= date("F j, Y", strtotime($received_at[1])); ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-info edit_transaction" id="<?= $client_transaction['id'] ?>" data-bs-toggle="modal" data-bs-target="#view_client_modal">
                                    View more
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="view_client_modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="view_client_transaction_form">
                <!-- Load Form -->
            </div>
        </div>
    </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#transcation_table').DataTable();
            $(document).on('click', 'button.edit_transaction', function() {
                let client_transaction_id = $(this).attr('id');
                $.get("view_client_transaction/" + client_transaction_id, function(res) {
                    let barangay = "<?= base_url(); ?>assets/json/barangay.json";
                    let transactions = "<?= base_url(); ?>assets/json/transactions.json";
                    $.getJSON(transactions, function(data) {
                        $.each(data, function(index, value) {
                            $('#transactions').append('<option value="' + value.Name + '">' + value.Name + '</option>');
                        });
                    });
                    $.getJSON(barangay, function(data) {
                        $.each(data, function(index, value) {
                            $('#barangay').append('<option value="' + value.Name + '">' + value.Name + '</option>');
                        });
                    });
                    $('#view_client_transaction_form').html(res);
                });
            });

            $(document).on('click', 'button.edit_button', function() {
                $(".save_button").attr("hidden",false);
                $("#edit_form_transaction_modal_header").text("Edit Transaction Details");
                $("#cancel_button").text("Cancel");
                $(this).hide();
                $("form#edit_form_transaction input").prop('disabled', false);
                $("form#edit_form_transaction select").prop('disabled', false);
                $("#notification_warning").hide();
            });

            $(document).on('click', '.save_button', function() {
                let form = $("form#edit_form_transaction");
				$.post(form.attr('action'), form.serialize(), function(res) {
                    $( ".btn-close" ).trigger( "click" );
					$('#load_page').html(res);
				});
                return false;
            });
        });
    </script>