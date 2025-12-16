<?php

$tab = [];
$ROWS = 25;
$COLS = 25;

function generateGrid($t, $r, $c)
{
    for ($i = 0; $i < $r; $i++) {
        $t[$i] = [];
        echo "<div class='row'>";

        for ($j = 0; $j < $c; $j++) {
            echo "<div class='cell' id='id$i-$j'></div>";
            $t[$i][$j] = "1";
        }
        echo "</div>";
    }
    return $t;
}

function fillGrid($t, $r, $c)
{
    for ($i = 0; $i < $r; $i++) {
        for ($j = 0; $j < $c; $j++) {
            if ($t[$i][$j] == "0") {
                echo "<style>#id$i-$j{background-color:white;}</style>";
            } else {
                echo "<style>#id$i-$j{background-color:black;}</style>";
            }
        }
    }
}

function generateMaze($t, $startR, $startC, $rows, $cols)
{
    $directions = [[-2, 0], [0, 2], [2, 0], [0, -2],];
    shuffle($directions);

    foreach ($directions as [$dr, $dc]) {
        $newR = $startR + $dr;
        $newC = $startC + $dc;

        if ($newR > 0 && $newR < $rows - 1 && $newC > 0 && $newC < $cols - 1 && $t[$newR][$newC] == 1) {
            $t[$startR + $dr / 2][$startC + $dc / 2] = 0;
            $t[$newR][$newC] = 0;
            $t = generateMaze($t, $newR, $newC, $rows, $cols);
        }
    }
    return $t;
}

if (!isset($_SESSION['maze'])) {
    $tab = generateGrid($tab, $ROWS, $COLS); 
    $tab[1][1] = 0;
    $tab = generateMaze($tab, 1, 1, $ROWS, $COLS);
    $_SESSION['maze'] = $tab;

    fillGrid($tab, $ROWS, $COLS);
} else {
    $tab = $_SESSION['maze'];

    for ($i = 0; $i < $ROWS; $i++) {
        echo "<div class='row'>";
        for ($j = 0; $j < $COLS; $j++) {
            echo "<div class='cell' id='id$i-$j'></div>";
        }
        echo "</div>";
    }

    fillGrid($tab, $ROWS, $COLS);
}
echo "<style>#id23-23{background-image:url('assets/img/souris.png');background-size:16px 16px;}</style>";


//echo "<script>console.log('" . json_encode($tab) . "')</script>";
