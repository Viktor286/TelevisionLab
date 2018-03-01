<?php

function GET_Setup_Video()
{
    global $getTitle;
    if (isset ($_GET['title'])) {
        $getTitle = GetSecureData($_GET['title']);
    }
    global $getAuthors;
    if (isset ($_GET['authors'])) {
        $getAuthors = GetSecureData($_GET['authors']);
    }
    global $getLocation;
    if (isset ($_GET['location'])) {
        $getLocation = GetSecureData($_GET['location']);
    }
    global $getYear;
    if (isset ($_GET['year'])) {
        $getYear = GetSecureData($_GET['year']);
    }
    global $getBrand;
    if (isset ($_GET['brand'])) {
        $getBrand = GetSecureData($_GET['brand']);
    }
    global $getTv_Channel;
    if (isset ($_GET['tv'])) {
        $getTv_Channel = GetSecureData($_GET['tv']);
    }
    global $getMotion_Type;
    if (isset ($_GET['motion'])) {
        $getMotion_Type = GetSecureData_Arr($_GET['motion']);
    }
    global $getBroadcast_Type;
    if (isset ($_GET['broadcast'])) {
        $getBroadcast_Type = GetSecureData_Arr($_GET['broadcast']);
    }
    global $getTempo;
    if (isset ($_GET['tempo'])) {
        $getTempo = GetSecureData($_GET['tempo']);
    }
    global $getRating;
    if (isset ($_GET['rating'])) {
        $getRating = GetSecureData($_GET['rating']);
    }
    global $getCost;
    if (isset ($_GET['cost'])) {
        $getCost = GetSecureData($_GET['cost']);
    }
    global $getTags_SA;
    if (isset ($_GET['sa'])) {
        $getTags_SA = GetSecureData($_GET['sa']);
    }
    global $getTags_Fashion;
    if (isset ($_GET['fashion'])) {
        $getTags_Fashion = GetSecureData($_GET['fashion']);
    }
    global $getTags_Arts;
    if (isset ($_GET['arts'])) {
        $getTags_Arts = GetSecureData($_GET['arts']);
    }
    global $getTags_Music;
    if (isset ($_GET['music'])) {
        $getTags_Music = GetSecureData($_GET['music']);
    }
    global $getTags_Others;
    if (isset ($_GET['tags'])) {
        $getTags_Others = GetSecureData($_GET['tags']);
    }
    global $getBy_User;
    if (isset ($_GET['by_user'])) {
        $getBy_User = GetSecureData($_GET['by_user']);
    }
    global $session_User;
    if (isset ($_SESSION['user_name'])) {
        $session_User = GetSecureData($_SESSION['user_name']);
    }
    global $getPswd;
    if (isset ($_GET['pswd'])) {
        $getPswd = GetSecureData($_GET['pswd']);
    }
    global $getVideo;
    if (isset ($_GET['video'])) {
        preg_match('/(\d{4,15})/', $_GET['video'], $getVideo);
        $getVideo = $getVideo[0];
    }
    global $getToken;
    if (isset ($_GET['_token'])) {
        $getToken = GetSecureData($_GET['_token']);
    } else {
        $getToken = "null";
    }
}

