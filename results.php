<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>League API</title>
</head>

<body>
<?php
include 'helpers.php';
ini_set("display_errors", 1);

$name = $_GET['name'];
$region = $_GET['regionSelect'];
if ($region == 'na1'){
	$fake_region = 'eun1';
} else $fake_region = 'na1';

$key = 'INSERT_KEY_HERE';
$url = "https://$region.api.riotgames.com/lol/summoner/v3/summoners/by-name/$name?api_key=$key";

$user = getinfo($url);
if (in_array($user['id'], $user, TRUE)){
	$summoner_id = $user['id'];

	$rank_url = "https://$region.api.riotgames.com/lol/league/v3/positions/by-summoner/$summoner_id?api_key=$key";
	$rank = getinfo($rank_url);

	$mastery_url = "https://$region.api.riotgames.com/lol/champion-mastery/v3/champion-masteries/by-summoner/$summoner_id?api_key=$key";
	$mastery = getinfo($mastery_url);

	$champions_url = "https://$fake_region.api.riotgames.com/lol/static-data/v3/champions?locale=en_US&dataById=true&api_key=$key"; //retrieves all champs
	$champions = getinfo($champions_url);
	
	$user_name = $user['name'];
	$user_level = $user['summonerLevel'];

	if ($rank){
		for($i = 0; $i < count($rank); $i++){
       			 if ($rank[$i]['queueType'] == 'RANKED_SOLO_5x5') {
  		      		$user_tier = $rank[$i]['tier'];
        			$user_rank = $rank[$i]['rank'];
        		}else{
				$user_tier = 'UNRANKED';
				$user_rank = '';
			}
		}
	}else{
		$user_tier = 'UNRANKED';
		$user_rank = '';
	}
	// echo $summoner_id;
	echo '<div class="player">';
	echo "Found user:<br>";
	echo "Name: $user_name<br>";
	echo "Level: $user_level<br>";
	echo "Rank: $user_tier $user_rank<br><br>";
	echo "Most played champions:<br><br>";
	for ($a = 0; $a < 5; $a++){
		$cName = $champions['data'][$mastery[$a]['championId']]['name'];
		echo "Champion: $cName<br>";
		echo "Mastery points: " . $mastery[$a]['championPoints'] . "<br>";
		echo "Mastery level: " . $mastery[$a]['championLevel'] . "<br><br>";
	}
	echo "</div>";
	
} else {
	echo '<div class="player">';
	echo "Sorry! No user called $name found on $region server</div>";
}
?>

</body>
</html>
