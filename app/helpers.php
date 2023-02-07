<?php

function translations($json)
{
    if (!file_exists($json)) {
        return [];
    }
    return json_decode(file_get_contents($json), true);
}

function formatprice($price)
{
    $formatArray = explode(".", $price);
    if (sizeof($formatArray) > 1) {
        $formatArray[0] = (int)$formatArray[0] . '00';
        $formattedPrice = (int)$formatArray[0] + (int)$formatArray[1];
        return $formattedPrice;
    } else {
        $formattedPrice = $formatArray[0] . '00';
        return (int)$formattedPrice;
    }
}