function POST_Setup_Video()
{
    global $getTitle;
    if (isset ($_POST['title'])) {
        $getTitle = GetSecureData($_POST['title']);
    }
    global $getAuthors;
    if (isset ($_POST['authors'])) {
        $getAuthors = GetSecureData($_POST['authors']);
    }
    global $getLocation;
    if (isset ($_POST['location'])) {
        $getLocation = GetSecureData($_POST['location']);
    }
    global $getYear;
    if (isset ($_POST['year'])) {
        $getYear = GetSecureData($_POST['year']);
    }
    global $getBrand;
    if (isset ($_POST['brand'])) {
        $getBrand = GetSecureData($_POST['brand']);
    }
    global $getTv_Channel;
    if (isset ($_POST['tv'])) {
        $getTv_Channel = GetSecureData($_POST['tv']);
    }
    global $getMotion_Type;
    if (isset ($_POST['motion'])) {
        $getMotion_Type = GetSecureData_Arr($_POST['motion']);
    }
    global $getBroadcast_Type;
    if (isset ($_POST['broadcast'])) {
        $getBroadcast_Type = GetSecureData_Arr($_POST['broadcast']);
    }
    global $getTempo;
    if (isset ($_POST['tempo'])) {
        $getTempo = GetSecureData($_POST['tempo']);
    }
    global $getRating;
    if (isset ($_POST['rating'])) {
        $getRating = GetSecureData($_POST['rating']);
    }
    global $getCost;
    if (isset ($_POST['cost'])) {
        $getCost = GetSecureData($_POST['cost']);
    }
    global $getTags_SA;
    if (isset ($_POST['sa'])) {
        $getTags_SA = GetSecureData($_POST['sa']);
    }
    global $getTags_Fashion;
    if (isset ($_POST['fashion'])) {
        $getTags_Fashion = GetSecureData($_POST['fashion']);
    }
    global $getTags_Arts;
    if (isset ($_POST['arts'])) {
        $getTags_Arts = GetSecureData($_POST['arts']);
    }
    global $getTags_Music;
    if (isset ($_POST['music'])) {
        $getTags_Music = GetSecureData($_POST['music']);
    }
    global $getTags_Others;
    if (isset ($_POST['tags'])) {
        $getTags_Others = GetSecureData($_POST['tags']);
    }
    global $getBy_User;
    if (isset ($_POST['by_user'])) {
        $getBy_User = GetSecureData($_POST['by_user']);
    }
    global $session_User;
    if (isset ($_SESSION['user_name'])) {
        $session_User = GetSecureData($_SESSION['user_name']);
    }
    global $getPswd;
    if (isset ($_POST['pswd'])) {
        $getPswd = GetSecureData($_POST['pswd']);
    }

    global $getVideo;
    if (isset ($_POST['video'])) {
        preg_match('/(\d{4,15})/', $_POST['video'], $getVideo);
        $getVideo = $getVideo[0];
    }
    global $getToken;
    if (isset ($_POST['_token'])) {
        $getToken = GetSecureData($_POST['_token']);
    } else {
        $getToken = "null";
    }
}


function Check_Title($get_data)
{
    if (preg_match("/[^\s\w\(\)&А-яЁе.,-]/u", $get_data) or empty($get_data) or iconv_strlen($get_data, 'UTF-8') < 3) {
        return false;
    } else {
        return true;
    };
}

;


function Check_Valid_Id($get_data)
{
    if (preg_match('/(\d{4,15})/', $get_data)) {
        return true;
    }
    //if ( strpos('/(\d{4,15})/', $get_data) ) {return true;}
}

;


function Check_embeded($get_data)
{
    if (empty($get_data) || iconv_strlen($get_data, 'UTF-8') < 15) {
        return false;
    } else {
        if (preg_match("/<iframe.*player\.vimeo\.com\/video\/(\d{4,15})/", $get_data)) {
            return true;
        }
        if (preg_match("/vimeo\.com\/(\d{4,15})/", $get_data)) {
            return true;
        }
    };
}

;


function Check_URL($get_data)
{
    if (!filter_var($get_data, FILTER_VALIDATE_URL) or empty($get_data) or iconv_strlen($get_data, 'UTF-8') < 3) {
        return false;
    } else {
        return true;
    };
}

;


function Check_Digits($get_data)
{
    if (!is_array($get_data)) {
        $get_data = array($get_data);
    }
    $Amount = count($get_data);
    $counter = 0;
    for ($x = 0; $x < $Amount; $x++) {
        if (preg_match("/[^\d]/", $get_data[$x]) or iconv_strlen($get_data[$x], 'UTF-8') > 15) {
        } else {
            $counter++;
        };
    };
    if ($Amount == $counter) {
        return true;
    } else {
        return false;
    }
}

;