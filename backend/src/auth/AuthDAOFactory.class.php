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

		require_once('teamroom/backend/src/dao/DAOFactory.class.php');
		$DAOFactory = new DAOFactory();
		 
		return $DAOFactory -> getUserInfoDAO();
	}
	
	/**
	 * @return MobacUserDAO
	 */
	public static function getMobacUserDAO(){
		
		require_once('dao/DAOFactory.class.php');
		$DAOFactory = new DAOFactory();
		 
		return $DAOFactory -> getUserInfoDAO();
	}

	/**
	 * more to come
	 */
}
?>
