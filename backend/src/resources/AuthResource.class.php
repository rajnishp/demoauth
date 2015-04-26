<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'auth/Auth.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class AuthResource implements Resource {

    private $auth;

    public function __construct() {
		
        $this -> auth = new Auth();
		
    }

    public function checkIfRequestMethodValid($requestMethod) {
	
    	return in_array($requestMethod, array('post', 'options'));
    }

    public function options() {    

    }

    
    public function delete ($resourceVals, $data) {
    }

    public function put ($resourceVals, $data) {    }

    public function post ($resourceVals, $data) {
        global $logger, $warnings_payload;
        // $userId is set temporally, update it

        $logger -> debug ( json_encode($resourceVals) . " " . json_encode($data));
        $userKey = $this -> auth -> getAuth($data["username"], $data["password"], $data["project"] );


        return array ('code' => '4001', 
                        'data' => array(
                            'auth-key' => $userKey
                        )
        );
    }

    public function get($resourceVals, $data) {
   }

 
}