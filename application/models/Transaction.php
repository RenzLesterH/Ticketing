<?php
class Transaction extends CI_Model
{
    function count_analytics($progress)
    {
        $query = 
            "SELECT 
                *
            FROM
                transaction
            WHERE
                progress = ?;";
                
        return $this->db->query($query, $progress)->num_rows(); 
    }

    function count_transaction_by_months($month)
    {
        $query = 
            "SELECT 
                *
            FROM
                transaction
            WHERE
                MONTH(created_at) = ?;";
                
        return $this->db->query($query, $month)->num_rows(); 
    }

    function view_all_transaction()
    {
        $view_all_transaction = 
        "SELECT 
            client.*,
            transaction.transaction_code,
            transaction.transaction,
            transaction.progress
        FROM
            client
        LEFT JOIN
            transaction ON client.id = transaction.client_id";

        return $this->db->query($view_all_transaction)->result_array();
    }

    /* This function returns all the client transaction detail from the database. */
    function get_all_transaction()
    {

        if ($this->session->userdata('user_level') === "1") {
            
            $transaction_status = "transaction.received_at, transaction.prepared_at, transaction.verified_at, transaction.approve_at";
            $where_query = "transaction.progress = 'On Going' OR transaction.progress = 'Pending' OR transaction.progress = 'Approved'";

        }else if ($this->session->userdata('user_level') === "2") {

            $transaction_status = "transaction.received_at";
            $where_query = "transaction.progress = 'On Going'";

        }else if ($this->session->userdata('user_level') === "3") {

            $transaction_status = "transaction.prepared_at";
            $where_query = "transaction.progress = 'Prepared'";

        }else if ($this->session->userdata('user_level') === "4") {

            $transaction_status = "transaction.verified_at";
            $where_query = "transaction.progress = 'Verified'";

        }

        $view_transaction_by_user_level = 
        "SELECT 
            client.*,
            transaction.transaction_code,
            transaction.transaction,
            transaction.progress,
            {$transaction_status}
        FROM
            client
        LEFT JOIN
            transaction ON client.id = transaction.client_id
        WHERE {$where_query}";

        return $this->db->query($view_transaction_by_user_level)->result_array();
    }

    function get_client_transaction_by_id($id)
    {
        $query = 
            "SELECT 
                client.*,
                transaction.transaction,
                transaction.transaction_code,
                transaction.progress,
                transaction.has_requirements,
                transaction.received_at,
                transaction.prepared_at, 
                transaction.verified_at, 
                transaction.approve_at
            FROM
                client
            LEFT JOIN
                transaction ON client.id = transaction.client_id
            WHERE
                client.id = ?";
        return $this->db->query($query, $id)->result_array(); 
    }

    /* This function handles the validation of inputs in adding new transaction and it returns an 
        error message if error is found in the form.  
    */
    function add_transaction_validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<p class="mb-2 bg-danger text-white p-2 col-11 col-lg-8 col-xxl-9 text-center mx-auto">', '</p>');
        $this->form_validation->set_rules("firstname", "First Name", "trim|required");
        $this->form_validation->set_rules("middlename", "Middle Name", "trim|required");
        $this->form_validation->set_rules("lastname", "Last Name", "trim|required");
        $this->form_validation->set_rules("barangay", "Barangay", "trim|required");
        $this->form_validation->set_rules('street_zone', 'Street/Zone', 'trim|required');
        $this->form_validation->set_rules("contact", "Contact Number", "trim|required");
        $this->form_validation->set_rules("received_by", "Received by", "trim|required");
        $this->form_validation->set_rules("trasaction", "Type of transaction", "trim|required");

