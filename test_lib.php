<?php
include "wheel_lib.php";

$text  = "Nasi Lemak\nMee Goreng\n\n  Roti Canai  \nSatay";
$items = cleanItems($text);

echo "Items found: " . count($items) . "<br>";
for ($i = 0; $i < count($items); $i++)
{
    echo ($i + 1) . ". " . $items[$i] . " - " . getColor("ocean", $i) . "<br>";
}

$labels = array("sunset" => "Warm Sunset", "ocean" => "Cool Ocean", "candy" => "Pink Candy");
echo "<br>Theme ocean is called " . $labels["ocean"] . "<br><br>";

$n = 3;
do
{
    echo $n . "... ";
    $n--;
}
while ($n > 0);
echo "Spin!";
?>