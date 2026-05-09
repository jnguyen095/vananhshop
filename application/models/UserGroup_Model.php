<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/15/2017
 * Time: 2:50 PM
 */
class UserGroup_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

	}

	function getAllUserGroup(){
		$query = $this->db->query("select * from usergroup");
		return $query->result();
	}
}
