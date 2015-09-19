<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>
<form method="post" name="loginform">
    <input id="login_input_username" placeholder="Username" class="login_input" type="text" name="user_name" required />
    <input id="login_input_password" placeholder="Password" class="login_input" type="password" name="user_password" autocomplete="off" required />
    <input type="submit"  name="login" class="login_input" value="Log in" />
</form>