        if (!$this->form_validation->run()) {
            return validation_errors();
        }
    }

    /* This function handles the saving of new transaction in the database. */
    function add_transaction($transaction)
    {
        /* Insert in clients personal info. */
        $client_query = "INSERT INTO client (firstname, middlename, lastname, contacts, barangay, street_zone) VALUES (?,?,?,?,?,?)";
        $client_values = array(
            $this->security->xss_clean($transaction['firstname']),
            $this->security->xss_clean($transaction['middlename']),
            $this->security->xss_clean($transaction['lastname']),
            $this->security->xss_clean($transaction['contact']),
            $this->security->xss_clean($transaction["barangay"]),
            $this->security->xss_clean($transaction["street_zone"]),
        );

        $this->db->query($client_query, $client_values);
        /* Fetch the successfull inserted client id */
        $insert_client_id = $this->db->insert_id();

        /* Generate transaction code */
        $transaction_code = 0; 
        $row = $this->db->query('SELECT MAX(transaction_id) AS `maxid` FROM transaction')->row(); 
        if ($row) { 
            $transaction_code = $row->maxid;
            (int)$transaction_code++;
        }
        $has_requirements = 0;
        $progress = "Pending";
        if(isset($transaction['requirements'])){
            $progress = "On Going";
            $has_requirements = 1;
        }

        $received_at_details = [$this->security->xss_clean($transaction['received_by']), date("Y-m-d, H:i:s")];

        /* Insert details in transaction table. */
        $transaction_query = 
            "INSERT INTO transaction 
                (client_id, transaction_code, transaction, progress, has_requirements, received_at, created_at) 
            VALUES (?,?,?,?,?,?,?)"; 
        $transaction_values = array(
            $insert_client_id,
            $transaction_code,
            $this->security->xss_clean($transaction['trasaction']),
            $progress,
            $has_requirements,
            json_encode($received_at_details),
            date("Y-m-d, H:i:s")
        );
        
        $this->db->query($transaction_query, $transaction_values);
    }

    /* This function handles the updating of products in the database and returns the product id back. */
    function update_client_transaction_by_id($transaction_data)
    {
        $this->delete_previous_approved_transaction($this->security->xss_clean($transaction_data['id']));
        $has_requirements = 0;
        $progress = "Pending";
        if($this->session->userdata('user_level') === "4"){
            $progress = "Verified";
            $has_requirements = 1;
        }else{ 
            if(isset($transaction_data['requirements'])){
                $progress = "On Going";
                $has_requirements = 1;
            }
        }
        
        $query = 
            "UPDATE 
                client
             INNER JOIN
                transaction 
             ON 
                client.id = transaction.client_id 
             SET 
                client.firstname = ?,
                client.middlename = ?,
                client.lastname = ?,
                client.contacts = ?,
                client.barangay = ?,
                client.street_zone = ?,
                transaction.transaction = ?,
                transaction.progress = ?,
                transaction.has_requirements = ?
             WHERE
                client.id = ?";
        $values = array(
            $this->security->xss_clean($transaction_data['firstname']),
            $this->security->xss_clean($transaction_data['middlename']),
            $this->security->xss_clean($transaction_data['lastname']),
            $this->security->xss_clean($transaction_data['contact']),
            $this->security->xss_clean($transaction_data['barangay']),
            $this->security->xss_clean($transaction_data['street_zone']),
            $this->security->xss_clean($transaction_data['transaction']),
            $progress,
            $has_requirements,
            $this->security->xss_clean($transaction_data['id']),
        );
        $this->db->query($query, $values);
        $code_no = $this->db->query('SELECT transaction_code AS `transaction_code` FROM transaction WHERE client_id='.$transaction_data["id"].'')->row(); 
        return 'Client transaction no. '. $code_no->transaction_code .' of '.$transaction_data['firstname']." ".$transaction_data['middlename']." ".$transaction_data['lastname']. ' is updated successfully!';
    } 

    function delete_previous_approved_transaction($id){
        $current_progress = $this->get_client_transaction_by_id($id);
        if($current_progress[0]['progress'] === "Approved"){
             $query = 
            "UPDATE 
                client
             INNER JOIN
                transaction 
             ON 
                client.id = transaction.client_id 
             SET
                transaction.prepared_at = ?,
                transaction.verified_at = ?,
                transaction.approve_at = ?
             WHERE
                client.id = ?";

            $values = array(
                NULL,
                NULL,
                NULL,
                $id,
            );
            $this->db->query($query, $values);
        }
    }

    function update_client_transaction_progress_by_id($transaction_data)
    {
        $status_type = "";
        $status_progess = "";
        if ($this->session->userdata('user_level') === "2") {
            $status_progess = "Prepared";
            $status_type = "prepared_at";
            $updated_response = "prepared";
            $updated_by = $transaction_data['updated_by'];
        }else if ($this->session->userdata('user_level') === "3") {
            $status_progess = "Verified";
            $status_type = "verified_at";
            $updated_response = "verified";
            $updated_by = $transaction_data['updated_by'];
        }else if ($this->session->userdata('user_level') === "4") {
            $status_progess = "Approved";
            $status_type = "approve_at";
            $updated_response = "approve";
            $updated_by = "Loren May";
        }

        $query = "UPDATE transaction SET progress = ?, {$status_type} = ? WHERE transaction_id = ?;";
        $updated_status_details = [$this->security->xss_clean($updated_by), date("Y-m-d, H:i:s")]; 
        $values = array(
            $status_progess,
            json_encode($updated_status_details),
            $this->security->xss_clean($transaction_data['client_form_id']),
        );
        $this->db->query($query, $values);
        $code_no = $this->db->query('SELECT transaction_code AS `transaction_code` FROM transaction WHERE client_id='.$transaction_data["client_form_id"].'')->row(); 
        return 'Client transaction no. '. $code_no->transaction_code . ' is '.$updated_response.' successfully!';
        
    }
}
