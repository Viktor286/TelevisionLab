<?
header("Cache-Control: no-store");

/* Global elements */
require_once('../_global/core.php');
require_once("../_global/config/private/form-token.php");
require_once('../_global/model/TvLabQuery.php');

$TvLab = new TvLab;
$q = new TvLabQuery;

/* Local elements */
require_once("../_global/lib/vendors/auth/password_compatibility_library.php");
require_once("../_global/lib/vendors/auth/login.php");
require_once("../_global/controllers/SessionStuff.php");
require_once("controllers/DetectUpdate.php");


$login = new Login;

// require_once('../_global/lib/vendors/vimeo/vimeo.php');

require_once '../_global/controllers/Forms.php';
require_once '../add/controllers/AutoTags.php';
require_once '../add/controllers/ScreenFadeMsg.php';
require_once '../add/controllers/InOut.php';
require_once '../add/controllers/GetRemoteImage.php';

require_once '../add/lang/add_module_eng.php';

if ( !$q->setAuthUser() ) { unset( $AuthUser ); die; }


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



//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    'SiteName' => SITE_TITLE,
    'SiteUrl' => SITE_URL,
    'PageTitle' => 'Television Lab database add',
    'Description' => 'Motion Design and Broadcast Graphics database',

    'css' => array (
        '/_global/css/reset.css',
        '/_global/css/general.css',
        '/_global/css/add.css',
        '/_global/css/ddslick.css',
        //'/_global/css/fonts-google-opensans.css',
        'google_fonts'
    ),

    'js' => array (
        '/_global/js/compatibility.js',
        '/_global/js/jquery-1.11.0.min.js',
        '/_global/js/jquery-ui.js',
        '/_global/js/jquery.ddslick.min.js',
        '/add/js/scripts.js',
        '/add/js/get-form-elements.php',
        '/add/js/others.js',
    ),

    'Prepend' => '',
    'Append' => ''
);

insertHead ($HeadLayoutSet, '../_global/views/HeadTpl.php');

?>

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
        $('#broadcast').ddslick('select', {index: <? if (isset ($getBroadcast_Type)) {echo $getBroadcast_Type;} else {echo $Broadcast_Type;}?> });
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

<div class="Input_Form">

<?
include('views/view_edit_input.php');


//check for properly "delete" situation
if (isset($getVideo) and $_GET['delete'] == 1) {
	
	if ( $AuthUser == $By_User or $UserRole == 0 ) {// доступ на удаление для автора, админа. Здесь встает вопрос об организации иерархии доступа к редакции видео
	
		if ($q->deleteVideo()) {
			ScreenFadeMsg ($Title, "Удалено", "http://www.televisionlab.net/"); //display state
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

