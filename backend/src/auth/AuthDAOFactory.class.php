<?php

/**
 * DAOFactory
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 9.12.2014
 */

//require_once('utils/sql/Connection.class.php');

class AuthDAOFactory{

	/**
	 * @return CollapUserDAO
	 */
	public static function getCollapUserDAO(){

		global $logger;

		set_include_path(get_include_path() . PATH_SEPARATOR . "/var/www/html/teamroom/todelete/chat_box/chat/css/collapV3/backend/src/"  );
		$logger -> debug ( "seting include path as /var/www/html/teamroom/todelete/chat_box/chat/css/collapV3/backend/src/" );
		
		require_once('dao/DAOFactory.class.php');

		$DAOFactory = new DAOFactory();
		$logger -> debug ("Dao object created succesfully");
		
		return $DAOFactory -> getUserInfoDAO();
	}
	
	/**
	 * @return MobacUserDAO
	 */
	public static function getMobacUserDAO(){
		set_include_path(get_include_path() . PATH_SEPARATOR . "/var/www/html/devmobac/mobac/backend/src/");
		require_once('devmobac/mobac/backend/src/dao/DAOFactory.class.php');
		$DAOFactory = new DAOFactory();
		 
		return $DAOFactory -> getUserInfoDAO();
	}

	/**
	 * more to come
	 */
}
?>
