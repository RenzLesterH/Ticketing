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

    <div class="modal fade" id="confirm_edit_transaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h4 class="modal-title" id="staticBackdropLabel">Confirm Changes</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-0" role="alert">
                        <h4 class="alert-heading"><i class="fa-solid fa-circle-exclamation"></i> Save Changes?</h4>
                        <p id="confirm_message">
                            <!-- Confirmation Message Here -->
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success update_transaction">Update Transaction</button>
                </div>
            </div>
        </div>
    </div>
</div>