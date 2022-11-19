<h1 class="h3 mb-3">Client Transactions</h1>
<div class="col-15 col-lg-12 col-xxl-13 d-flex mx-auto">

    <div class="card flex-fill">
        <div class="card-body p-4 border">
            <table id="transcation_table" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Transaction Type</th>
                        <th>Status</th>
                        <th>Reveived at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client_transactions as $client_transaction) {
                        $received_at_date = $client_transaction['received_at']; //convert to readable format.
                    ?>
                        <tr>
                            <td><?= $client_transaction['firstname'] . " " . $client_transaction['middlename'] . " " . $client_transaction['lastname']  ?></td>
                            <td><?= $client_transaction['transaction'] ?></td>
                            <td> <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span></td>
                            <td><?= date("F j, Y", strtotime($received_at_date)) ?></td>
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

            

        });
    </script>