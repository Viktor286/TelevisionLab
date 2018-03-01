<?

class TvLab
{
    public $debugCookie = '0';


    public function __construct()
    {

        global $TimeStat;
        $TimeStat = microtime(true); // Start Time Statistics

        $this->CSP_Header(''); //'Report-Only' --- empty flag will turn on CPS rules

        require_once('config/general.php');
        require_once('config/private/db.php');
        require_once('controllers/SecureVars.php');
        require_once('controllers/Templater.php');

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
        if (isset($_COOKIE['TvLab'])) {
            session_set_cookie_params(25200, '/', '', 0, 1);// config session cookies: ["lifetime"]=> int(0) ["path"]=> string(1) "/" ["domain"]=> string(0) "" ["secure"]=> bool(false) ["httponly"]=> bool(true)
            session_name('TvLab');
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
            echo '<script type="text/javascript">window.history.pushState("", "", "' . SITE_URL . '"); location.reload(); </script>'; //to main page
            exit();
        }
    }


    public function CSP_Header($flag)
    {
        if ($flag == 'Report-Only') {
            $csp = 'Content-Security-Policy-Report-Only: ';
        } else {
            $csp = 'Content-Security-Policy: ';
        }

        $csp .=
            "default-src 'self' https://*.vimeo.com; "
            . "script-src 'self' https://mc.yandex.ru https://*.vimeo.com 'unsafe-inline' 'unsafe-eval'; "
            . "img-src i.vimeocdn.com 'self' data: ;"
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
            echo "Sess_Token: " . $_SESSION['token'] . "<br />&nbsp;<br />";


            echo "<div>S_SESSION:<pre> ";
            print_r($_SESSION);
            echo "</pre></div>";

            echo "<div>Sess_cookie_params:<pre> ";
            var_dump(session_get_cookie_params());
            echo "</pre></div>";

            echo '<div style="float:none;">S_COOKIE:<pre>';
            print_r($_COOKIE);
            echo "</pre></div>";

            echo '<div class="clear"></div>';

            echo '</div>';
        }
    }


}
