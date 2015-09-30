<?

/**
 * Classes TvLab and TvLabQuery
 * TvLab -- is for initialise environment, includes first or after header()
 * TvLabQuery -- is for database model
 */

class TvLab
{
    public $debugCookie = "0";

    public function __construct()
    {

        global $TimeStat; $TimeStat = microtime(true); // Start Time Statistics

        $this->CSP_Header(); //"Report-Only" --- empty flag will turn on CPS rules

        define("SITE_PATH", "/home/u186876/televisionlab.ru/www/");

        require_once("config/settings.php");
        require_once("config/security.php");
        require_once("config/db.php");
        require_once("functions.php");

        $this->TvLabSession();
        $this->LogOut();

        global $UserName, $UserEmail, $UserRole, $UserStatus, $UserActivity, $UserAdded, $UserBoard;
        $UserName = $_SESSION['user_name'];
        $UserEmail = $_SESSION['user_email'];
        $UserRole = $_SESSION['user_role'];
        $UserStatus = $_SESSION['user_login_status'];
        $UserActivity = $_SESSION['user_activity'];
        $UserAdded = $_SESSION['user_added'];
        $UserBoard = $_SESSION['user_board'];

    }


    //Smart Set Session
    public function TvLabSession()
    {

        if (isset($_COOKIE["TvLab"])) {

            session_set_cookie_params(25200, "/", "", 0, 1);// config session cookies: ["lifetime"]=> int(0) ["path"]=> string(1) "/" ["domain"]=> string(0) "" ["secure"]=> bool(false) ["httponly"]=> bool(true)
            session_name("TvLab");
            session_start();

            if (++$_SESSION['regen'] >= 4) {
                $_SESSION['regen'] = 0;
                session_regenerate_id(true);
            }

        }
    }

    public function LogOut()
    {

        if (isset ($_GET['logout'])) {
            $_SESSION = array(); //erase array
            session_destroy();
            echo '<script type="text/javascript">window.history.pushState("", "", "http://www.televisionlab.ru/"); location.reload(); </script>'; //to main page
            exit();
        }
    }


    public function CSP_Header($flag)
    {

        if ($flag == "Report-Only") {
            $csp = "Content-Security-Policy-Report-Only: ";
        } else {
            $csp = "Content-Security-Policy: ";
        }

        $csp .=
            "default-src 'none'; "
            . "script-src 'self' mc.yandex.ru 'unsafe-inline' 'unsafe-eval' ;"
            . "img-src i.vimeocdn.com mc.yandex.ru 'self' data: ;"
            . "connect-src 'self' mc.yandex.ru f.vimeocdn.com vimeo.com; "
            . "style-src 'self' fonts.googleapis.com 'unsafe-inline' ; "
            . "font-src 'self' fonts.googleapis.com fonts.gstatic.com ; "
            . "media-src 'self' player.vimeo.com; "
            . "frame-src 'self' player.vimeo.com; "
            . "object-src 'self' vimeo.com; ";

        header($csp);
    }

    public function showDebugCookie()
    {
        if ($this->debugCookie == 1) {
            echo '<div class="debugCookie">';

            echo "Session_name: " . session_name() . "<br />";
            echo "Session_id: " . session_id() . "<br />";
            echo "Sess_Token: " . $_SESSION['token']. "<br />&nbsp;<br />";


            echo "<div>S_SESSION:<pre> "; print_r($_SESSION); echo "</pre></div>";

            echo "<div>Sess_cookie_params:<pre> "; var_dump(session_get_cookie_params()); echo "</pre></div>";

            echo '<div style="float:none;">S_COOKIE:<pre>'; print_r($_COOKIE); echo "</pre></div>";


            echo '<div class="clear"></div>';

            echo '</div>';
        }

    }


}



class TvLabQuery
{
	private $mysql = null;
	
