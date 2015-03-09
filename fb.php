<?php
	require_once('fb/facebook.php'); 
	$config = array(
  		'appId'  => '628003447236654',
  		'secret' => '67463660170bb81fd711930d8a4c7be5',
		);
	$facebook = new Facebook($config);
	
	$user = $facebook->getUser();
	if($user){
		echo "Esta Logueado";
		$me = $facebook->api('/me');
		var_dump($me);
		#$me = $facebook->api('/757514117596228?fields=access_token','GET');
		/*$token = 'CAAI7KnJj6C4BACrOqF9Pw3l3e2i5nqzaR7qk7LAIVds0L7xZBJ9MuBnZCjgzKfCsokuPsLN3WKhIZAnrNJyeUqUTt3OfR9ib54BkHsdCgYS8jA98JZCW5PsmzUlmP8EGL8QYvMxfxeTdyZAHSZA4bs4iljmwsZAlZBbPbLXrJZB4VMVLlZC5qzvmxq';
		$args = array(
    'access_token'  => $token,
    'message' => 'New Video : Mensaje desde PHP', 
    'link'    => 'http://www.linktomysite.com',
    'picture' => 'http://img.youtube.com/vi/YFuqcNBFj54/0.jpg',
    'name'    => 'Los Prisioneros - Amiga mia',
    'description'=> 'Nuevo video de los prisioneros'
    );    
$post_id = $facebook->api("/757514117596228/feed","post",$args);*/
	}
	else{
		$login = $facebook->getLoginUrl(array(
                       'scope' => 'publish_stream,email,manage_pages'
                       ));
		echo "No está logueado<br>";
		echo '<a href="'.$login.'">Ingresar con Facebook</a>';
	}
?>
