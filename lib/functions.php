<?php

function compAuthors($Authors, $Authors_Aliases) {
    if ( !empty($Authors_Aliases) ) {
        //assemble array of Author => Alias
        $AA_Arr = array_combine (explode(',', $Authors), explode(',', $Authors_Aliases));

        unset($AuthorLine);
        foreach( $AA_Arr as $Author => $Alias) {

            if ($Alias == "Na" || $Alias == "na") {
                $AuthorLine .= $Author.', ';
            } else {
                $AuthorLine .= '<a href="artist/'.$Alias.'">'.$Author.'</a>, ';
            }
        }

        echo( chop($AuthorLine, ', \n') );

    } else {
        //If there is no $Authors_Aliases
        return $Authors;
    }
}

function compMotionType($Motion_Type) {

    foreach( explode(',',$Motion_Type) as $val){
        switch ($val) {
            case "0": $mts .= '<a href="/?set=c1d0s0a0t0v0"><img class="min-icon m_compositing" src="img/min-compositing.png" /></a>'; break;
            case "1": $mts .= '<a href="/?set=c0d1s0a0t0v0"><img class="min-icon m_graphics" src="img/min-graphics.png" /></a>'; break;
            case "2": $mts .= '<a href="/?set=c0d0s1a0t0v0"><img class="min-icon m_simulation" src="img/min-simulation.png" /></a>'; break;
            case "3": $mts .= '<a href="/?set=c0d0s0a1t0v0"><img class="min-icon m_animation" src="img/min-animation.png" /></a>'; break;
            case "4": $mts .= '<a href="/?set=c0d0s0a0t1v0"><img class="min-icon m_rd_stop_motion" src="img/min-rd_stop_motion.png" /></a>'; break;
            case "5": $mts .= '<a href="/?set=c0d0s0a0t0v1"><img class="min-icon m_rd_video" src="img/min-rd_video.png" /></a>'; break;
        }
    }

    return $mts;
}

function compBroadcastType($Broadcast_Type) {

    switch ($Broadcast_Type) {
        case "0": $bct .= 'Identity'; break;
        case "1": $bct .= 'Advertising'; break;
        case "2": $bct .= 'Presentation and PR'; break;
        case "3": $bct .= 'Information and Analytics'; break;
        case "4": $bct .= 'Entertainment and show'; break;
        case "5": $bct .= 'Artistic'; break;
        case "6": $bct .= 'Educational'; break;
    }

    return $bct;
}


function compLocationYear($Location, $Year) {
    if ( !empty($Location)) {
        return '<a href="/?tags='.str_replace(",","", $Location).'">'.$Location.'</a>, <a href="/?tags='.$Year.'">'.$Year.'</a>';
    } else {
        return '<div class="min_cap">Year: </div><a href="/?tags='.$Year.'">'.$Year.'</a>';
    }
}

function compBrand($Authors, $Brand) {
    if ( !strstr( $Authors, $Brand ) and !empty( $Brand ) ) {
        return '<div class="Brand"><div class="min_cap">Brand: </div><a href="/?tags='.$Brand.'">'.$Brand.'</a></div>';
    }
}

function compTvChannel($Tv_Channel) {
    if ( !empty ($Tv_Channel) ) { return '<div class="Tv_Channel"><div class="min_cap">Tv channel: </div><a href="/?tags='.$Tv_Channel.'">'.$Tv_Channel.'</a></div>'; }
}

function compTags($Tags_SA, $Tags_Fashion, $Tags_Arts, $Tags_Music, $Tags_Others) {

    $TagsArr = array_merge (
        explode(", " , $Tags_SA),
        explode(", " , $Tags_Fashion),
        explode(", " , $Tags_Arts),
        explode(", " , $Tags_Music),
        explode(", " , $Tags_Others)
    );

    $TagsArr = array_filter($TagsArr);

    $TagLine = "";
    foreach ($TagsArr as $Tag) {
        $TagLine .= '<a class="tag" href="/?tags='.$Tag.'">'.$Tag.'</a> ';
    }

    return $TagLine;
}