	public $Title;
	public $OutId;
	public $OutHost;
	public $Img;
	public $Img_Small;
	public $Authors;
    public $Authors_Id;
	public $Location;
	public $Brand;
	public $Tv_Channel;
	public $Likes;
	public $Rating;
	public $Cost;
	public $Motion_Type;
	public $Broadcast_Type;
	public $Tempo;
	public $Tags_SA;
	public $Tags_Fashion;
	public $Tags_Arts;
	public $Tags_Music;
	public $Tags_Others;
	public $Date_Origin;
	public $Year;
	public $Duration;
	public $Date_Create;
	public $Width;
	public $Height;
	public $State;
	
 	public function __construct() {

	}

	
	//Common query wrapper
	public function Query($Query) {
		$this->mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->mysql->connect_errno > 0){
			print ('Unable to connect to database [' . $this->mysql->connect_error . ']');
		} else {$this->mysql->set_charset("utf8");}
		
		if(!$result = $this->mysql->query($Query)){die('Error [' . $this->mysql->error . ']');}
		
		return $result;
		$result->close();
	}


	public function setAuthUser() {

		global $AuthUser;

		//Test is session Name and Token exist
		if (!empty($_SESSION['user_name']) and !empty($_SESSION['token'])) {

			$Input = array("session_User" => $_SESSION['user_name']); //Prepare user_name from session
			extract( SecureVars($Input), EXTR_OVERWRITE); //Output secure $session_User

			//if user_name pass SecureVars() exam and stayed the same
			if ($_SESSION['user_name'] == $session_User) {

				//Send user_name query
				$TestUserQuery = 'SELECT last_login_mt FROM u186876_tvarts.users WHERE user_name = "' . $session_User . '"';
				$result = $this->Query($TestUserQuery);

				if ($result->num_rows > 0) { //if user exist in db

					while ($row = mysqli_fetch_assoc($result)) { $Last_Time_Hold = $row['last_login_mt']; }

					//Test last token (word + tm) with word + last db tm
					if ($_SESSION['token'] == md5(PREPEND_KEY . $Last_Time_Hold . APPEND_KEY)) {

						$AuthUser = $session_User;
						//echo "ok sess " . $_SESSION['token'] . " = db " . md5(PREPEND_KEY . $Last_Time_Hold . APPEND_KEY);
						return true;
					}

				} else { return false; } //user not exist in db

			} else { echo "user_name is not secure"; return false; } //user_name is not secure

		} else { return false; }

	}

	
	
	public function putVideo($UserName, $isStack) {
		global $UserAdded, $getTitle, $OutId, $OutHost, $Img, $ImgSmall, $getAuthors, $getLocation, $getBrand, $getTv_Channel, $Likes, $getRating, $getCost, $getMotion_Type, $getBroadcast_Type, $getTempo, $getTags_SA, $getTags_Fashion, $getTags_Arts, $getTags_Music, $getTags_Others, $CreateDate, $getYear, $Duration, $Width, $Height, $dateNow, $UserName;

        $getTags_SA = strtolower($getTags_SA);
        $getTags_Fashion = strtolower($getTags_Fashion);
        $getTags_Arts = strtolower($getTags_Arts);
        $getTags_Music = strtolower($getTags_Music);
        $getTags_Others = strtolower($getTags_Others);

		$insertQuery = "
			INSERT INTO u186876_tvarts.contents".$isStack." (
			Title, OutId, OutHost, Img, Img_Small, Authors, Location, Brand, Tv_Channel, Likes, Rating, Cost, Motion_Type, Broadcast_Type, Tempo, Tags_SA, Tags_Fashion, Tags_Arts, Tags_Music, Tags_Others, Date_Origin, Year, Duration, Width, Height, Date_Create, By_User) VALUES ('$getTitle', '$OutId', '$OutHost', '$Img', '$ImgSmall', '$getAuthors', '$getLocation', '$getBrand', '$getTv_Channel', '$Likes', '$getRating', '$getCost', '$getMotion_Type', '$getBroadcast_Type', '$getTempo', '$getTags_SA', '$getTags_Fashion', '$getTags_Arts', '$getTags_Music', '$getTags_Others', '$CreateDate', '$getYear', '$Duration', '$Width', '$Height', '$dateNow', '$UserName')";
		
		if ($this->Query($insertQuery)) {
				
				$_SESSION['user_added'] = ++$UserAdded;
				$NewAddCountQuery = "UPDATE u186876_tvarts.users SET Added = ".$UserAdded." WHERE user_name = '".$UserName."'";
				
				$LogLineQuery = "INSERT INTO u186876_tvarts.contents".$isStack."_log (OutId, Title, Action, User, Changes, Date) VALUES ('$OutId', '$getTitle', 'create', '$UserName', 'Create New', '$dateNow')";
				
				if ($this->Query($NewAddCountQuery) and $this->Query($LogLineQuery)) {
					
					unset ($_GET); //destroy array
					return true;
					}	
		}
	}
		
	public function saveVideo() {
		global $isStack, $getTitle, $getAuthors, $getLocation, $getBrand, $getTv_Channel, $getRating, $getMotion_Type, $getBroadcast_Type, $getTempo, $getTags_SA, $getTags_Fashion, $getTags_Arts, $getTags_Music, $getTags_Others, $getYear, $OutId, $UserName, $Log_Actions, $dateNow;
		
		$insertQuery = 'UPDATE u186876_tvarts.contents'.$isStack.' SET Title = "'.$getTitle.'", Authors = "'.$getAuthors.'", Location = "'.$getLocation.'", Brand = "'.$getBrand.'", Tv_Channel = "'.$getTv_Channel.'", Rating = "'.$getRating.'", Motion_Type = "'.$getMotion_Type.'", Broadcast_Type = "'.$getBroadcast_Type.'", Tempo = "'.$getTempo.'", Tags_SA = "'.strtolower($getTags_SA).'", Tags_Fashion = "'.strtolower($getTags_Fashion).'", Tags_Arts = "'.strtolower($getTags_Arts).'", Tags_Music = "'.strtolower($getTags_Music).'", Tags_Others = "'.strtolower($getTags_Others).'", Year = "'.$getYear.'" WHERE OutId = "'.$OutId.'" ';
	
		if($this->Query($insertQuery)) {
			
			//Detect changes to $Log_Actions textline
			DetectVideoChanges ();
			
			$LogLineQuery = "INSERT INTO u186876_tvarts.contents".$isStack."_log (OutId, Title, Action, User, Changes, Date) VALUES ('$OutId', '$getTitle', 'edit', '$UserName', '$Log_Actions', '$dateNow')";
			
			if ($this->Query($LogLineQuery)){
			
				unset ($_GET); //destroy array
				return true;
				}
			}
	}
	
	
	public function deleteVideo() {
		global $OutId, $Title, $UserName, $isStack, $UserName, $dateNow;
		
		$deleteQuery = "UPDATE u186876_tvarts.contents".$isStack." SET State = 0 WHERE OutId = ".$OutId;
			
		if ($this->Query($deleteQuery)) {
	
				$LogLineQuery = "INSERT INTO u186876_tvarts.contents".$isStack."_log (OutId, Title, Action, User, Changes, Date) VALUES ('$OutId', '$Title', 'delete', '$UserName', 'Delete This', '$dateNow')";
				if ($this->Query($LogLineQuery)) {
					
					unset ($_GET); //destroy array
					return true;
				}
			}
		
	}
	
	
	public function getVideoFromVimeo($Vimeo_Id) {
		global 
		$OutId, 
		$Title, 
		$OutHost,
		$Title,
		$Likes,
		$Desc,
		$CreateDate,
		$Tags,
		$TagList,
		$CastList,
		$Duration,
		$Brand,
		$ImgSmall,
		$Img,
		$Width,
		$Height,
		$MainUserLocation,
		$Year;
		
		$vimeo = new phpVimeo('986bbb02678174efc5d7f107a8ab7d79f7b90626', '0fd2320a50be95e7743922b0f177f29aa8bc33a3');
		$vimeo->setToken('e67a282a494a5325d905347c137be65c','e062ff9270737fc548676f31f49d858840c89f7e');
		
		//ВНИМАНИЕ Если API не найдет Video по ID, то скрипт остановится здесь. Как исправить ХЗ?
		$result = $vimeo->call('vimeo.videos.getInfo', array('video_id' => $Vimeo_Id));
		
		//На случай исправления предыдущего пункта, проверка связи с vimeo
		if($result->stat != 'ok') echo 'Нет подключения к vimeo, статус ('.$result->stat.')<br />';
		
		//В API возможно работать с категориями и тегами видео.
		/*
		Стоит обратить внимание на
		https://developer.vimeo.com/apis/advanced/methods/vimeo.categories.getRelatedTags // Get a list of related tags for a category.
		vimeo.videos.getCollections // Get all the Albums, Channels and Groups a video is a member of.
		*/
		
		//Назначаем переменные
		$OutId = $result->video[0]->id;
		$OutHost = "vimeo"; //указываем флаг vimeo, для будущего расширения хостов с видео
		
		$Title = $result->video[0]->title;
		$Likes = $result->video[0]->number_of_likes;
		$Desc = $result->video[0]->description;
		$CreateDate = $result->video[0]->upload_date; preg_match("/\d{4}/", $CreateDate, $Year); $Year = $Year[0];
	
		$Tags = $result->video[0]->tags->tag;
		foreach ($Tags as $key => $value) {
			$Tag = $Tags[$key]->_content;
			$Tag = preg_replace("/[^\s\w\А-яЁе-]/u", "", $Tag); // фильтруем теги, только латинские и -
			$TagList .= '<span class="tagInsertTags" data-num="'.$key.'">'.$Tag.'</span>, ';
		}
			
		$Cast = $result->video[0]->cast->member; // [display_name]
		if (!empty($Cast[display_name])) //если в массиве есть элемент с display_name, значит нет подмассивов и можно назначить $CastList как одно это значение
		{
			$CastList = $Cast[display_name];
			$UserId = $Cast[id];
		}else // в другом случае перебираем массив классов и собираем display_name'ы в строку
		{
			foreach ($Cast as $key => $value) {
			$CastList .= $Cast[$key]->display_name.', ';
			$UserId = $Cast[0]->id; //назначаем id первого участника
			}
			
		}
	
		//убираем хвосты запятых
		if( preg_match("/, $/", $TagList)) {$TagList = preg_replace("/, $/", "", $TagList);}
		if( preg_match("/, $/", $CastList)) {$CastList = preg_replace("/, $/", "", $CastList);}
		
		$Duration = $result->video[0]->duration; //в секундах
		$Brand = $result->video[0]->owner->display_name;
		$ImgSmall = $result->video[0]->thumbnails->thumbnail[1]->_content;
		$Img = $result->video[0]->thumbnails->thumbnail[2]->_content;
		$Width = $result->video[0]->width;
		$Height = $result->video[0]->height;
	
		//Сбор информаци о первом авторе
		$result_user_info = $vimeo->call('vimeo.people.getInfo', array('user_id' => $UserId));
		
		//определение локации
		$MainUserLocation = $result_user_info->person->location;
	}
	
	
	//Query thats gets Video info by Id with isStack setting, with flag VarState ([SetGlobals])
