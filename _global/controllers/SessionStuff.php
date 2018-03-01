<?php

function RoleState()
{
    if ($_SESSION['user_login_status'] == 1) {
        return $_SESSION["user_role"];
    } else {
        return 5;
    }
}