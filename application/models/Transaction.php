<?php
class Transaction extends CI_Model
{

    /* This function returns all the products detail from the database. */
    // function get_all_products()
    // {
    //     return $this->db->query("SELECT * FROM products;")->result_array();
    // }

    /* This function handles the validation of inputs in adding new transaction and it returns an 
        error message if error is found in the form.  
    */
    function add_transaction_validation()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div>', '</div>');
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
        $current_day = date("HisYmd");
        $random_number = strtoupper(substr(uniqid(sha1(time())),0,4));
        $unique = "#" . $current_day . $random_number;

        /* Insert details in ticket table. */
        $ticket_query = "INSERT INTO ticket (reference_code, created_at) VALUES (?,?)";
        $ticket_values = array(
            $unique,
            date("Y-m-d, H:i:s")
        );

        $this->db->query($ticket_query, $ticket_values);
        /* Fetch the successfull inserted ticket id */
        $insert_ticket_id = $this->db->insert_id();

        /* Insert details in transaction table. */
        $transaction_query = "INSERT INTO transaction (client_id, ticket_id, transaction, progress, received_at) VALUES (?,?,?,?,?)";
        $transaction_values = array(
            $insert_client_id,
            $insert_ticket_id,
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

    // /* This function handles the updating of products in the database and returns the product id back. */
    // function update_product($transaction)
    // {
    //     $query = "UPDATE products SET name = ?, description = ?, price = ?, inventory_count = ?, updated_at = ? WHERE id = ?";
    //     $values = array(
    //         $this->security->xss_clean($transaction['name']),
    //         $this->security->xss_clean($transaction['description']),
    //         $this->security->xss_clean($transaction['price']),
    //         $this->security->xss_clean($transaction['inventory_count']),
    //         date('Y-m-d, H:i:s'),
    //         $transaction['id']
    //     );
    //     $this->db->query($query, $values);
    //     return $transaction['id'];
    // }

    // /* This function handles the deleting of specific product in the database by using the product id. */
    // function remove_product_by_id($id)
    // {
    //     $query = "DELETE FROM products WHERE id = ?";
    //     return $this->db->query($query, $id);
    // } 
}
