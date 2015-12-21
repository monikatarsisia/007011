<?php 
/*
TUBES II3160 Pemrograman Integratif
Nama : 
	Monika Tarsisia Nangoi - 18213007
	Rana Nugramahesa - 18213011
Deskripsi : Melakukan crawling dari twitter, mengambil tweets dari beberapa username, dan menampilkannya berdasarkan urutan waktu posting
*/

date_default_timezone_set('Asia/Jakarta');
require_once('TwitterAPIExchange.php');

function getTweetsFromUser ($str){
# Fungsi untuk mengambil tweets dari Twitter berdasarkan username, mengembalikan sebuah array tweets berisi array( [username];[text];[created_date];[url_image])
	$tweets = array(); // Variable array yang akan di return

	$settings = array(
		'oauth_access_token' => "43333948-LKbntZQlvnvpATBVynnNPtc3TFsjN7NMuoddPsrT4",
		'oauth_access_token_secret' => "dxQAsRKvmvS0KKTc7s0uLFgFx7d6CflbK3G9T4PBDJ3SS",
		'consumer_key' => "MKbLzBbpTz5SL8Fg0nCYBvEhl",
		'consumer_secret' => "jk1NshfMT9pt3Lyx09umJV3NwKlec67ZXMYJ57dmwPxkcOurHs"
	);

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name=' . $str . '&exclude_replies=true&count=10';
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($settings);
	$info = $twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest();
	
	$tweets2= json_decode($info, $assoc = TRUE);

	$jeb = 0;
	for ($x=0;$x<10;$x++) {
		if (isset($tweets2[$x]['created_at'])) {
			$tweets[$jeb] = array ('username' => $tweets2[$x]['user']['screen_name'], 'text' => $tweets2[$x]['text'], 'created_at' => $tweets2[$x]['created_at'], 'pic' => $tweets2[$x]['user']['profile_image_url']);
			$jeb++;
		}
	} 
	return $tweets;
}

function get_list_of_twitter() {
# Mengambil semua username twitter dari database

	$info = array();

	$conn = new mysqli('localhost', 'root', 'admin', 'twitter');

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
		$info = "fail connect database";
	} else {
		$sqlquery = 'SELECT * FROM list_twitter';
		$result = $conn->query($sqlquery);
		while($r = $result->fetch_assoc()){
			$info[] = array($r);
		}
	}
	
	$conn->close();		
	return ($info);
}

function countDatabase() {
# Menghitung jumlah username twitter yang ada pada database

	$info = 0;

	$conn = new mysqli('localhost', 'root', 'admin', 'twitter');

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
		$info = "fail connect database";
	} else {
		$sqlquery = 'SELECT * FROM list_twitter';
		$result = $conn->query($sqlquery);
		while($r = $result->fetch_assoc()){
			$info++;
		}
	}
	
	$conn->close();		
	return ($info);
}

function monthChangeFormat($str) {
# Mengubah bulan dari Jan menjadi 01
	switch ($str) {
		case "Jan" :
			$format = "01";
			break;
		case "Feb" :
			$format = "02";
			break;
		case "Mar" :
			$format = "03";
			break;
		case "Apr" :
			$format = "04";
			break;
		case "May" :
			$format = "05";
			break;
		case "Jun" :
			$format = "06";
			break;
		case "Jul" :
			$format = "07";
			break;
		case "Aug" :
			$format = "08";
			break;
		case "Sep" :
			$format = "09";
			break;
		case "Oct" :
			$format = "10";
			break;
		case "Nov" :
			$format = "11";
			break;
		case "Dec" :
			$format = "12";
			break;			
		default :
			$format = "00";
	}
	return $format;
}

