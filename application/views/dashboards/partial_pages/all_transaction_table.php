<h1 class="h3 mb-3">List of All Transactions</h1>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($client_transactions as $client_transaction) { ?>
                    <tr>
                        <td><?= $client_transaction['firstname'] . " " . $client_transaction['middlename'] . " " . $client_transaction['lastname']  ?></td>

                        <td><?= $client_transaction['transaction_code'] ?></td>

                        <td><?= $client_transaction['transaction'] ?></td>

                        <td>
                            <?php if ($client_transaction['progress'] === "On Going") { ?>
                                <span class="badge bg-secondary"><?= $client_transaction['progress'] ?></span>
                            <?php } else if ($client_transaction['progress'] === "Approved") { ?>
                                <span class="badge bg-success"><?= $client_transaction['progress'] ?></span>
                            <?php } else if ($client_transaction['progress'] === "Pending") { ?>
                                <span class="badge bg-warning"><?= $client_transaction['progress'] ?></span>
                            <?php } else if ($client_transaction['progress'] === "On Going") { ?>
                                <span class="badge bg-secondary"><?= $client_transaction['progress'] ?></span>
                            <?php } else if ($client_transaction['progress'] === "Prepared") { ?>
                                <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span>
                            <?php } else if ($client_transaction['progress'] === "Verified") { ?>
                                <span class="badge bg-info"><?= $client_transaction['progress'] ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-info view_transaction" id="<?= $client_transaction['id'] ?>" data-bs-toggle="modal" data-bs-target="#view_transaction_modal">
                                    View Transaction
                            </button>
                        </td>
                    </tr>
                    <?php } ?> 
                </tbody>
            </table>
        </div>
    </div>

    <!-- The Modal View client transaction -->
    <div class="modal" id="view_transaction_modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="view_transaction">
                <!-- Load Form -->
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function() {
            $(document).on('click', 'button.view_transaction', function() {
                let client_transaction_id = $(this).attr('id');
                $.get("view_transaction/" + client_transaction_id, function(res) {
                    $('#view_transaction').html(res);
                });
            });
        });
    </script>