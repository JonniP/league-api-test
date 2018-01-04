<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>League API</title>
</head>

<body>
<?php
include 'helpers.php';
ini_set("display_errors", 1);

$name = $_GET['name'];
$region = $_GET['region'];

$key = 'RGAPI-91505796-5245-44d7-a101-4c9c471e9bb1';
$url = "https://$region.api.riotgames.com/lol/summoner/v3/summoners/by-name/$name?api_key=$key";

$user = getinfo($url);
$summoner_id = $user['id'];

$rank_url = "https://$region.api.riotgames.com/lol/league/v3/positions/by-summoner/$summoner_id?api_key=$key";

$rank = getinfo($rank_url);
$user_name = $user['name'];
$user_level = $user['summonerLevel'];

for($i = 0; $i < count($rank); $i++){
        if ($rank[$i]['queueType'] == 'RANKED_SOLO_5x5') {
        	$user_tier = $rank[$i]['tier'];
        	$user_rank = $rank[$i]['rank'];
        }
}

// echo $summoner_id;
echo '<div class="player">';
echo "Found user:<br>";
echo "Name: $user_name<br>";
echo "Level: $user_level<br>";
echo "Rank: $user_tier $user_rank</div>";


?>

</body>
</html>
