<?php
//Connect to common TvLab Session
session_name("TvLab");
session_start();

//Define transfer vars
$BoardState = $_POST['boardstate'];
$TagMenuState = $_POST['tmstate'];


//01 -- Accept query from TagMenuState
if (isset ($_POST['tmstate']))
	{
		if ($TagMenuState >= 0 and $TagMenuState < 10)
			{setcookie ("TagMenuState", $TagMenuState);}
	}

//02 -- Accept query from BoardState
if (isset ($_POST['boardstate']))
	{
        //echo "| Got ".$_POST['boardstate']." | ";
		if ($BoardState >= 0 and $BoardState < 2)
		{
            $_SESSION["user_board"] = $_POST['boardstate'];
            //echo "--user_board set to " . $_SESSION["user_board"];

		}
	}



?>