function isRecentDate($date1, $date2) {
# Menghasilkan true apabila $date1 lebih besar dari $date2 atau $date1
	$isDate = false;
	$d1 = $date1[8] . $date1[9];
	$d2 = $date2[8] . $date2[9];
	$month1 = $date1[4] . $date1[5] . $date1[6];
	$mo1 = monthChangeFormat($month1);
	$month2 = $date2[4] . $date2[5] . $date2[6];
	$mo2 = monthChangeFormat($month2);
	$y1 = $date1[26] . $date1[27] . $date1[28] . $date1[29];
	$y2 = $date2[26] . $date2[27] . $date2[28] . $date2[29];
	
	$h1 = $date1[11] . $date1[12];
	$h2 = $date2[11] . $date2[12];
	$m1 = $date1[14] . $date1[15];
	$m2 = $date2[14] . $date2[15];
	$s1 = $date1[17] . $date1[18];
	$s2 = $date2[17] . $date2[18];
	
	if ((int)$y1 < (int)$y2) {
		$isDate = false;
	} else if ((int)$y1 > (int)$y2) {
		$isDate = true;
	} else {
		if ((int)$mo1 < (int)$mo2) {
			$isDate = false;
		} else if ((int)$mo1 > (int)$mo2) {
			$isDate = true;
		} else {
			if ((int)$d1 < (int)$d2) {
				$isDate = false;
			} else if ((int)$d1 > (int)$d2) {
				$isDate = true;
			} else {
				if ((int)$h1 < (int)$h2) {
					$isDate = false;
				} else if ((int)$h1 > (int)$h2) {
					$isDate = true;
				} else {
					if ((int)$m1 < (int)$m2) {
						$isDate = false;
					} else if ((int)$m1 > (int)$m2) {
						$isDate = true;
					} else {
						if ((int)$s1 < (int)$s2) {
							$isDate = false;
						} else if ((int)$s1 > (int)$s2) {
							$isDate = true;
						} else {
							$isDate = false;
						}
					}
				}
			}
		}
	}
	
	return $isDate;
}

/* KAMUS DATA */
$ut = 0; // Variabel looping
$tweps = array(); // Variabel untuk menampung semua tweets berdasarkan semua username pada database
$username = array(); // Variabel yang menampung semua username pada database
$tweet2 = array(); // Variabel tweet2 yang sudah terurut berdasarkan waktu

# Mengambil username dari database
$username = get_list_of_twitter(); 
# Jumlah username pada database
$countusername = countDatabase(); 

# Memasukkan semua tweet dari tiap username kedalam $tweps
foreach ($username as $user) {
	$tweps[$ut] = getTweetsFromUser($user[0]['username']);
	$ut++;
}

# Mengubah Array 3 dimensi menjadi 2 dimensi (menyederhanakan array)
$ch = 0; // variabel looping
for ($y=0;$y<$countusername;$y++) {
	for ($z=0;$z<10;$z++) {
		if (isset($tweps[$y][$z]['created_at'])) {
			$tweet2[$ch] = array ('username' => $tweps[$y][$z]['username'], 'text' => $tweps[$y][$z]['text'], 'created_at' => $tweps[$y][$z]['created_at'], 'pic' => $tweps[$y][$z]['pic']);
			$ch++;
		}
	}
}

# Sorting $Tweet2 berdasarkan waktu posting
$dummy = array();
for ($i=0;$i<$ch;$i++) {
	for ($j=$ch-1;$j>=$i;$j--) {
		if (isRecentDate($tweet2[$i]['created_at'], $tweet2[$j]['created_at'])) {
			
		} else {
			$dummy = array ('username' => $tweet2[$i]['username'], 'text' => $tweet2[$i]['text'], 'created_at' => $tweet2[$i]['created_at'], 'pic' => $tweet2[$i]['pic']);
			$tweet2[$i] = array ('username' => $tweet2[$j]['username'], 'text' => $tweet2[$j]['text'], 'created_at' => $tweet2[$j]['created_at'], 'pic' => $tweet2[$j]['pic']);
			$tweet2[$j] = $dummy;
		}
	}
} 

for($xxx=0;$xxx<10;$xxx++) {
  $username=$tweet2[$xxx]['username']; 
  $text=$tweet2[$xxx]['text'];
  $date=$tweet2[$xxx]['created_at'];
  $pic=$tweet2[$xxx]['pic'];
  
  $tweetfinal[] = array('username'=> $username,'text'=> $text, 'date' => $date, 'pic' => $pic);
}

/*$test = 0;
foreach($tweet2 as $params) {
	echo $test . '. ' . $params['created_at'] . ' @' . $params['username'] . ' === ' . $params['text'] . '<br>';
	$test++;
} */

/*if (isset($_GET["username"])) {
	$tweps = getTweetsFromUser($_GET["username"]);
	for ($x=0;$x<10;$x++) {
		echo $tweps[$x]['created_at'];
		echo $tweps[$x]['username'];
		echo $tweps[$x]['text'];
		echo "<br>";
		echo '<img src="' . $tweps[$x]['pic'] . '">';
	}
} */

echo $information = json_encode($tweetfinal);

return($information);
?>
