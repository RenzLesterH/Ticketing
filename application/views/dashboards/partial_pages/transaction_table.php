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
                        <td><?= $client_transaction['firstname']." ".$client_transaction['middlename']." ".$client_transaction['lastname']  ?></td>
                        <td><?= $client_transaction['transaction'] ?></td>
                        <td> <span class="badge bg-primary"><?= $client_transaction['progress'] ?></span></td>
                        <td><?= date("F j, Y", strtotime($received_at_date)) ?></td>
                        <td>
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#view_client_modal">
                            View more
                        </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    

</div>

<script>
    $(document).ready(function() {
        $('#transcation_table').DataTable();
    });
</script>