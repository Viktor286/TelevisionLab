<?

/* Global elements */
require_once('../_global/core.php');
require_once("../_global/config/private/form-token.php");
require_once("../_global/config/private/vimeo-token.php");
require_once('../_global/model/TvLabQuery.php');

$TvLab = new TvLab;
$q = new TvLabQuery;

/* Local elements */
require_once("../_global/lib/vendors/auth/password_compatibility_library.php");
require_once("../_global/lib/vendors/auth/login.php");
require_once("../_global/controllers/SessionStuff.php");

$login = new Login;

// require_once('../_global/lib/vendors/vimeo/vimeo.php');

require_once '../_global/controllers/Forms.php';
require_once 'controllers/AutoTags.php';
require_once 'controllers/ScreenFadeMsg.php';
require_once 'controllers/InOut.php';
require_once 'controllers/GetRemoteImage.php';

require_once 'lang/add_module_eng.php';

$Input = array(
    "getTitle" => $_POST['title'],
    "getAuthors" => $_POST['authors'],
    "getLocation" => $_POST['location'],
    "getYear" => $_POST['year'],
    "getBrand" => $_POST['brand'],
    "getTv_Channel" => $_POST['tv'],
    "getMotion_Type" => $_POST['motion'],
    "getBroadcast_Type" => $_POST['broadcast'],
    "getTempo" => $_POST['tempo'],
    "getRating" => $_POST['rating'],
    "getCost" => $_POST['cost'],
    "getTags_SA" => $_POST['sa'],
    "getTags_Fashion" => $_POST['fashion'],
    "getTags_Arts" => $_POST['arts'],
    "getTags_Music" => $_POST['music'],
    "getTags_Others" => $_POST['tags'],
    "getBy_User" => $_POST['by_user'],
    "getVideo" => $_POST['video'],
    "getToken" => $_POST['_token'],
);

extract(SecureVars($Input), EXTR_OVERWRITE);

if (!$q->setAuthUser()) {
    unset($AuthUser);
} // set-unset $AuthUser

$Role = RoleState();
if ($Role == 1 or $Role == 2) {
    $isStack = "_stack";
}
if ($Role == 0) {
    $isStack = "";
}

$dateNow = date('Y-m-d H:i:s');
$errorCount = 0;
$errorInfo = "";


//--------- Base Routing of 'add' module

// Situation 0: no code or isVideoExist or even getVideo
if (empty($getCode) or $isVideoExist > 0) {
    if (!isset($getVideo)) {
        $ps = "(0)setDefault";
    }
}

// Situation 1: have a code and it will pass check
if (Check_Valid_Id($_GET['code'])) {
    $ps = "(1)setCode";
    preg_match('/(\d{4,15})/', $_GET['code'], $Vimeo_Id);
    $Vimeo_Id = $Vimeo_Id[0];
}

// Situation 2: there is correct "video" and "title" params in GET array
if (Check_Valid_Id($getVideo) and isset($getTitle)) {
    $ps = "(2)setVideo";
}


//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    'SiteName' => SITE_TITLE,
    'SiteUrl' => SITE_URL,
    'PageTitle' => 'Television Lab database add',
    'Description' => 'Motion Design and Broadcast Graphics database',

    'css' => array(
        '/_global/css/reset.css',
        '/_global/css/general.css',
        '/_global/css/ddslick.css',
        //'/_global/css/fonts-google-opensans.css',
        'google_fonts',
        '/add/css/add.css'
    ),

    'js' => array(
        '/_global/js/compatibility.js',
        '/_global/js/jquery-1.11.0.min.js',
        '/_global/js/jquery-ui.js',
        '/_global/js/jquery.ddslick.min.js',
        '/add/js/scripts.js',
        '/add/js/others.js',
    ),

    'Prepend' => '',
    'Append' => ''
);

insertHead($HeadLayoutSet, '../_global/views/HeadTpl.php');

