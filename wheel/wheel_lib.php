<?php
// ---------- Part 1: helper functions ----------

// Turns the text from the textarea into a clean array of options
function cleanItems($text)
{
    $lines = explode("\n", $text);
    $items = array();
    for ($i = 0; $i < count($lines); $i++)
    {
        $line = trim($lines[$i]);
        if ($line != "")
        {
            $items[] = $line;
        }
    }
    return $items;
}

// Picks a slice colour from the theme's palette
function getColor($theme, $i)
{
    switch ($theme)
    {
        case "sunset":
            $palette = array("#ff7a45", "#ffb347", "#f25f5c", "#ffd166");
            break;
        case "ocean":
            $palette = array("#2fb8c9", "#4a7bd0", "#5ad1b5", "#8f98ee");
            break;
        default:
            $palette = array("#ff6fb5", "#8f98ee", "#ffd166", "#5ad1b5");
    }
    return $palette[$i % count($palette)];
}

// ---------- Part 2: drawing the wheel ----------

// Builds the CSS that paints the coloured slices
function buildGradient($items, $theme)
{
    $n = count($items);
    $slice = 360 / $n;
    $css = "";
    for ($i = 0; $i < $n; $i++)
    {
        $from = $i * $slice;
        $to   = ($i + 1) * $slice;
        if ($i > 0) { $css = $css . ", "; }
        $css = $css . getColor($theme, $i) . " " . $from . "deg " . $to . "deg";
    }
    return "conic-gradient(" . $css . ")";
}

// Prints the wheel. It spins to land on the slice number $winnerIndex
function drawWheel($items, $theme, $winnerIndex, $seconds)
{
    $n = count($items);
    $slice = 360 / $n;

    // five full turns, then stop with the winning slice under the pointer
    $angle = 360 * 5 + (360 - ($winnerIndex + 0.5) * $slice);

    echo '<div class="wheel-box">';
    echo '<div class="pointer"></div>';
    echo '<div class="wheel" style="background: ' . buildGradient($items, $theme)
         . '; --angle: ' . $angle . 'deg; --time: ' . $seconds . 's">';

    for ($i = 0; $i < $n; $i++)
    {
        $middle = ($i + 0.5) * $slice;
        echo '<div class="slice" style="transform: rotate(' . $middle . 'deg)">';
        echo '<span>' . htmlspecialchars($items[$i]) . '</span>';
        echo '</div>';
    }

    echo '</div></div>';
}