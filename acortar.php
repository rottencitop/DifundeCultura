<?php
function getting_shorty($url, $format = 'txt') {
    $username  = 'difundecultura';
    $apikey    = 'R_ef1b558a35c7444f80e1b5f579b4b67f';
    $bitly_api = 'http://api.bit.ly/v3/shorten?login=' . $username . '&apiKey=' . $apikey . '&uri=' . urlencode( $url ) . '&format=' . $format;
    $curl_init = curl_init();
    curl_setopt($curl_init, CURLOPT_URL, $bitly_api);
    curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, 5);
    $data      = curl_exec($curl_init);
    curl_close($curl_init);
    return $data;
}

echo getting_shorty("http://www.difundecultura.com/concierto/1-jorge-gonzalez-teatro-caupolican.html");

?>