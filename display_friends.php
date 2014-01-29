<?
header('Content-Type:text/html; charset=UTF-8');
require 'src/facebook.php';
$facebook = new Facebook( array('appId' => '1424810797756636', 'secret' => 'e8660c0e1f69bfc80d6974f160ede44a', 'cookie' => true, ));

$user = $facebook -> getUser();

if ($user) {
	try {
		$user_profile = $facebook->api("/me");
		$friends = $facebook->api("/me/friends");
		//var_dump($friends);
		$data = array();	
		$datafriend = array();
		foreach ($friends["data"] as $friend) {
			// $data["name"] = $friend["name"];
			// $data["img"] = $friend["id"];
			$item = array('name' => $friend["name"], 'img' => "https://graph.facebook.com/".$friend["id"]."/picture");
			array_push($datafriend, $item);
			
		}
		$data=array("friends"=>array("me"=>$user_profile["name"],"friends"=>$datafriend));
		echo json_encode($data);
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
} else {
	$login_url = $facebook -> getLoginUrl(array('scope' => 'publish_stream', 'read_friendlists'));
	header('Location:' . $login_url);
}
?>