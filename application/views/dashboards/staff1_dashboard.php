<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Staff 1 Dashboard.</title>
</head>
<script>
    $(document).ready(function() {
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

    });
</script>
<body>
    <h1>Staff 1 Dashboard</h1>
    <a href='<?= base_url(); ?>logout'>Log off</a></h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Add Transaction
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Transaction Info</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <form class="row g-3" autocomplete="off" action="">
                        <div class="col-md-4">
                            <label for="input" class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Enter client first name">
                        </div>
                        <div class="col-md-4">
                            <label for="input" class="form-label">Middle name</label>
                            <input type="text" class="form-control" name="middlename" placeholder="Enter client middle name">
                        </div>
                        <div class="col-md-4">
                            <label for="input" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Enter client last name">
                        </div>
                        <div class="col-6">
                            <label for="input" class="form-label">Barangay</label>
                            <select id="barangay" name="barangay" class="form-select">
                                <option selected>Choose barangay...</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="input" class="form-label">Street/Zone</label>
                            <input type="text" class="form-control" name="street_zone" placeholder="Enter client street or zone">
                        </div>
                        <div class="col-5">
                            <label for="input" class="form-label">Contact Number</label>
                            <input type="number" class="form-control" name="contact" placeholder="Enter client contact number">
                        </div>
                        <div class="col-md-7">
                            <label for="inputState" class="form-label">Type of transaction</label>
                            <select id="transactions" name="trasaction" class="form-select">
                                <option selected>Choose transcation type...</option>
                            </select>
                        </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add transaction</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>