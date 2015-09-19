<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        //session_start();
		
        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
		
		if (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }


    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT user_name, user_email, user_password_hash, Role, Activity, Added, Edit
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        //Save Token to Session
                        $time_hold = round( microtime( get_as_float ), 0);
                        $r1 = rand(2,5); $r2 = rand(5,15); $r3 = rand(5,15);
                        $ncr_time_hold = round ( (($time_hold*$r1)/$r2)/$r3, 0 ); // random change on timestamp
                        $Local_Token =  md5(PREPEND_KEY . $ncr_time_hold . APPEND_KEY);

                        //Save Token + Info to DataBase
                        $TimeStamp = date('Y-m-d H:i:s');
                        $SetToken = 'UPDATE u186876_tvarts.users SET last_login_mt = "' . $ncr_time_hold . '", last_login = "' . $TimeStamp . '", last_ip = "' . $_SERVER['REMOTE_ADDR'] . '" where user_name = "' . $result_row->user_name . '"';

                        //if saving is ok, seed session
                        if ($this->db_connection->query($SetToken))
                        {

                            session_set_cookie_params(25200,"/","",0,1);
                            session_name("TvLab");
                            session_start();
                            session_regenerate_id(true);

                            $_SESSION['user_name'] = $result_row->user_name;
                            $_SESSION['user_email'] = $result_row->user_email;
                            $_SESSION['user_role'] = $result_row->Role;
                            $_SESSION['user_login_status'] = 1;

                            $_SESSION['user_activity'] = $result_row->Activity;
                            $_SESSION['user_added'] = $result_row->Added;
                            $_SESSION['user_edit'] = $result_row->Edit;
                            $_SESSION['user_board'] = 1;
                            $_SESSION['regen'] = 0;
                            $_SESSION['token'] = $Local_Token;

                        } else {
                            echo "Set Token Error"; exit;
                        }

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
