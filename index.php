<?php 

class v1{

	public static function headers (){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers:Content-Type, Accept, X-Requested-With, Session ');
		header('Access-Control-Allow-Methods: GET, POST ');
	}

	///////admin login///////////////
	public static function login(){

		require_once(realpath(__DIR__ . '/../') . '/config/config.php');

		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['mobile']) && !empty($json['password'])){

			$mobile = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['mobile'], 0, 30)))));
			$password = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['password'], 0, 30)))));
			
			$qr = $db->prepare("SELECT id FROM lion_admin WHERE mobile = '$mobile' AND password = '$password' LIMIT 1 ");
			$qr->execute();

			if ($qr->rowCount() > 0) {  

				$res['admin_id'] = $qr->fetch(PDO::FETCH_ASSOC)['id'];
				$res['st'] = 1; 
				$res['msg'] = 'login success';

			}else{

				$res['admin_id'] = '';
				$res['st'] = 2; 
				$res['msg'] = 'no admin found';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';
			
		}

		self::headers();
		echo json_encode($res);
	}

	///////set control///////////////
	public static function set_control(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['power']) && !empty($json['mode']) && !empty($json['fanspeed']) && !empty($json['swing']) && !empty($json['set_temp']) && !empty($json['ac_id'])){

			$power = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['power'], 0, 30)))));
			$mode = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['mode'], 0, 30)))));
			$fanspeed = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['fanspeed'], 0, 30)))));
			$swing = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['swing'], 0, 30)))));
			$set_temp = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['set_temp'], 0, 30)))));
			$ac_id = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['ac_id'], 0, 6)))));
			$date_time = time();
			$admin_id = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['admin_id'], 0, 6)))));
			
			$qr = $db->prepare("INSERT INTO lion_control(power, mode, fanspeed, swing, set_temp, ac_id, date_time, admin_id ) VALUES ('$power', '$mode', '$fanspeed', '$swing', '$set_temp', '$ac_id','$date_time', '$admin_id')");
			$qr->execute();


			if ($qr->rowCount() > 0) {

				$res['st'] = 1; 
				$res['msg'] = 'successfully set control';

			}else{

				$res['st'] = 2; 
				$res['msg'] = 'error ';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';
			
		}
		self::headers();
		echo json_encode($res);
	}


	/////////control list///////
	public static function control_list(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['ac_id'])){

			$ac_id = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['ac_id'], 0, 6)))));

			$qr = $db->prepare("SELECT id, power, mode, fanspeed, swing, set_temp, ac_id FROM lion_control WHERE ac_id = '$ac_id' ORDER BY id DESC LIMIT 1 ");
			$qr->execute();
			
			if ($qr->rowCount() > 0) {


				$data = $qr->fetchAll(PDO::FETCH_ASSOC)[0];

				if( strtolower( $data['power'] ) == 'on' && strtolower( $data['mode'] ) != 'heat'){


					$raw_code = $data['set_temp'] . '_' . $data['mode'] . '_' . $data['fanspeed'] . '_' . $data['swing'];

					$qr1 = $db->prepare("SELECT code FROM ir_code WHERE code_name = '$raw_code' ");
					$qr1->execute();
					$data1 = $qr1->fetchAll(PDO::FETCH_ASSOC)[0]['code'];



				}else if( strtolower( $data['power'] ) == 'off'){



					$qr1 = $db->prepare("SELECT code FROM ir_code WHERE code_name = 'off' ");
					$qr1->execute();                
					$data1 = $qr1->fetchAll(PDO::FETCH_ASSOC)[0]['code'];


				}else if( strtolower( $data['mode'] ) == 'heat' && strtolower( $data['power'] ) == 'on'){


					$qr1 = $db->prepare("SELECT code FROM ir_code WHERE code_name = 'heat' ");
					$qr1->execute();                
					$data1 = $qr1->fetchAll(PDO::FETCH_ASSOC)[0]['code'];


				}


				$res['st'] = 1; 
				$res['msg'] = 'success';
				$res['set_control'] = $data;
				$res['raw_code'] = $data1;

			}else{

				$res['st'] = 2; 
				$res['msg'] = 'no data';
				$res['set_control'] = array();
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';
		}
		
		self::headers();
		echo json_encode($res);
	}


	///////set status///////////////
	public static function set_status(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['power']) && !empty($json['mode']) && !empty($json['set_temp']) && !empty($json['ac_id']) && !empty($json['room_temp']) && !empty($json['room_humidity']) ){

			$power = @$json['power'];
			$mode = @$json['mode'];
			$fanspeed = @$json['fanspeed'];
			$swing = @$json['swing'];
			$set_temp = @$json['set_temp'];
			$ac_id = @$json['ac_id'];
			$room_temp = @$json['room_temp'];
			$room_humidity = @$json['room_humidity'];
			$compressor_1 = @$json['compressor_1'];
			$compressor_2 = @$json['compressor_2'];
			$fan = @$json['fan']    ;
			$date_time = time();

			$qr = $db->prepare("INSERT INTO lion_status (power, mode, fanspeed, swing, set_temp, ac_id, room_temp, room_humidity, compressor_1, compressor_2, fan, date_time) 

				VALUES ('$power', '$mode','$fanspeed', '$swing', '$set_temp', '$ac_id', '$room_temp', '$room_humidity', '$compressor_1', '$compressor_2','$fan','$date_time')");
			$qr->execute();

			if ($qr->rowCount() > 0) {

				$res['st'] = 1; 
				$res['msg'] = 'successfully set status';

			}else{

				$res['st'] = 2; 
				$res['msg'] = 'error ';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';

		}
		
		self::headers();
		echo json_encode($res);
	}

	/////////// status details////
	public static function status_details(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$db = $conn;
		$json = json_decode(file_get_contents('php://input'),true);

		if(!empty($json['ac_id'])){

			$ac_id = $json['ac_id'];
			
			$qr = $db->prepare("SELECT power, mode, fanspeed, swing, set_temp, ac_id, room_temp, room_humidity, compressor_1, compressor_2, fan, date_time FROM lion_status WHERE ac_id = '$ac_id' ORDER BY id DESC LIMIT 1 ");
			$qr->execute();
			
			if ($qr->rowCount() > 0) {  

				$res['status_details'] = $qr->fetchAll(PDO::FETCH_ASSOC);
				$res['st'] = 1; 
				$res['msg'] = 'success';

			}else{
				$res['status_details'] = array();
				$res['st'] = 2; 
				$res['msg'] = 'no data found';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';
			
		}
		self::headers();
		echo json_encode($res);
	}

	/////////// test_code////
	public static function test_code(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$db = $conn;
		$json = json_decode(file_get_contents('php://input'),true);

		if(!empty($json['code_name'])){

			$code_name = $json['code_name'];
			
			$qr = $db->prepare("SELECT code_name, code FROM test_code WHERE code_name = '$code_name' LIMIT 1 ");
			$qr->execute();
			
			if ($qr->rowCount() > 0) {  

				$res['test_code'] = $qr->fetchAll(PDO::FETCH_ASSOC);
				$res['st'] = 1; 
				$res['msg'] = 'success';

			}else{
				$res['test_code'] = array();
				$res['st'] = 2; 
				$res['msg'] = 'no data found';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';

		}
		self::headers();
		echo json_encode($res);
	}



	/////////control list  test///////
	public static function control_list_test(){
		require_once(realpath(__DIR__ . '/../') . '/config/config.php');
		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['ac_id'])){

			$ac_id = $json['ac_id'];

			$qr = $db->prepare("SELECT id, power, mode, fanspeed, swing, set_temp, ac_id FROM lion_control WHERE ac_id = '$ac_id' ORDER BY id DESC LIMIT 1 ");
			$qr->execute();
			
			if ($qr->rowCount() > 0) {

				$data = $qr->fetchAll(PDO::FETCH_ASSOC)[0];

				$raw_code = $data['set_temp'] . '_' . $data['mode'] . '_' . $data['fanspeed'] . '_' . $data['swing'];

				$qr1 = $db->prepare("SELECT code FROM test_code WHERE code_name = '$raw_code' ");
				$qr1->execute();
				
				$data1 = $qr1->fetchAll(PDO::FETCH_ASSOC)[0]['code'];

				$res['st'] = 1; 
				$res['msg'] = 'success';
				$res['set_control'] = $data;
				$res['raw_code'] = $data1;

			}else{

				$res['st'] = 2; 
				$res['msg'] = 'no data';
				$res['set_control'] = array();
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'some field empty';
		}
		
		self::headers();
		echo json_encode($res);
	}




//////////////////////////////////////////////////////////////////////////////////////////////////

} 

// END OF CLASS


if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST ");         

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$data = $_GET['call'];
	$obj = new v1();
	if (method_exists('v1', $data)) {
		$obj->$data();
	}else{
		$res = array('st' => 0, 'msg'=>'Invalid API call');
		echo json_encode($res);
	}
}else{
	$res = array('st' => 0, 'msg'=>'Only POST METHOD ALLOWED');
	echo json_encode($res);
}