?>

    <script type="text/javascript">
        var getRating = <? if (isset ($getRating)) {
            echo $getRating;
        } else {
            echo '17000';
        } ?>;
        var getTempo = <? if (isset ($getTempo)) {
            echo $getTempo;
        } else {
            echo '85';
        } ?>;

        $(document).ready(function () {
            $('#broadcast').ddslick('select', {
                index: <? if (isset ($getBroadcast_Type)) {
                echo $getBroadcast_Type;
            } else {
                echo 0;
            } ?>
            });
        });

    </script>


<?php
//echo "<div class='debug'>";  $TvLab->DebugCookie(1);  echo "</div>";

if ($ps == "(0)setDefault") {
    include("views/view_intro.php");
}


if ($ps == "(1)setCode") {

    if (isset ($AuthUser)) {
        $TestIdQuery = "SELECT * FROM u186876_tvarts.contents WHERE OutId = " . $Vimeo_Id . " AND State = 1";
        $result = $q->Query($TestIdQuery);

        if ($result->num_rows > 0) {

            $isVideoExist = 1; // Set flag, that define isVideoExist
            include("views/view_intro.php"); // If video exist check inside this chunk,

        } else {

            //
            $v = $q->getVideoCreditsAPI($Vimeo_Id);
            $OutId = $v->OutId;
            $OutHost = $v->OutHost;
            $Title = $v->Title;
            $Likes = $v->Likes;
            $Desc = $v->Desc;
            $CreateDate = $v->CreateDate;
            $Tags = $v->Tags;
            $TagList = $v->TagList;
            $CastList = $v->CastList;
            $Duration = $v->Duration;
            $Brand = $v->Brand;
            $ImgSmall = $v->ImgSmall;
            $Img = $v->Img;
            $Width = $v->Width;
            $Height = $v->Height;
            $MainUserLocation = $v->MainUserLocation;
            $Year = $v->Year;

            //$q->getVideoFromVimeo($Vimeo_Id); // Otherwise run Vimeo API connection
            include('views/view_input.php');
        }
    } else {

//    echo "<div style='text-align: center; margin: 50px auto 0; width: 400px;'>You need to log in to post this video<br />";
//    include("views/not_logged_in.php");
        $v = $q->getVideoCreditsAPI($Vimeo_Id);
        $OutId = $v->OutId;
        $OutHost = $v->OutHost;
        $Title = $v->Title;
        $Likes = $v->Likes;
        $Desc = $v->Desc;
        $CreateDate = $v->CreateDate;
        $Tags = $v->Tags;
        $TagList = $v->TagList;
        $CastList = $v->CastList;
        $Duration = $v->Duration;
        $Brand = $v->Brand;
        $ImgSmall = $v->ImgSmall;
        $Img = $v->Img;
        $Width = $v->Width;
        $Height = $v->Height;
        $MainUserLocation = $v->MainUserLocation;
        $Year = $v->Year;
        include('views/view_input.php');
//    echo "</div>";

    }

}

