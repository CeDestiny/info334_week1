<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./styles/nba.css" type="text/css" />
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
		$query = "SELECT levenshtein_ratio(name, ?) as score, name, team, points, ppg, fg_pct, 3_pct, ft_pct, nbaid from stats order by 1 desc limit 20";
		echo $query."<br/>";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s', $search);
		//$query = "SELECT * from stats limit 20";
		$stmt->execute();
		$result = $stmt->get_result();

		foreach ($result as $row) {
			echo "<div class='nba_container'>\n";
				echo "<div class='nba_headshot_container'>\n";
					echo "<img class='lazyload' src='./images/nba_placeholder.png' data-src='".$nbaHeadshotPrefix.$row["nbaid"].$nbaHeadshotPostfix."' onerror='this.src=\"./images/nba_placeholder.png\"'>\n";
					// onerror='this.parentNode.removeChild(this)' onload='this.parentNode.backgroundImage=none'
				echo "</div>\n";
				echo "<div class='flex_col'>\n";
					echo "<h2 flex='1 1 auto'>".$row['name']."</h2>\n";
					echo "<div class='flex_row'>\n";
						echo "<div class='nba_player_main_stats'>\n";
							echo "<div><b>Team: </b>".$row['team']."</div>\n";
							echo "<div><b>Points: </b>".$row['points']."</div>\n";
							echo "<div><b>PPG: </b>".$row['ppg']."</div>\n";
						echo "</div>\n";
						echo "<div class='nba_player_stats'>\n";
							echo "<div class='nba_vert_stats'>\n";
								echo "<div class='nba_vert_stats_header'>FG %</div>\n";
								echo "<div class='nba_vert_stats_content'>".$row['fg_pct']."</div>\n";
							echo "</div>\n";
							echo "<div class='nba_vert_stats'>\n";
								echo "<div class='nba_vert_stats_header'>3pt %</div>\n";
								echo "<div class='nba_vert_stats_content'>".$row['3_pct']."</div>\n";
							echo "</div>\n";
							echo "<div class='nba_vert_stats'>\n";
								echo "<div class='nba_vert_stats_header'>FT %</div>\n";
								echo "<div class='nba_vert_stats_content'>".$row['ft_pct']."</div>\n";
							echo "</div>\n";
						echo "</div>\n";
					echo "</div>\n";
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