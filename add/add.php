<?
require_once("../lib/core.php");
$TvLab = new TvLab;
$q = new TvLabQuery;

require_once("../lib/password_compatibility_library.php");
require_once("../lib/login.php"); // классы ситемы login
$login = new Login;

require_once('../lib/vimeo/vimeo.php'); //классы для работы с vimeo API

require_once '../nodes/autotags_add.php'; //теговая система
require_once '../lib/lang/rus.php'; //семантика блока

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

extract( SecureVars( $Input ), EXTR_OVERWRITE );



if ( !$q->setAuthUser() ) { unset( $AuthUser ); } // set-unset $AuthUser

$Role = RoleState();
if ($Role == 1 or $Role == 2) {$isStack = "_stack";}
if ($Role == 0) {$isStack = "";}

//Предварительные переменные
$dateNow = date('Y-m-d H:i:s');
$errorCount = 0;
$errorInfo = "";


//---------Base Routing

// Situation 0: no code or isVideoExist or even getVideo
if( empty($getCode) or $isVideoExist > 0 ){
	if (!isset($getVideo)) {
		$ps = "(0)setDefault";
	}
}

// Situation 1: have a code and it will pass check
if ( Check_Valid_Id($_GET['code']) ) {
        $ps = "(1)setCode";
        preg_match('/(\d{4,15})/', $_GET['code'], $Vimeo_Id); $Vimeo_Id = $Vimeo_Id[0]; //достаем id из любого кода, помещаем в $Vimeo_Id для последующего подключения к API Vimeo
}

// Situation 2: there is correct "video" and "title" params in GET array
if ( Check_Valid_Id($getVideo) and isset($getTitle) ) {
		$ps = "(2)setVideo";
}


//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Television Lab database add",
    "Description" => "Motion Design and Broadcast Graphics database",
    "css" => array ("reset", "general", "add", "ddslick", "google_fonts"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "jquery-ui", "jquery.ddslick.min", "scripts[add]"),
    "Prepend" => '',
    "Append" => ''
);

insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");

?>


<script type="text/javascript">
$(function() {
    $( "#Rating" ).slider({value: <? if (isset ($getRating)) {echo $getRating;} else {echo '17000';}?>});
    $( "#RatingAmount" ).val($("#Rating").slider("value"));
	$( "#RatingDisplay" ).text($("#Rating").slider("value"));

	
	$( "#Tempo" ).slider({value: <? if (isset ($getTempo)) {echo $getTempo;} else {echo '75';}?>});
    $( "#TempoAmount" ).val($("#Tempo").slider("value"));
	$( "#TempoDisplay" ).text( $("#Tempo").slider("value"));

	
	RatingComment($( "#RatingDisplay" ).text());
	TempoComment($( "#TempoDisplay" ).text());

  });
  
$(document).ready(function() {
	$('#broadcast').ddslick({
		width: 400,
		height: null,
		onSelected: function(selectedData){
			var sIndx = selectedData.selectedIndex;
			$('#broadcastHidden option[value=' + sIndx + ']').prop("selected", true);
    }   
	});
});

$(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn(0);
    });
});

$(document).ready(function() {
    $("#HowItWorks").click(function(event) {
		$("#HowItWorks-Img").slideToggle();
    });
});
</script>

</head>
<body>

<?php
//echo "<div class='debug'>";  $TvLab->DebugCookie(1);  echo "</div>";

if ($ps == "(0)setDefault") { include ("view_intro.php"); }


if ($ps == "(1)setCode") {

    if ( isset ($AuthUser) ) {
        $TestIdQuery = "SELECT * FROM u186876_tvarts.contents WHERE OutId = " . $Vimeo_Id . " AND State = 1"; //Проверка наличия дубликата видео в базе по OuId
        $result = $q->Query($TestIdQuery);

        if ($result->num_rows > 0) {

            $isVideoExist = 1; // Set flag, that define isVideoExist
            include("view_intro.php"); // If video exist check inside this chunk,

        } else {

            $q->getVideoFromVimeo($Vimeo_Id); // Otherwise run Vimeo API connection

            include('view_input.php');
        }
    } else {

    echo "<div style='text-align: center; margin: 50px auto 0; width: 400px;'>You need to log in to post this video<br />";

    include("../nodes/not_logged_in.php");

    echo "</div>";

    }

}


