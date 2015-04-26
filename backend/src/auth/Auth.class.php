<?php
require_once 'utils/predis/autoload.php';
require_once 'AuthDAOFactory.class.php';
class Auth {

	private $redis;
	private $AuthDAOFactory;

	public function __construct() {

		global $configs, $logger;
		$configs = json_decode (file_get_contents('collap-configs.json'), true);
		try {
                $logger -> debug ("Creating REDIS cache object");
                Predis\Autoloader::register();
                $this -> redis = new Predis\Client($configs ['redis'] ['client']);
            	//echo "Connection to server sucessfully \n";
            	} catch (Exception $e) {
                $logger -> warn ("Redis cache object could not be created");
                $this -> redis = null;
            }

           $this -> AuthDAOFactory = new AuthDAOFactory();
		
		
    }

	public function getAuth($username, $password, $project ){
		global $configs, $logger;

		$daoFun = "get".$project."UserDAO";
		
		$logger -> debug ("getAuth $username $project :: Creating DAO object by " . $daoFun  );
		$userDAO = $this -> AuthDAOFactory -> $daoFun();
		
		$user = $userDAO -> queryByUsername ($username);
		//var_dump($user);exit;
		$logger -> debug ("getAuth $username $project"  );
            

		if (isset( $user ) && $password == $user -> getPassword() ){
			$userKey = $this -> generateRandomString();
			$logger -> debug ("userKey" . $userKey);
			
			if ($this -> redis -> EXISTS($user -> getId() ) )
				return  $this -> redis->GET( $user -> getId() ); 
            
            $this -> redis->SET($user -> getId(), $userKey);    
			$this -> redis->SET($userKey, $user -> getId());
			
			return $userKey;	
		}
		else 
			return null;
	}

	public function getUserId ($userKey){
	
		return $this -> redis->GET($userKey);
		
	}

	public function generateRandomString($length = 20) {
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

