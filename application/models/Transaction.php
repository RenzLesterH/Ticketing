<?php
class Transaction extends CI_Model
{

    /* This function returns all the client transaction detail from the database. */
    function get_all_transaction()
    {
        return $this->db->query(
            "SELECT 
                client.*,
                transaction.transaction,
                transaction.progress,
                transaction.received_at
            FROM
                client
            LEFT JOIN
                transaction ON client.id = transaction.client_id
            WHERE
                transaction.progress = 'On Going';"
        )->result_array();
    }

    function get_client_transaction_by_id($id)
    {
        $query = 
            "SELECT 
                client.*,
                transaction.transaction,
                transaction.progress,
                transaction.received_at
            FROM
                client
            LEFT JOIN
                transaction ON client.id = transaction.client_id
            WHERE
                transaction.progress = 'On Going'
            AND 
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

        /* Generate unique and random ticket reference id */
        $transaction_code = 0; 
        $row = $this->db->query('SELECT MAX(transaction_id) AS `maxid` FROM transaction')->row(); 
        if ($row) { 
            $transaction_code = $row->maxid;
            (int)$transaction_code++;
        }

        /* Insert details in transaction table. */
        $transaction_query = "INSERT INTO transaction (client_id, transaction_code, transaction, progress, received_at) VALUES (?,?,?,?,?)";
        $transaction_values = array(
            $insert_client_id,
            $transaction_code,
            $this->security->xss_clean($transaction['trasaction']),
            "On Going",
            date("Y-m-d, H:i:s")
        );
        
        $this->db->query($transaction_query, $transaction_values);
    }

    // /* This function returns a specific product from the database using the product id. */
    // function get_products_by_id($id)
    // {
    //     $query = "SELECT * FROM products WHERE id = ?";
    //     return $this->db->query($query, $id)->result_array();
    // }

    /* This function handles the updating of products in the database and returns the product id back. */
    function update_client_transaction_by_id($transaction_data)
    {
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
                transaction.transaction = ?
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
            $this->security->xss_clean($transaction_data['id']),
        );
        $this->db->query($query, $values);
        return $transaction_data['firstname']." ".$transaction_data['middlename']." ".$transaction_data['lastname'];
    }

    // /* This function handles the deleting of specific product in the database by using the product id. */
    // function remove_product_by_id($id)
    // {
    //     $query = "DELETE FROM products WHERE id = ?";
    //     return $this->db->query($query, $id);
    // } 
}