function compDate($PubDate, $Format){
    $PubDate = strtotime($PubDate);
    return date($Format, $PubDate);
}



function InitSessVars () {
    global $UserName, $UserEmail, $UserRole, $UserStatus, $UserActivity, $UserAdded, $UserBoard;
    $UserName = $_SESSION['user_name'];
    $UserEmail = $_SESSION['user_email'];
    $UserRole = $_SESSION['user_role'];
    $UserStatus = $_SESSION['user_login_status'];
    $UserActivity = $_SESSION['user_activity'];
    $UserAdded = $_SESSION['user_added'];
    $UserBoard = $_SESSION['user_board'];
}


//Проверка роли авторизированного пользователя из сессии
function RoleState() {
    if ($_SESSION['user_login_status'] == 1) {return $_SESSION["user_role"];} else {return 5;}
}


function AdjustH1InfoOutput($getSet, $Mode, $tags) {

    //Prepare chunks
    $SetChunk = "<span class='TitlePrepend'>Production Type:</span>";

    $TagChunk = "<span class='TitlePrepend'>Keyword:</span>";


    $isSetActive = 0;
    if(preg_match("/c1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-compositing.png" /> Compositing FX</span> + '; $isSetActive = 1;}
    if(preg_match("/d1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-graphics.png" /> 3d Graphics</span> + '; $isSetActive = 1;}
    if(preg_match("/s1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-simulation.png" /> Simulation</span> + '; $isSetActive = 1;}
    if(preg_match("/a1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-animation.png" /> Animation</span> + '; $isSetActive = 1;}
    if(preg_match("/t1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-rd_stop_motion.png" /> Stop Motion</span> + '; $isSetActive = 1;}
    if(preg_match("/v1/", $getSet)) {$SetTitleLine .= ' <span class="type-tag"><img src="img/min-rd_video.png"  /></span> Video'; $isSetActive = 1;}

    $SetTitleLine = preg_replace("/ \+ $/", "", $SetTitleLine);

    if (!isset($SetTitleLine)) {$SetTitleLine = " All";}


    if ($Mode == "on") {$OnlyWrap = "<span class='TitleOnly'> only (</span>"; $OnlyWrapClose = "<span class='TitleOnly'> )</span>";}

    if ($tags != "") {

        //Repack each tag separatly
        $close_button = '<span class="x-close">⨯</span>';

        $tags = str_replace(" ", $close_button.'</span> + <span class="tag">', $tags);
        $tags = '<span class="tag">'.$tags.$close_button.'</span>';

        $tagLine = $TagChunk.' <span class="Tags">'.$tags.'</span>';
    }

    if ($isSetActive == 0) {unset ($SetChunk,$OnlyWrap, $OnlyWrapClose);}


    if ($isSetActive == 1 or $tags != "") {
        if ($isSetActive == 1 and $tags != "")
        {$tagIndent = "<span class='TitlePrepend'> and </span>";}

        $OutputLine = '<h1 class="setInfo">' . $tagLine . $tagIndent . $SetChunk . $OnlyWrap . $SetTitleLine . $OnlyWrapClose . "</h1>";
    }

    //$x = SetTitle($qSet, $Mode); if ($x != "") {echo "<h1>".$x."</h1>";}

    echo $OutputLine;
}

function insertHead ($LayoutSet, $Template) {
    $PageLayout = file_get_contents($Template);

    foreach ($LayoutSet as $Param => $Value) {
        //Simple replace placeholder
        if ( !is_array($Value) ) {

            $PageLayout = str_replace("[*".$Param."*]", $Value, $PageLayout);
        //Inject prepared blocks and semi-prepared blocks
        }else{

            if ($Param == "Prepend" ) {
                foreach ($Value as $SubValue) {
                    $PageLayout = str_replace("[*Prepend*]", $SubValue, $PageLayout);
                }
            }

            if ($Param == "css" ) {
                foreach ($Value as $SubValue) {

                    if ($SubValue == "google_fonts") {
                        $css[] = '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:600italic,700,600,400,300" />';
                    } else {
                        $css[] = '<link rel="stylesheet" type="text/css" href="/css/'.$SubValue.'.css" />';
                    }
                }

                $css = implode("\n    ", $css);
                $PageLayout = str_replace("[*css*]", $css, $PageLayout);
            }

            if ($Param == "js" ) {
                foreach ($Value as $SubValue) {
                    $js[] = '<script type="text/javascript" src="/js/'.$SubValue.'.js"></script>';
                }
                $js = implode("\n    ", $js);
                $PageLayout = str_replace("[*js*]", $js, $PageLayout);
            }

            if ($Param == "Append") {
                foreach ($Value as $SubValue) {
                    $PageLayout = str_replace("[*Append*]", $SubValue, $PageLayout);
                }
            }
        }
    }
    $PageLayout = str_replace("\n    \r\n\r", "", $PageLayout);
    $PageLayout = str_replace("\n    \r", "", $PageLayout);

    echo $PageLayout;

}

function insertFooter ($Template) {
    $PageLayout = file_get_contents($Template);
    echo $PageLayout;

    global $TimeStat;
    echo "\n<!-- Generated: ".(microtime(true) - $TimeStat)."s -->";
}


//------------------- Функция грубой зачистки для входных данных

function Triming( $value ) {

    $value = preg_replace("/[^\s\w\(\)&А-яЁе.,=\+\$№–!%:?-]/u", "", $value);//оставляем только слова, цифры, &+$№!%:?()=-., (главное избавляемся от всех кавычек, тэгов, слэшей, фигурных скобок)
    $value = trim( preg_replace("/  +/", " ", $value) ); //убираем двойные и более пробелы, в т.ч. по краям
    return $value;
}

function SecureVars( $DataArr ) {

    if ( !is_array($DataArr) ) { $DataArr = array($DataArr); } // Если переменная не массив, назначаем её таковой

    $OutData = array();
    foreach ( $DataArr as $Key=>$Value ) { // каждый объект массива прорабатываем отдельно в цикле

        if ( !empty($Value) ) {

            if ( !is_array($Value) ) { $OutData[$Key] = Triming( $Value ); } // если значение строка, добавляем её в массив вывода, обработав функцией Triming

            else {

                $SubArr = array();
                foreach ( $Value as $SubKey=>$SubValue ) {

                    if ( !is_array($SubValue) ) { $SubArr[$SubKey] = Triming( $SubValue ); }

                }

                $OutData[$Key] = $SubArr; // добавляем обработанный суб-массив в массив вывода
            }
        }
    };

    return $OutData;
}



function GET_Setup_Video(){
    global $getTitle; if (isset ($_GET['title'])) {$getTitle = GetSecureData ($_GET['title']);}
    global $getAuthors; if (isset ($_GET['authors'])) {$getAuthors = GetSecureData ($_GET['authors']);}
    global $getLocation; if (isset ($_GET['location'])) {$getLocation = GetSecureData ($_GET['location']);}
    global $getYear; if (isset ($_GET['year'])) {$getYear = GetSecureData ($_GET['year']);}
    global $getBrand; if (isset ($_GET['brand'])) {$getBrand = GetSecureData ($_GET['brand']);}
    global $getTv_Channel; if (isset ($_GET['tv'])) {$getTv_Channel = GetSecureData ($_GET['tv']);}
    global $getMotion_Type; if (isset ($_GET['motion'])) {$getMotion_Type = GetSecureData_Arr ($_GET['motion']);}
    global $getBroadcast_Type; if (isset ($_GET['broadcast'])) {$getBroadcast_Type = GetSecureData_Arr ($_GET['broadcast']);}
    global $getTempo; if (isset ($_GET['tempo'])) {$getTempo = GetSecureData ($_GET['tempo']);}
    global $getRating; if (isset ($_GET['rating'])) {$getRating = GetSecureData ($_GET['rating']);}
    global $getCost; if (isset ($_GET['cost'])) {$getCost = GetSecureData ($_GET['cost']);}
    global $getTags_SA; if (isset ($_GET['sa'])) {$getTags_SA = GetSecureData ($_GET['sa']);}
    global $getTags_Fashion; if (isset ($_GET['fashion'])) {$getTags_Fashion = GetSecureData ($_GET['fashion']);}
    global $getTags_Arts; if (isset ($_GET['arts'])) {$getTags_Arts = GetSecureData ($_GET['arts']);}
    global $getTags_Music; if (isset ($_GET['music'])) {$getTags_Music = GetSecureData ($_GET['music']);}
    global $getTags_Others; if (isset ($_GET['tags'])) {$getTags_Others = GetSecureData ($_GET['tags']);}
    global $getBy_User; if (isset ($_GET['by_user'])) {$getBy_User = GetSecureData ($_GET['by_user']);}
    global $session_User; if (isset ($_SESSION['user_name'])) {$session_User = GetSecureData ($_SESSION['user_name']);}
    global $getPswd; if (isset ($_GET['pswd'])) {$getPswd = GetSecureData ($_GET['pswd']);}
    global $getVideo; if (isset ($_GET['video'])) {preg_match('/(\d{4,15})/', $_GET['video'], $getVideo); $getVideo = $getVideo[0];}
    global $getToken; if (isset ($_GET['_token'])) {$getToken = GetSecureData ($_GET['_token']);} else { $getToken = "null"; }
}

function POST_Setup_Video(){
    global $getTitle; if (isset ($_POST['title'])) {$getTitle = GetSecureData ($_POST['title']);}
    global $getAuthors; if (isset ($_POST['authors'])) {$getAuthors = GetSecureData ($_POST['authors']);}
    global $getLocation; if (isset ($_POST['location'])) {$getLocation = GetSecureData ($_POST['location']);}
    global $getYear; if (isset ($_POST['year'])) {$getYear = GetSecureData ($_POST['year']);}
    global $getBrand; if (isset ($_POST['brand'])) {$getBrand = GetSecureData ($_POST['brand']);}
    global $getTv_Channel; if (isset ($_POST['tv'])) {$getTv_Channel = GetSecureData ($_POST['tv']);}
    global $getMotion_Type; if (isset ($_POST['motion'])) {$getMotion_Type = GetSecureData_Arr ($_POST['motion']);}
    global $getBroadcast_Type; if (isset ($_POST['broadcast'])) {$getBroadcast_Type = GetSecureData_Arr ($_POST['broadcast']);}
    global $getTempo; if (isset ($_POST['tempo'])) {$getTempo = GetSecureData ($_POST['tempo']);}
    global $getRating; if (isset ($_POST['rating'])) {$getRating = GetSecureData ($_POST['rating']);}
    global $getCost; if (isset ($_POST['cost'])) {$getCost = GetSecureData ($_POST['cost']);}
    global $getTags_SA; if (isset ($_POST['sa'])) {$getTags_SA = GetSecureData ($_POST['sa']);}
    global $getTags_Fashion; if (isset ($_POST['fashion'])) {$getTags_Fashion = GetSecureData ($_POST['fashion']);}
    global $getTags_Arts; if (isset ($_POST['arts'])) {$getTags_Arts = GetSecureData ($_POST['arts']);}
    global $getTags_Music; if (isset ($_POST['music'])) {$getTags_Music = GetSecureData ($_POST['music']);}
    global $getTags_Others; if (isset ($_POST['tags'])) {$getTags_Others = GetSecureData ($_POST['tags']);}
    global $getBy_User; if (isset ($_POST['by_user'])) {$getBy_User = GetSecureData ($_POST['by_user']);}
    global $session_User; if (isset ($_SESSION['user_name'])) {$session_User = GetSecureData ($_SESSION['user_name']);}
    global $getPswd; if (isset ($_POST['pswd'])) {$getPswd = GetSecureData ($_POST['pswd']);}

    global $getVideo; if (isset ($_POST['video'])) {preg_match('/(\d{4,15})/', $_POST['video'], $getVideo); $getVideo = $getVideo[0];}
    global $getToken; if (isset ($_POST['_token'])) {$getToken = GetSecureData ($_POST['_token']);} else { $getToken = "null"; }
}


function NewDetect($Old,$New) {
    if ($Old != $New) {return $New;}
};

function DetectVideoChanges () {
    global $Log_Actions; $Log_Actions = "";

    global $Title, $getTitle; if (NewDetect($Title,$getTitle)) {$Log_Actions .= "Title = ".$getTitle."; ";}
    global $Authors, $getAuthors; if (NewDetect($Authors,$getAuthors)) {$Log_Actions .= "Authors = ".$getAuthors."; ";}
    global $Location, $getLocation; if (NewDetect($Location,$getLocation)) {$Log_Actions .= "Location = ".$getLocation."; ";}
    global $Brand, $getBrand; if (NewDetect($Brand,$getBrand)) {$Log_Actions .= "Brand = ".$getBrand."; ";}
    global $Tv_Channel, $getTv_Channel; if (NewDetect($Tv_Channel,$getTv_Channel)) {$Log_Actions .= "Tv_Channel = ".$getTv_Channel."; ";}
    global $Rating, $getRating; if (NewDetect($Rating,$getRating)) {$Log_Actions .= "Rating = ".$getRating."; ";}
    global $Motion_Type, $getMotion_Type; if (NewDetect($Motion_Type,$getMotion_Type)) {$Log_Actions .= "Motion_Type = ".$getMotion_Type."; ";}
    global $Broadcast_Type, $getBroadcast_Type; if (NewDetect($Broadcast_Type,$getBroadcast_Type)) {$Log_Actions .= "Broadcast_Type = ".$getBroadcast_Type."; ";}
    global $Tags_SA, $getTags_SA; if (NewDetect($Tags_SA,$getTags_SA)) {$Log_Actions .= "Tags_SA = ".$getTags_SA."; ";}
    global $Tempo, $getTempo; if (NewDetect($Tempo,$getTempo)) {$Log_Actions .= "Tempo = ".$getTempo."; ";}
    global $Tags_Fashion, $getTags_Fashion; if (NewDetect($Tags_Fashion,$getTags_Fashion)) {$Log_Actions .= "Tags_Fashion = ".$getTags_Fashion."; ";}
    global $Tags_Arts, $getTags_Arts; if (NewDetect($Tags_Arts,$getTags_Arts)) {$Log_Actions .= "Tags_Arts = ".$getTags_Arts."; ";}
    global $Tags_Music, $getTags_Music; if (NewDetect($Tags_Music,$getTags_Music)) {$Log_Actions .= "Tags_Music = ".$getTags_Music."; ";}
    global $Tags_Others, $getTags_Others; if (NewDetect($Tags_Others,$getTags_Others)) {$Log_Actions .= "Tags_Others = ".$getTags_Others."; ";}
    global $Year, $getYear; if (NewDetect($Year,$getYear)) {$Log_Actions .= "Year = ".$getYear."; ";}

}


function ScreenFadeMsg($objectTitle, $msgTxt, $TargetUrl) {
    echo '
	<div class="ScreenFade">
		<div class="SuccessMsg">
		<p><img src="img/tv_a.png"><p /><br /> 
		<p style="font-size:18px;">'.$objectTitle.'<p /><br />
		<p>'.$msgTxt.'<p />
		</div>
	</div>';

    echo '<script type="text/javascript">setTimeout(function () {window.location.href = "'.$TargetUrl.'";}, 2000);</script>';

}



//запрос тэгов из u186876_tvarts.tags
function ShowRating ($Tags_Name, $Limit, $Tags) {

    $Query = "SELECT ".$Tags_Name.", COUNT( ".$Tags_Name." ) FROM u186876_tvarts.tags GROUP BY 1 ORDER BY COUNT( ".$Tags_Name." ) DESC LIMIT 0 , 50";
    $result = mysql_query ($Query);
    while ( $arr[] = mysql_fetch_array($result) );

    if ($Limit == 0) { $Limit = mysql_num_rows ($result);} //если лимит не указан выводим все строки

    //Расчет макс и мин тэгов
    $MaxTags = 1; $MinTags = 1;
    for ($x=0; $x<$Limit; $x++) {
        if (strlen($arr[$x][0]) > 1) //обходим возможные пустые строки
        {
            if ($MaxTags < $arr[$x][1]) {$MaxTags = $arr[$x][1];}
            if ($MinTags > $arr[$x][1]) {$MinTags = $arr[$x][1];}
        }
    }

    $min_size = 10;
    $max_size = 16;

    unset($Output);

    $TagsArr = explode(" ", $Tags);

    //Вывод блока
    for ($x=0; $x<$Limit; $x++) {
        if (strlen($arr[$x][0]) > 1) //обходим возможные пустые строки
        {
            $Size = ($arr[$x][1] - $MinTags) / ($MaxTags - $MinTags) * ($max_size - $min_size) + $min_size; // Супер формула на соотношение величин размера шрифта, и тэгов

            if ( in_array($arr[$x][0], $TagsArr) ) {
                $here = ' class="here"';
                $Output .= '
			<li><span style="font-size:'.round ($Size,1).'px"'.$here.'>'.$arr[$x][0].'</span></li>';

            } else {
                $Output .= '
			<li><a style="font-size:'.round ($Size,1).'px" href="javascript:void(0);" title="'.$arr[$x][0].' ('.$arr[$x][1].')" onclick="LPoTC('."'".$arr[$x][0]."'".');return true">'.$arr[$x][0].'</a></li>';

            }

        }
    }
    $Output = trim($Output);

    $Output = preg_replace("/,<\/span>$/", "</span>", $Output);
    echo $Output;
}





//Функция грубой зачистки остаются только буквы, цифры, пробелы, точки, запятые, тире, скобки
//почему-то пропускает символ <
function GetSecureData ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её таковой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            $GetData[$x] = preg_replace("/[^\s\w\(\)&А-яЁе.,=-]/u", "", $GetData[$x]);//оставляем только буквы, цифры, пробелы, точки, запятые, тире
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x])); //убираем двойные и более пробелы, в т.ч. по краям
            $GetData[$x] = substr($GetData[$x], 0, 350);//обрезаем строку до 350 символов
            $OutData[] = $GetData[$x]; // собираем новый массив $OutData

        };
        return implode($OutData); // сливаем массив
    };
};


//Функция грубой зачистки для массива остаются только буквы, цифры, пробелы, точки, запятые, тире, скобки
function GetSecureData_Arr ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её таковой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            $GetData[$x] = preg_replace("/[^\s\w\(\)&А-яЁе.,-]/u", "", $GetData[$x]);//оставляем только буквы, цифры, пробелы, точки, запятые, тире
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x])); //убираем двойные и более пробелы, в т.ч. по краям
            $GetData[$x] = substr($GetData[$x], 0, 350);//обрезаем строку до 350 символов
            $OutData[] = $GetData[$x]; // собираем новый массив $OutData

        };

        return ($OutData);
    };
};




