<?php
class FuncionesC{
	
	function __construct(){
	}
	
	public function urls_amigables($url) {
		$url = strtolower($url);
		$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
		$repl = array('a', 'e', 'i', 'o', 'u', 'n');
		$url = str_replace ($find, $repl, $url);
		$find = array(' ', '&', '\r\n', '\n', '+');
		$url = str_replace ($find, '-', $url);
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$url = preg_replace ($find, $repl, $url);
		return $url;
	}
	
	public function limpiarHTML($cadena){
		return htmlspecialchars($cadena);
	}
	
	public function subirIMG($img){
		$data = file_get_contents($img);
		$pvars = array('image' => base64_encode($data), 'key' => 'b0e52afb3ea0d34035cce1db10ddb40b');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.xml');
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
		$xml = curl_exec($curl);
		preg_match ("/<original>(.*)<\/original>/xsmUi", $xml, $matches);
		$cad = $matches[1];
		curl_close ($curl);
		return $cad; 
	}
	
	public function ABC(){
		$abc = array('[0-9]','A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		return $abc;
	}
	
	public function limpiarYT($url){
		$cad = parse_url($url);
		$query = $cad['query'];
		parse_str($query,$out);
		return $out['v'];
	}
	
}
?>