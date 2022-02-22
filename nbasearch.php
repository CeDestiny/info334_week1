<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./styles/nba.css" type="text/css" />
  <script src="./js/lazysizes.min.js" async="">
	//document.addEventListener("DOMContentLoaded", yall);
  </script>
<?php
function getSearchResults() {
	$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_EMAIL);

	if ($search === null)
	{
		echo "No results";
	} else
	{
		echo "The search result for <mark> $search </mark>.";

		$nbaHeadshotPrefix = "https://cdn.nba.com/headshots/nba/latest/260x190/";
		$nbaHeadshotPostfix = ".png";

		include 'dbsetup.php';
		$query = "SELECT levenshtein_ratio(name, ?) as score, name, team, points, ppg, nbaid from stats order by 1 desc limit 20";
		echo $query."<br/>";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s', $search);
		//$query = "SELECT * from stats limit 20";
		$stmt->execute();
		$result = $stmt->get_result();

		foreach ($result as $row) {
			echo "<div class='nba_container'>\n";
				echo "<div class='nba_headshot_container'>\n";
					echo "<img class='lazyload' src='/images/nba_placeholder.png' data-src='".$nbaHeadshotPrefix.$row["nbaid"].$nbaHeadshotPostfix."' onerror='this.src=\"./images/nba_placeholder.png\"'>\n";
					// onerror='this.parentNode.removeChild(this)' onload='this.parentNode.backgroundImage=none'
				echo "</div>\n";
				echo "<div class='nba_player_stats'>\n";
					echo "<h2>".$row['name']."</h2>\n";
					echo "<div class='nba_vert_stats'><b>Team: </b>".$row['team']."</div>\n";
					echo "<div class='nba_vert_stats'><b>Points: </b>".$row['points']."</div>\n";
					echo "<div class='nba_vert_stats'><b>PPG: </b>".$row['ppg']."</div>\n";
				echo "</div>\n";
			echo "</div>\n";
		}
	}
}
?>

</head>
<body>
<?php getSearchResults() ?>
</body>
</html>