//Функция грубой зачистки остаются только буквы, цифры, пробелы, .,-<>=!"
function GetSecureData_Links ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её такавой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            $GetData[$x] = preg_replace("/[^\s\w.,_:\/<&?;>=!\"\-]/", "", $GetData[$x]);//оставляем только буквы, цифры, пробелы, точки, запятые, тире
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x])); //убираем двойные и более пробелы, в т.ч. по краям
            $GetData[$x] = substr($GetData[$x], 0, 500);//обрезаем строку до 500 символов
            $OutData[] = $GetData[$x]; // собираем новый массив $OutData

        };
        return implode($OutData);
    };
};




//Функция грубой зачистки остаются только буквы, цифры, пробелы, ,_-
function GetSecureData_Tags ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её таковой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            $GetData[$x] = preg_replace("/[^\s\wА-яЁе,_-]/", "", $GetData[$x]);//оставляем только буквы, цифры, пробелы, точки, запятые, тире
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x])); //убираем двойные и более пробелы, в т.ч. по краям
            $GetData[$x] = substr($GetData[$x], 0, 500);//обрезаем строку до 500 символов
            $OutData[] = $GetData[$x]; // собираем новый массив $OutData

        };
        return implode($OutData);
    };
};




//Функция грубой зачистки, остаются только цифры
function GetSecureData_Digits ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её таковой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            if( preg_match("/[^\d]/", $GetData[$x]))
                //если встречаются НЕ ЦИФРЫ, значит произвести замену
            {
                $GetData[$x] = preg_replace("/[^\d]/", "", $GetData[$x]); // Удаление всех символов кроме цифр
                $GetData[$x] = substr($GetData[$x], 0, 3); //обрезаем строку до 2 символов
                $OutData[] = $GetData[$x];
            }

            else $OutData[] = substr($GetData[$x], 0, 3); //обрезаем строку до 2 символов

        };
        return implode($OutData);
    };
};


