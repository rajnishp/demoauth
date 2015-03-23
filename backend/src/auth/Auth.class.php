<?php
require_once '../utils/predis/autoload.php';
require_once 'AuthDAOFactory.class.php';
class Auth {

	private $redis;

	public function __construct() {

		global $configs;
		$configs = json_decode (file_get_contents('../nucleus-configs.json'), true);
		try {
                $logger -> debug ("Creating REDIS cache object");
                Predis\Autoloader::register();
                $this -> redis = new Predis\Client($configs ['redis'] ['client']);
            	//echo "Connection to server sucessfully \n";
            	} catch (Exception $e) {
                $logger -> warn ("Redis cache object could not be created");
                $this -> redis = null;
            }
		
		
    }

	public function getAuth($username, $password, $project ){
	
		$userDAO = get.$project.UserDAO();
		
		$user = $userDAO -> queryByUsername ($username);

		if (isset( $user )){
			$userKey = $this -> generateRandomString();
			$this -> redis->SET($userKey, $user -> getId());
			return $userKey;	
		}
		else 
			return null;
	}

	public function getUserId($userKey){
	
		return $this -> redis->GET($userKey);
		
	}

	public function generateRandomString($length = 10) {
    		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    		return $randomString;
	}

}

//$auth = new Auth();
//$userKey = $auth -> getAuth("111", "redhat", "Mobac" );
//echo "userkey :: ".$userKey . "\n\n";

//echo "user id :: ". $auth -> getUserId ($userKey) . "\n\n";

?>

