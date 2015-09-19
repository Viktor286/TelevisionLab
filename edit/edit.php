<?
header("Cache-Control: no-store");

require_once("../lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery();

if ( !$q->setAuthUser() ) { unset( $AuthUser ); die; }

require_once '../config/config.php'; //подключаем конфиг бд
require_once '../nodes/autotags_add.php'; //теговая система
require_once '../lib/lang/rus.php'; //семантика блока


//GET Setup for Video parameters
GET_Setup_Video();

//Выдача в зависимости от юзера
if (RoleState() == 1 or RoleState() == 2) {$isStack = "_stack";}
if (RoleState() == 0) {$isStack = "";}


//if var $getVideo is ok, get video data from base to variable set
if (isset ($getVideo)) {
	$q->getVideo($getVideo, $isStack, "SetGlobals");
}

//Предварительные переменные
$dateNow = date('Y-m-d H:i:s');
$errorCount = 0;
$errorInfo = "";

//Перевод данных массивов в строки
$getBroadcast_Type = implode(",", $getBroadcast_Type);
$getMotion_Type = implode(",", $getMotion_Type);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $Title." edit on Television Lab" ?></title>
<base href="http://www.televisionlab.ru/" /><!--[if IE]></base><![endif]-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/general.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.ddslick.min.js"></script>
<link href="css/ddslick.css" rel="stylesheet" type="text/css" />

<script src="js/scripts[add].js" type="text/javascript"></script>


<script type="text/javascript">
$(function() {
    $( "#Rating" ).slider({value: <? if (isset ($getRating)) {echo $getRating;} else {echo $Rating;}?>});
    $( "#RatingAmount" ).val($("#Rating").slider("value"));
	$( "#RatingDisplay" ).text($("#Rating").slider("value"));

	
	$( "#Tempo" ).slider({value: <? if (isset ($getTempo)) {echo $getTempo;} else {echo $Tempo;}?>});
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
    $(".delete").click(function() { 
 	$('span.realy_delete').fadeToggle();
      });
	 
});
  
</script>
</head>
<body>
<div class="Input_Form">

<?
include ('view_edit_input.php');


//chek for properly "delete" situation
if (isset($getVideo) and $_GET['delete'] == 1) {
	
	if ( $AuthUser == $By_User or $UserRole == 0 ) {// доступ на удаление для автора, админа. Здесь встает вопрос об организации иерархии доступа к редакции видео
	
		if ($q->deleteVideo()) {
			ScreenFadeMsg ($Title, "Удалено", "http://www.televisionlab.ru/"); //display state
		}
	} 
	else {echo "Вы не можете удалять это видео";}
		
}


//if auth user apply to valid video id and have something to change
if (isset($AuthUser) and isset($getVideo) and count($_GET) > 2) {
	if ( $AuthUser == $By_User or $UserRole == 0 ) {// доступ на удаление для автора, админа. Здесь встает вопрос об организации иерархии доступа к редакции видео
		
		if (!empty($getTitle) and iconv_strlen($getTitle, 'UTF-8') > 2) {$Prm = 1;} 
		else {$querryErrors .= 'отсутствует заголовок видео, '; $Prm = 0;}
		
		if (!empty($getTags_SA) or !empty($getTags_Fashion) or !empty($getTags_Arts) or !empty($getTags_Music) or !empty($getTags_Others))
		{ $Prm = ($Prm == 1) ? 1 : 0; }
		else {$querryErrors .= 'ни одного тега не заполнено, '; $Prm = 0;}
		
		//$Prm = 0; //No UPDATE
	
		if ($Prm == 1) {
			
			if ($q->saveVideo()) {
	
					ScreenFadeMsg ($getTitle, "Cохранено", "edit/?video=$OutId"); //display state
			}	
				
		} else {
			
		//Вывод ошибки в случае, если счетчик содержит ошибку
		echo '<div class="warning">
		<table width="100%">
		<tr>
		<td width="50%"></td>
		<td width="50%">Статус отправления: '.$querryErrors.'</td>
		</tr>
		</table>
		</div>';}
	}
}

?>
</div>

</body>
</html>