/*
Замена всех символов кроме пробела, букв, цифр, нижн. подч,  точки и запятой.
preg_replace("/[^\s\w,.]/", "#", $input_lines);

Замена всех символов кроме цифр
preg_replace("/[^\d]/", "#", $input_lines);

• Удаляете, все теги и экранируйте (удаляете stripslashes()) кавычки с помощью addslashes(strip_tags($_POST[‘text’]));
mysql_real_escape_string() не экранирует символы % и _
*/


//функция проверки выбранного селекта для переноса его состояния при перезагрузке страницы
function isChecked ($get_data,$value) {
    if (isset($get_data)) {echo (in_array($value, $get_data)? 'checked="checked"':'');};
};

function isSelected ($get_data,$value) {
    if (!is_array($get_data)) {$get_data = array($get_data);} // Если переменная не массив, назначаем её таковой
    if (isset($get_data)) {echo (in_array($value, $get_data)? 'selected="selected"':'');};
};

function matchChecked ($mQ,$value) {
    if (isset($mQ)) {echo (preg_match($value, $mQ) ? 'checked="checked"':'');};
};

function matchSelected ($mQ,$value) {
    if (isset($mQ)) {echo (preg_match($value, $mQ) ? 'selected="selected"':'');};
};




//функция проверки заголовков
function Check_Title ($get_data){
    if (preg_match ("/[^\s\w\(\)&А-яЁе.,-]/u", $get_data) or empty($get_data) or iconv_strlen($get_data, 'UTF-8') < 3) {return false; } else {return true;};
};





