<?php
    $action_form_modal = "";
    $transaction_status = "Reveived";
    $transaction_status_modal_header = "Prepare";
    if ($this->session->userdata('user_level') === "2") {
        $action_form_modal = "for_prepare";
    }else if ($this->session->userdata('user_level') === "3") {
        $transaction_status = "Prepared";
        $action_form_modal = "for_verify";
        $transaction_status_modal_header = "Verify";
    }
?>

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
                        <th><?=$transaction_status?> by</th>
                        <th><?=$transaction_status?> date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client_transactions as $client_transaction) {
                        if ($this->session->userdata('user_level') === "1" || $this->session->userdata('user_level') === "2") {
                            $transaction_status_at = json_decode($client_transaction['received_at']); //convert to readable format.
                        }else if ($this->session->userdata('user_level') === "3") {
                            $transaction_status_at = json_decode($client_transaction['prepared_at']);
                        }
                    ?>
                        <tr>
                            <td><?= $client_transaction['firstname'] . " " . $client_transaction['middlename'] . " " . $client_transaction['lastname']  ?></td>

                            <td><?= $client_transaction['transaction_code'] ?></td>

                            <td><?= $client_transaction['transaction'] ?></td>

                            <td> 
                            <?php if ($client_transaction['progress'] === "On Going" && $this->session->userdata('user_level') === "1") { ?>  
                                <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span>
                            <?php }else if ($client_transaction['progress'] === "Pending" && $this->session->userdata('user_level') === "1"){ ?>
                                <span class="badge bg-warning"><?= $client_transaction['progress'] ?></span>
                            <?php }else if ($client_transaction['progress'] === "On Going" && $this->session->userdata('user_level') === "2"){ ?>
                                <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span>
                            <?php }else if ($client_transaction['progress'] === "Prepared" && $this->session->userdata('user_level') === "3"){ ?>
                                <span class="badge bg-info"><?= $client_transaction['progress'] ?></span>
                            <?php } ?>
                            </td>

                            <td><?= $transaction_status_at[0] ?></td>

                            <td><?= date("F j, Y", strtotime($transaction_status_at[1])); ?></td>

                            <td>
                            <?php if ($this->session->userdata('user_level') === "1") { ?>  
                                <button type="button" class="btn btn-outline-info edit_transaction" id="<?= $client_transaction['id'] ?>" data-bs-toggle="modal" data-bs-target="#view_client_modal">
                                    View more
                                </button>
                            <?php }else if ($this->session->userdata('user_level') === "2"){ ?>
                                <button type="button" class="btn btn-outline-info client_form_transaction_button" id="<?= $client_transaction['id'] ?>" data-bs-toggle="modal" data-bs-target="#<?=$action_form_modal?>">
                                    Prepare now
                                </button>
                            <?php }else if ($this->session->userdata('user_level') === "3"){ ?>
                                <button type="button" class="btn btn-outline-info client_form_transaction_button" id="<?= $client_transaction['id'] ?>" data-bs-toggle="modal" data-bs-target="#<?=$action_form_modal?>">
                                    Verify now
                                </button>
                            <?php } ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- The Modal View client transaction -->
    <div class="modal" id="view_client_modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="view_client_transaction_form">
                <!-- Load Form -->
            </div>
        </div>
    </div>

     <!-- The Modal prepare client transaction -->
    <div class="modal fade" id="<?=$action_form_modal?>" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content" id="action_form">
                                
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

            $(document).on('click', 'button.client_form_transaction_button', function() {
                let client_form_transaction_id = $(this).attr('id');
                $.get("view_action_form/" + client_form_transaction_id, function(res) {
                    $('#action_form').html(res);
                    $('#client_form_modal').text("<?=$transaction_status_modal_header?> client transaction no. "+client_form_transaction_id);
                });
            }); 

            $(document).on('click', 'button.submit_client_transaction_form', function() {
                let form = $("form#update_client_status");
				$.post(form.attr('action'), form.serialize(), function(res) {
                    $( ".btn-close" ).trigger( "click" );
					$('#load_page').html(res);
				});
                return false;
            }); 

        });
    </script>