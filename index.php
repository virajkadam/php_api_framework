<?php 

class v1{

	public static function headers (){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers:Content-Type, Accept, X-Requested-With, Session ');
		header('Access-Control-Allow-Methods: GET, POST ');
	}

	
	public static function login(){

		require_once(realpath(__DIR__ . '/../') . '/config.php');

		$json = json_decode(file_get_contents('php://input'),true);
		$db = $conn;

		if(!empty($json['mobile']) && !empty($json['password'])){

			$mobile = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['mobile'], 0, 30)))));
			$password = htmlspecialchars(stripslashes(strip_tags(trim(substr($json['password'], 0, 30)))));
			
			$qr = $db->prepare("MYSQL QUERY HERE ");
			$qr->execute();

			if ($qr->rowCount() > 0) {  

				$res['admin_id'] = $qr->fetch(PDO::FETCH_ASSOC)['PRIMARY COLUMN'];
				$res['st'] = 1; 
				$res['msg'] = 'login success';

			}else{

				$res['admin_id'] = '';
				$res['st'] = 2; 
				$res['msg'] = 'No data found';
			}

		}else{

			$res['st'] = 3;
			$res['msg'] = 'Some field maybe empty';
			
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
