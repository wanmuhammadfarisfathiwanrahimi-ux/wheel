<?php
session_start();                      // must be the very first line
include "wheel_lib.php";

$title = $_POST["title"];
$theme = $_POST["theme"];
$speed = $_POST["speed"];
$items = cleanItems($_POST["options"]);
$count = count($items);

if ($count < 2)
{
    echo "Please enter at least 2 options. <a href='create.html'>Back</a>";
    exit;
}

if ($speed == "fast") { $seconds = 3; }
else { $seconds = 6; }

$winnerIndex = rand(0, $count - 1);
$winner = $items[$winnerIndex];

setcookie("lasttheme", $theme, time() + (86400 * 30), "/");

if (!isset($_SESSION["history"]))
{
    $_SESSION["history"] = array();
}
$_SESSION["history"][] = $winner;
?>
<html>
<head>
<title>Spin Result</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1><?php echo htmlspecialchars($title); ?></h1>

<?php drawWheel($items, $theme, $winnerIndex, $seconds); ?>

<p>Theme: <?php echo $theme; ?> | Options: <?php echo $count; ?> | Spin time: <?php echo $seconds; ?> seconds</p>

<ol>
<?php
for ($i = 0; $i < $count; $i++)
{
    echo "<li>" . htmlspecialchars($items[$i]) . "</li>";
}
?>
</ol>

<p class="winner" style="animation-delay: <?php echo $seconds; ?>s">
  Winner: <?php echo htmlspecialchars($winner); ?>
</p>

<h3>Winners so far (this visit)</h3>
<ul>
<?php
$history = $_SESSION["history"];
$i = 0;
while ($i < count($history))
{
    echo "<li>" . htmlspecialchars($history[$i]) . "</li>";
    $i++;
}
?>
</ul>

<p>Last theme cookie:
<?php
if (isset($_COOKIE["lasttheme"])) { echo $_COOKIE["lasttheme"]; }
else { echo "(reload the page to see it)"; }
?></p>

<a href="reset.php">Clear history</a><br><br>
<a href="create.html">Make another wheel</a>
</body>
</html>