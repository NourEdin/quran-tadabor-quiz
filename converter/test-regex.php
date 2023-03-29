<?php

$source = "There is a guy #hanging# on the tree";
$pattern = "/(#(.*)#)/";
$replacement = "<strong>$2</strong>";

$found = preg_match($pattern, $source, $matches);
$replaced = preg_replace($pattern, $replacement, $source);

var_dump($replaced);