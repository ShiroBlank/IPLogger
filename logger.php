<?php
    include("config.php");
    $u_agent = $_SERVER['HTTP_USER_AGENT']; //Log useragent and try it against the whitelisted one
    //Connect too database
    try {
        $dbConn= new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        //Successfully connected to database
    } catch (PDOException $e) {
        die(); //kill page if db connection fails
    }
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         //Set the PDO error mode to exception.
    if ($whitelistedUA) {
        if ($u_agent != $whitelistedUAValue) {
            $sqla = 'INSERT INTO rejectedua (UAString) VALUES ("'.date("Y-m-d h:i:sa").'")';
            try {
                $dbConn->query($sqla);
            } catch (exception $e) {
            }
            die();
        }
    }
function getUserIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return ($ip);
}
$ipplace = getUserIpAddr();
$getcountry = file_get_contents("http://ip-api.com/json/$ipplace?fields=16385");
$countryobj = json_decode($getcountry);
$countryplace;
$timeoflog = date("Y-m-d h:i:sa");
switch ($countryobj->status) {
  case "fail":
    $countryplace = "N/A";
    break;
  case "success":
    $countryplace = (string) $countryobj->country;
    break;
  default:
    $countryplace = "API LIMIT EXCEEDED";
    break;
}
$sql = 'INSERT INTO users (ip, country, logtime) VALUES ("'.ip2long($ipplace).'", "'.$countryplace.'", "'.$timeoflog.'")';

try {
    $dbConn->query($sql);
} catch (exception $e) {
}
?>
