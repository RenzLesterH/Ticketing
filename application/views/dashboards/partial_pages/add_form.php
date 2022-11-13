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

<div class="container-fluid p-0">

    <div class="row">

        <?php if (!empty($this->session->flashdata('success'))) { ?>
            <div class="mb-2 bg-success text-white p-2 col-11 col-lg-8 col-xxl-9 mx-auto text-center">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php } else if (!empty($this->session->flashdata('input_errors'))) { ?>
                <?= $this->session->flashdata('input_errors'); ?>
        <?php } ?>

        <div class="col-11 col-lg-8 col-xxl-9 d-flex mx-auto">

            <div class="card flex-fill">

                <div class="card-body p-4 border">
                    <h1 class="h3">Add Client Transaction</h1>
                    <hr>
                    <form id="add_client_form" class="row g-3" autocomplete="off" method="post" action="<?= base_url(); ?>add_transaction/validate">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="col-md-4 mb-2 mt-4">
                            <label for="input" class="form-label">First name</label>
                            <input type="text" class="form-control py-2" name="firstname" placeholder="Enter client first name" required>
                        </div>
                        <div class="col-md-4 mb-2 mt-4">
                            <label for="input" class="form-label">Middle name</label>
                            <input type="text" class="form-control py-2" name="middlename" placeholder="Enter client middle name" required>
                        </div>
                        <div class="col-md-4 mb-2 mt-4">
                            <label for="input" class="form-label">Last name</label>
                            <input type="text" class="form-control py-2" name="lastname" placeholder="Enter client last name" required>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="input" class="form-label">Barangay</label>
                            <select id="barangay" name="barangay" class="form-select py-2" required>
                                <option selected value="">Choose barangay...</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="input" class="form-label">Street/Zone</label>
                            <input type="text" class="form-control py-2" name="street_zone" placeholder="Enter client street or zone" required>
                        </div>
                        <div class="col-5 mb-2">
                            <label for="input" class="form-label">Contact Number</label>
                            <input type="number" class="form-control py-2" name="contact" placeholder="Enter client contact number" required>
                        </div>
                        <div class="col-7 mb-2">
                            <label for="inputState" class="form-label">Type of transaction</label>
                            <select id="transactions" name="trasaction" class="form-select py-2" required>
                                <option selected value="">Choose transcation type...</option>
                            </select>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-lg btn-primary">Add Transcation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>