if ($ps == "(2)setVideo") {
    if ( !isset ($AuthUser) ) { die; }

	$q->getVideoFromVimeo($getVideo); // Run Vimeo API connection with "video" from GET parameter

	include ('view_input.php');

	//Начинаем проверку условий отправляемых карточкой параметров
	//Внешний ID ролика

	if (Check_Valid_Id($OutId)) {$Prm = 1;}
	else {$QuerryErrors .= $nme_err_NoId.', '; $Prm = 0;}
	
	//Заголовок видео
	if (!empty($getTitle) and iconv_strlen($getTitle, 'UTF-8') > 2)
	{$Prm = ($Prm == 1) ? 1 : 0; } else {$QuerryErrors .= $nme_err_NoTitle.', '; $Prm = 0;}
	
	//Проверяем данные с API на одном параметре "лайки" (он не передается в $_GET без явного участия юзера), наличие и число ли?
	if (isset($Likes))
	{ $Prm = ($Prm == 1) ? 1 : 0; }
	else {$QuerryErrors .= $nme_err_NoAPI.', '; $Prm = 0;}
	
	//Проверяем картинку на наличие и количество сиволов
	if (!empty($Img) and iconv_strlen($Img, 'UTF-8') > 8)
	{ $Prm = ($Prm == 1) ? 1 : 0; }
	else {$QuerryErrors .= $nme_err_NoImg.', '; $Prm = 0;}
	
	//Проверка на заполнение хотя бы одного тега в тэговой системе
	if (!empty($getTags_SA) or !empty($getTags_Fashion) or !empty($getTags_Arts) or !empty($getTags_Music) or !empty($getTags_Others))
	{ $Prm = ($Prm == 1) ? 1 : 0; }
	else {$QuerryErrors .= $nme_err_NoTags.', '; $Prm = 0;}
	
	//Проверка юзера
	if (isset($AuthUser)) {
		{ $Prm = ($Prm == 1) ? 1 : 0; }
	} else {$QuerryErrors .= $nme_err_NoUser.' '; $Prm = 0;}

    //Проверка токена
	$hash = md5( $_SESSION['token'].APPEND_KEY.HALF_DAY );

    if (!empty ($getToken) and $getToken == $hash) {
        { $Prm = ($Prm == 1) ? 1 : 0;}
    } else {$QuerryErrors .= $nme_err_NoToken; $Prm = 0;}


	//---------- подгатавливаем запись в базу
	//Перевод данных массивов в строки
	$getBroadcast_Type = implode(",", $getBroadcast_Type);
	$getMotion_Type = implode(",", $getMotion_Type);
	
	//NO RECORD
	//$Prm = 0;

	// если счетчик ошибок не сбросился на 0, то производим запись
	if ($Prm == 1) {
		
		if ($q->putVideo($AuthUser, $isStack)) {
			
			ScreenFadeMsg ($getTitle, $nme_msgTxt, "add/");
		}
		
	} else {
		if (isset($QuerryErrors)){
			echo '<div class="warning">
					<table width="100%">
						<tr>
						<td width="50%"></td>
						<td width="50%">'.$nme_err_SendStatus.': '.$QuerryErrors.'</td>
						</tr>
					</table>
				</div>';
			}
		}

	//DEBUG STUFF
	$debug = 0;
	$debug_crossParameters = '
	<br />$getTitle = '.$getTitle.'
	<br />$OutId = '.$OutId.'
	<br />$OutHost = '.$OutHost.'
	<br />$Img = '.$Img.'
	<br />$ImgSmall = '.$ImgSmall.'
	<br />$getAuthors = '.$getAuthors.'
	<br />$getBrand = '.$getBrand.'
	<br />$getTv_Channel = '.$getTv_Channel.'
	<br />$getLocation = '.$getLocation.'
	<br />$Likes = '.$Likes.'
	<br />$getRating = '.$getRating.'
	<br />$getMotion_Type = '.$getMotion_Type.'
	<br />$getBroadcast_Type = '.$getBroadcast_Type.'
	<br />$getTempo = '.$getTempo.'
	<br />$getTags_SA = '.$getTags_SA.'
	<br />$getTags_Fashion = '.$getTags_Fashion.'
	<br />$getTags_Arts = '. $getTags_Arts.'
	<br />$getTags_Music = '.$getTags_Music.'
	<br />$getTags_Others = '.$getTags_Others.'
	<br />$getYear = '.$getYear.'
	<br />$Duration = '.$Duration.'
	<br />$Width = '.$Width.'
	<br />$Height = '.$Height.'
	<br />$dateNow = '.$dateNow.'
	<br />$dateNow = '.$dateNow.'
	<br />$session_User = '.$session_User;
	
	if ($debug == 1) {
		echo $debug_crossParameters."<br />=========================<br />".$insertQuery;
		}

}

insertFooter ("../nodes/FooterTpl.php");