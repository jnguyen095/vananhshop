<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 6/6/2026
 * Time: 9:26 PM
 */
class Remember_me
{
	public function auto_login()
	{
		$CI =& get_instance();
		$CI->load->helper('cookie');
		if($CI->session->userdata('loginuser'))
		{
			return;
		}

		$cookie = get_cookie('remember_token');

		if(!$cookie)
		{
			return;
		}

		$parts = explode(':', $cookie);

		if(count($parts) != 2)
		{
			return;
		}

		$user_id = $parts[0];
		$token   = $parts[1];

		$records = $CI->db
			->where('user_id', $user_id)
			->where('expired_at >', date('Y-m-d H:i:s'))
			->get('user_remember_tokens')
			->result();

		foreach($records as $row)
		{
			if(password_verify($token, $row->token))
			{
				$user = $CI->db
					->select('us3r.*, usergroup.Code')
					->where('Us3rID', $user_id)
					->join('usergroup', 'usergroup.UserGroupID = us3r.UserGroupID', 'inner')
					->get('us3r')
					->row();

				if($user)
				{
					$CI->session->set_userdata([
						'loginid' => $user->Us3rID,
						'fullname'    => $user->FullName,
						'phone' => $user->Phone,
						'loginuser' => TRUE,
						'usergroup' => $user->Code
					]);
				}

				return;
			}
		}
	}
}
