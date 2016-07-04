<?php

require_once('../libs/AutoLoader.php');

class Core
{
    protected static $startTime;
    protected static $endTime;
    private $data;

    public function convertToTime($time)
    {
        return date('h:i:s d-M-Y', $time->sec);
    }

    public function getDateof($timeUnit)
    {
        $now = new \DateTime('now');
        $hour = $now->format('h');
        $day = $now->format('d');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($timeUnit == 'h') {
            return (int)$hour;
        } elseif ($timeUnit == 'd') {
            return (int)$day;
        } elseif ($timeUnit == 'm') {
            return (int)$month;
        } elseif ($timeUnit == 'y') {
            return (int)$year;
        } else {
            return 0;
        }

    }

    public function setStartTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$startTime = $time[1] + $time[0];
    }

    public function setEndTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$endTime = $time[1] + $time[0];
    }

    public function getPageLoadTime()
    {
        if (isset(self::$startTime) && isset(self::$endTime)) {
            $loadTime = round(self::$endTime - self::$startTime, 6) * 1000;
        } else {
            $loadTime = null;
        }

        return $loadTime;
    }

    public function filterGETRequest($variable)
    {
        if (isset($_GET[$variable])) {
            return (string)$_GET[$variable];
        } else {
            return null;
        }

    }

    public function filterPOSTRequest($variable)
    {
        if (isset($_POST[$variable])) {
            return (string)$_POST[$variable];
        } else {
            return null;
        }

    }

    public function processLogout()
    {
        if (isset($_GET['logout'])) {
            // Unset all session values
            $_SESSION = array();

            // get session parameters
            $params = session_get_cookie_params();

            // Delete the actual cookie.
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

            // Destroy session
            session_destroy();
            header("Location: ../index.php");
            exit();
        }

    }

    public function sec_session_start()
    {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = false;

        // This stops JavaScript being able to access the session id.
        $httponly = true;

        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

        // Sets the session name to the one set above.
        session_name($session_name);

        session_start();            // Start the PHP session
        session_regenerate_id();    // regenerated the session, delete the old one.
    }

    public function esc_url($url)
    {

        if ('' == $url) {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string)$url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }

    function login_check()
    {

        if (!isset($this->data)) {
            $this->data = new Data();
        }

        // Check if all session variables are set
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SESSION['rank'])) {

            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
            $rank = $_SESSION['rank'];

            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            //$query = array('player-name' => new MongoRegex('/' . strtolower($username) . '/i'));
            if ($member = $this->data->findOne(Collection::CHARACTERS, array('player-name' => ucfirst($username) ))) {

                $login_check = hash('sha512', $member['encrypted'] . $user_browser);

                if (hash_equals($login_check, $login_string)) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }

            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }

    private function login($playerName, $password)
    {
        if (!isset($this->data)) {
            $this->data = new Data();
        }
        //new MongoRegex('/' . strtolower($playerName) . '/i')
        if ($member = $this->data->findOne(Collection::CHARACTERS, array('player-name' => ucfirst($playerName) ))) {


            // If the user exists we check if the account is locked
            // from too many login attempts


            /*  if (checkbrute($member['_id'], $db) == true) {
                  // Account is locked
                  // Send an email to user saying their account is locked
                  return false;
              } else {*/
            // Check if the password in the database matches
            // the password the user submitted. We are using
            // the hahs_equals function to avoid timing attacks.

            if (hash_equals($member['encrypted'], hash('sha512', $member['salt'] . $password))) {
                // Password is correct!
                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                $user_id = $member['_id'];
                // XSS protection as we might print this value

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = strtolower($playerName);
                $_SESSION['rank'] = $member['highest-rank'];
                $_SESSION['login_string'] = hash('sha512', $member['encrypted'] . $user_browser);

                // Login successful.
                return true;
            } else {
                // Password is not correct
                // We record this attempt in the database
                $now = time();
                // $mysqli->query("INSERT INTO login_attempts(user_id, time)
                // VALUES ('$user_id', '$now')");
                return false;
            }
            //}

        } else {
            // No user exists.
            return false;
        }

    }

    public function processLogin($username, $password)
    {
        
        if (isset($username, $password)) {
            //$username = filter_input($username, 'username', FILTER_SANITIZE_EMAIL);
            //$username = strtolower($username);
            //$password = $_POST['p']; // The hashed password.

            if ($this->login($username, $password) == true) {
                // Login success
                header("Location: ../test.php");
                exit();
            } else {
                // Login failed
                header('Location: ../login.php?error=1');
                exit();
            }
        } else {
            // The correct POST variables were not sent to this page.
            header('Location: ../error.php?err=Could not process login');
            exit();
        }
    }


    public function checkBruteForceAttack($user_id, $collection)
    {
        return false;
    }
    
    public function errorReporting(){

        $config=parse_ini_file('config.ini');
        
        if($config['Errors']=='ON'){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
        else {
            
        }
        
    }

    function normalizeUsername($username){
        $username=strtolower($username);
        $username=str_replace(' ', '_', $username);
        $username=ucwords($username);
        return $username;
    }

}


?>