if ($ps == "(2)setVideo") {
    if (!isset ($AuthUser)) {
        die;
    }

    $v = $q->getVideoCreditsAPI($getVideo);
    // $q->getVideoFromVimeo($getVideo); // Run Vimeo API connection with "video" from GET parameter

    $OutId = $v->OutId;
    $OutHost = $v->OutHost;
    $Title = $v->Title;
    $Likes = $v->Likes;
    $Desc = $v->Desc;
    $CreateDate = $v->CreateDate;
    $Tags = $v->Tags;
    $TagList = $v->TagList;
    $CastList = $v->CastList;
    $Duration = $v->Duration;
    $Brand = $v->Brand;
    $ImgSmall = $v->ImgSmall;
    $Img = $v->Img;
    $Width = $v->Width;
    $Height = $v->Height;
    $MainUserLocation = $v->MainUserLocation;
    $Year = $v->Year;

    include('views/view_input.php');

    if (Check_Valid_Id($OutId)) {
        $Prm = 1;
    } else {
        $QuerryErrors .= $nme_err_NoId . ', ';
        $Prm = 0;
    }

    if (!empty($getTitle) and iconv_strlen($getTitle, 'UTF-8') > 2) {
        $Prm = ($Prm == 1) ? 1 : 0;
    } else {
        $QuerryErrors .= $nme_err_NoTitle . ', ';
        $Prm = 0;
    }

    if (isset($Likes)) {
        $Prm = ($Prm == 1) ? 1 : 0;
    } else {
        $QuerryErrors .= $nme_err_NoAPI . ', ';
        $Prm = 0;
    }

    if (!empty($Img) and iconv_strlen($Img, 'UTF-8') > 8) {
        $Prm = ($Prm == 1) ? 1 : 0;
    } else {
        $QuerryErrors .= $nme_err_NoImg . ', ';
        $Prm = 0;
    }

    if (!empty($getTags_SA) or !empty($getTags_Fashion) or !empty($getTags_Arts) or !empty($getTags_Music) or !empty($getTags_Others)) {
        $Prm = ($Prm == 1) ? 1 : 0;
    } else {
        $QuerryErrors .= $nme_err_NoTags . ', ';
        $Prm = 0;
    }

    if (isset($AuthUser)) {
        {
            $Prm = ($Prm == 1) ? 1 : 0;
        }
    } else {
        $QuerryErrors .= $nme_err_NoUser . ' ';
        $Prm = 0;
    }

    $hash = md5($_SESSION['token'] . APPEND_KEY . HALF_DAY);

    if (!empty ($getToken) and $getToken == $hash) {
        {
            $Prm = ($Prm == 1) ? 1 : 0;
        }
    } else {
        $QuerryErrors .= $nme_err_NoToken;
        $Prm = 0;
    }

    $getBroadcast_Type = implode(",", $getBroadcast_Type);
    $getMotion_Type = implode(",", $getMotion_Type);

    //$Prm = 0;
    if ($Prm == 1) {

        if ($q->putVideo($AuthUser, $isStack)) {

            ScreenFadeMsg($getTitle, $nme_msgTxt, "add/");
        }

    } else {
        if (isset($QuerryErrors)) {
            echo '<div class="warning">
					<table width="100%">
						<tr>
						<td width="50%"></td>
						<td width="50%">' . $nme_err_SendStatus . ': ' . $QuerryErrors . '</td>
						</tr>
					</table>
				</div>';
        }
    }

    //DEBUG STUFF
    $debug = 0;
    $debug_crossParameters = '
	<br />$getTitle = ' . $getTitle . '
	<br />$OutId = ' . $OutId . '
	<br />$OutHost = ' . $OutHost . '
	<br />$Img = ' . $Img . '
	<br />$ImgSmall = ' . $ImgSmall . '
	<br />$getAuthors = ' . $getAuthors . '
	<br />$getBrand = ' . $getBrand . '
	<br />$getTv_Channel = ' . $getTv_Channel . '
	<br />$getLocation = ' . $getLocation . '
	<br />$Likes = ' . $Likes . '
	<br />$getRating = ' . $getRating . '
	<br />$getMotion_Type = ' . $getMotion_Type . '
	<br />$getBroadcast_Type = ' . $getBroadcast_Type . '
	<br />$getTempo = ' . $getTempo . '
	<br />$getTags_SA = ' . $getTags_SA . '
	<br />$getTags_Fashion = ' . $getTags_Fashion . '
	<br />$getTags_Arts = ' . $getTags_Arts . '
	<br />$getTags_Music = ' . $getTags_Music . '
	<br />$getTags_Others = ' . $getTags_Others . '
	<br />$getYear = ' . $getYear . '
	<br />$Duration = ' . $Duration . '
	<br />$Width = ' . $Width . '
	<br />$Height = ' . $Height . '
	<br />$dateNow = ' . $dateNow . '
	<br />$dateNow = ' . $dateNow . '
	<br />$session_User = ' . $session_User;

    if ($debug == 1) {
        echo $debug_crossParameters . "<br />=========================<br />" . $insertQuery;
    }

}

insertFooter("../_global/views/FooterTpl.php");