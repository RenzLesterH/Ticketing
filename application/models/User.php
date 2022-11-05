<?php
class User extends CI_Model
{
    /* This function returns the email fetch in the database.   
        */
    function get_user_by_email($email)
    {
        $query = "SELECT * FROM user WHERE contacts=?";
        return $this->db->query($query, $this->security->xss_clean($email))->result_array()[0];
    }

    /* This function validates the user login inputs and it return error message
        if some errors are found.  
    */
    function validate_login()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run()) {
            return validation_errors();
        } else {
            return "success";
        }
    }

    /* This function validates the user login process and it return error message 
           if some errors are found.  
        */
    function validate_login_match($user, $password)
    {
        $hash_password = md5($this->security->xss_clean($password));

        if ($user && $user['password'] == $hash_password) {
            return "success";
        } else {
            return "Incorrect email/password.";
        }
    }
}
