<?php
	
	function info($user, $cookie){
		$getinfo = request(1, generate_useragent(), 'users/'.$user.'/usernameinfo/', $cookie);
		$info = json_decode($getinfo[1]);
		return $info;
	}
	
	function cookie($header){
		preg_match_all('%Set-Cookie: (.*?);%',$header,$d);$cookie='';
		for($o=0;$o<count($d[0]);$o++)
		$cookie.=$d[1][$o].";";
		return $cookie;
	}
	
	function login($u, $p){
		$post_login = json_encode([
            'phone_id' => generateUUID(true),
            '_csrftoken' => get_csrftoken(),
            'username' => $u,
            'guid' => generateUUID(true),
            'device_id' => generateUUID(true),
            'password' => $p,
            'login_attempt_count' => 0
		]);
		$logins = request(1, generate_useragent(), 'accounts/login/', 0, generateSignature($post_login));
		return $logins;
	}
	
	function check($u, $p){
		$dologin = login($u, $p);
		$header = $dologin[0];
		$login = json_decode($dologin[1]);
		$info = info($u, cookie($header));
		if ($login->status == "ok"){
			if(empty($info->user->is_verified)){
				$verified = "No";
			}else{
				$verified = "Yes";
			}
			if(empty($info->user->is_business)){
				$business = "No";
			}else{
				$business = "Yes";
			}
			$data =	array(
					"error"=>0,
					"msg"=>"success logged in",
					"data"=>array(
							"auth"=>array(
									"username" => $u,
									"password" => $p									
									),
							"id" => $info->user->pk,
							"follower" => $info->user->follower_count,
							"following" => $info->user->following_count,
							"media" => $info->user->media_count,
							"verified" => $verified,
							"business" => $business
							),
					"reason"=> 0
					);
								file_put_contents("InstaValid.txt", $u."|".$p." | Follower: ".$info->user->follower_count." |- Sukses \n", FILE_APPEND);

			print_r(json_encode($data));
		}else{
			if($login->message == "checkpoint_required"){
							file_put_contents("InstaValid.txt", $u."|".$p." - Checkpoint \n", FILE_APPEND);

				$data =	array(
					"error"=>1,
					"msg"=>"checkpoint",
					"data"=>array(
							"auth"=>array(
									"username" => $u,
									"password" => $p									
									),
							),
					"reason"=> "checkpoint"
					);
			print_r(json_encode($data));
			}
			if($login->message == "The password you entered is incorrect. Please try again."){
				$data =	array(
					"error"=>2,
					"msg"=>"wrong password",
					"data"=>array(
							"auth"=>array(
									"username" => $u,
									"password" => $p									
									),
							),
					"reason"=> "wrong_pass"
					);
			print_r(json_encode($data));
			}
			if($login->message == "The username you entered doesn't appear to belong to an account. Please check your username and try again."){
				$data =	array(
					"error"=>2,
					"msg"=>"wrong email or username",
					"data"=>array(
							"auth"=>array(
									"username" => $u,
									"password" => $p									
									),
							),
					"reason"=> "wrong_username"
					);
			print_r(json_encode($data));
			}
		}	
	}	
   
?>
