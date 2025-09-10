<?php

function codeprint($param = [], $die = false)
{
    echo "<pre>";
    print_r($param);
    if($die) die;
}
    
function codeprintTable($paramArrays, $bool = false, $height = "100%")
{
    echo "<table border='1' >";
    echo "<tr style='overflow:auto;height: " . (!$bool ? '' : $height) . "'>";
    foreach ($paramArrays as $par) {
        echo "<td valign='top' style='min-width: 400px; padding-left: 50px;'>";
        codeprint($par, 0);
        echo "</td>";
    }
    echo "</tr>";
    echo "</table>";
    if ($bool)exit();
}