public function getVideo($VideoId, $isStack, $VarState) {
		
		$this->mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->mysql->connect_errno > 0){
			print ('Unable to connect to database [' . $this->mysql->connect_error . ']');
		} else {$this->mysql->set_charset("utf8");}
		

		$IdQuery = 'SELECT * FROM u186876_tvarts.contents'.$isStack.' WHERE OutId = '.$VideoId;
		
		if(!$result = $this->mysql->query($IdQuery)){die('Error [' . $this->mysql->error . ']');}
		

		//если не нашел видео в базе соотнтветствующей текущему борду, сделать попытку отыскать видео в другой базе
		if ($result->num_rows < 1) {
			if ($isStack == "") {$isStack = "_stack";} else {$isStack = "";}// переключаем настройки флагов
			$IdQuery = "SELECT * FROM u186876_tvarts.contents".$isStack." WHERE OutId = ".$VideoId; //перебиваем запрос
			if(!$result = $this->mysql->query($IdQuery)){die('Error [' . $this->mysql->error . ']');} //переподключаемся
		}	
		
		
		while ($row = $result->fetch_object()) {
			$this->Title = $row->Title;
			$this->OutId = $row->OutId;
			$this->OutHost = $row->OutHost;
			$this->Img = $row->Img;
			$this->Img_Small = $row->Img_Small;
			$this->Authors = $row->Authors;
			$this->Authors_Id = $row->Authors_Id;
			$this->Location = $row->Location;
			$this->Brand = $row->Brand;
			$this->Tv_Channel = $row->Tv_Channel;
			$this->Likes = $row->Likes;
			$this->Rating = $row->Rating;
			$this->Cost = $row->Cost;
			$this->Motion_Type = $row->Motion_Type;
			$this->Broadcast_Type = $row->Broadcast_Type;
			$this->Tempo = $row->Tempo;
			$this->Tags_SA = $row->Tags_SA;
			$this->Tags_Fashion = $row->Tags_Fashion;
			$this->Tags_Arts = $row->Tags_Arts;
			$this->Tags_Music = $row->Tags_Music;
			$this->Tags_Others = $row->Tags_Others;
			$this->Date_Origin = $row->Date_Origin;
			$this->Year = $row->Year;
			$this->Duration = $row->Duration;
			$this->Date_Create = $row->Date_Create;
			$this->By_User = $row->By_User;
			$this->Width = $row->Width;
			$this->Height = $row->Height;
			$this->State = $row->State;
		}
		$result->close();
		
		if ($VarState == "SetGlobals") {
			global $Title; $Title = $this->Title;
			global $OutId; $OutId = $this->OutId;
			global $OutHost; $OutHost = $this->OutHost;
			global $Img; $Img = $this->Img;
			global $Img_Small; $Img_Small = $this->Img_Small;
			global $Authors; $Authors = $this->Authors;
            global $Authors_Id; $Authors_Id = $this->Authors_Id;
			global $Location; $Location = $this->Location;
			global $Brand; $Brand = $this->Brand;
			global $Tv_Channel; $Tv_Channel = $this->Tv_Channel;
			global $Likes; $Likes = $this->Likes;
			global $Rating; $Rating = $this->Rating;
			global $Cost; $Cost = $this->Cost;
			global $Motion_Type; $Motion_Type = $this->Motion_Type;
			global $Broadcast_Type; $Broadcast_Type = $this->Broadcast_Type;
			global $Tempo; $Tempo = $this->Tempo;
			global $Tags_SA; $Tags_SA = $this->Tags_SA;
			global $Tags_Fashion; $Tags_Fashion = $this->Tags_Fashion;
			global $Tags_Arts; $Tags_Arts = $this->Tags_Arts;
			global $Tags_Music; $Tags_Music = $this->Tags_Music;
			global $Tags_Others; $Tags_Others = $this->Tags_Others;
			global $Date_Origin; $Date_Origin = $this->Date_Origin;
			global $Year; $Year = $this->Year;
			global $Duration; $Duration = $this->Duration;
			global $Date_Create; $Date_Create = $this->Date_Create;
			global $By_User; $By_User = $this->By_User;
			global $Width; $Width = $this->Width;
			global $Height; $Height = $this->Height;
			global $State; $State = $this->State;
			}
    }
	

	
 
}