//улучшенная функция проверки кода вставки
function Check_Valid_Id($get_data){

    if (preg_match('/(\d{4,15})/', $get_data)) {return true;}

    //if ( strpos('/(\d{4,15})/', $get_data) ) {return true;}
};


//функция проверки кода вставки
function Check_embeded ($get_data){
    if (
        empty($get_data) ||
        iconv_strlen($get_data, 'UTF-8') < 15)
    {return false;} else {
        if (preg_match ("/<iframe.*player\.vimeo\.com\/video\/(\d{4,15})/", $get_data)) {return true;}
        if (preg_match ("/vimeo\.com\/(\d{4,15})/", $get_data)) {return true;}
    };
};


//функция проверки урлов
function Check_URL ($get_data){
    if (!filter_var($get_data, FILTER_VALIDATE_URL) or empty($get_data) or iconv_strlen($get_data, 'UTF-8') < 3) {return false; } else {return true;};
};



//функция проверки цифровых данных
function Check_Digits ($get_data){
    if (!is_array($get_data)) {$get_data = array($get_data);} // Если переменная не массив, назначаем её таковой
    $Amount = count ($get_data); //пересчет объектов в массиве
    $counter = 0;
    for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

        if (preg_match ("/[^\d]/", $get_data[$x]) or iconv_strlen($get_data[$x], 'UTF-8') > 15) {} else {$counter++;};

    };

    if ($Amount == $counter) {return true;} else {return false;}

};


?>