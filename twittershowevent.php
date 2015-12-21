<?php
/*
TUBES II3160 Pemrograman Integratif
Nama : 
	Monika Tarsisia Nangoi - 18213007
	Rana Nugramahesa - 18213011
Deskripsi : Melakukan crawling dari twitter, mencari tweets yang berhubungan dengan suatu keyword
*/
?>

<!DOCTYPE html>
<html>
<title> Crawling Event on Twitter </title>
<head> 
	<link rel="stylesheet" href="stylestwitter.css">
	<h1> Crawling Event on Twitter </h1> 
</head>
<body>
<fieldset style="width:350px">
<legend align="center"> <font face = "courier" font size = "5"> <b> Twitter Crawling </b> </font> </legend> 
<div class="scrollingtweet">
<?php

date_default_timezone_set('Asia/Shanghai');

$info = file_get_contents('http://localhost:81/twitter-api-php-master/twitter3.php');
$info = json_decode($info);
echo "<table>";
foreach($info as $row) {
	echo "<tr>";
		echo "<table border class = 'boldtable'>";
			echo "<td>";
				echo '<img src="' . $row->pic . '">';
			echo "</td>";
			echo "<td>";
				echo "<table>";
					echo "<tr>";
						echo "<td>";
							echo "<table>";
								echo "<tr>";
									echo "<td>";
										echo '@' . $row->username . ' - ';
									echo "</td>";
									echo "<td>";
										echo $row->date[8] . $row->date[9] . ' ' . $row->date[4] . $row->date[5] . $row->date[6] . ' ' . $row->date[26] . $row->date[27] . $row->date[28] . $row->date[29] . '   ' . $row->date[11] . $row->date[12] . ':' . $row->date[14] . $row->date[15] . ':' . $row->date[17] . $row->date[18] .'<br>';
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>";
							echo $row->text . '<br>';
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</table>";
	echo "</tr>";
}
echo "</table>";
?>
</div>
</fieldset>
</body>
</html>
