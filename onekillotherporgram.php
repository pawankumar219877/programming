<?php

/* 
 
100 people standing in a circle in an order 1 to 100. No. 1 has a sword. He kills the next person 
 (i.e. No. 2) and gives the sword to the next (i.e. No. 3). All people do the same until only 1 survives.
 Which number survives at the last? I want C++ program for this.*/

$a = [];
$totalDigit=100;
for ($i = 0; $i < $totalDigit; $i++) {
    $a[$i] = [
        "value" => $i + 1,
        "next" => ($i == ($totalDigit-1) ) ? 1 : ($i + 2),
        "killer" => ($i == 0) ? true : false
    ];
}

echo "<pre>";
//print_r($a);exit;

function resetIndices($arr) {
    $out = [];
    $j = 0;
    foreach ($arr as $key => $val) {
        $out[$j] = $val;
        $j++;
    }
    return $out;
}

function deleteNode($AerrayData, $deleteValue, $deleteIndex = '') {
    $arr = [];
    $i = 0;
    $deletedFirst = false;
    $killerSet = false;
    foreach ($AerrayData as $key => $val) {

        if ($val["value"] == $deleteValue) {
            //$arr[$key]
            if ($key == 0) {
                $deletedFirst = true;
            } else if ($key == (count($AerrayData) - 1)) {
                $newNodePrev = [
                    "value" => $AerrayData[($key - 1)]["value"],
                    "next" => $AerrayData[0]["value"],
                    "killer" => false];
                $arr[$i - 1] = $newNodePrev;
                $arr[0]["killer"] = true;

                $i++;
            } else {
                $newNodePrev = ["value" => $AerrayData[($key - 1)]["value"],
                    "next" => $AerrayData[($key + 1)]["value"],
                    "killer" => false];
                $arr[$i - 1] = $newNodePrev;
                $i++;
            }
            $killerSet = true;
        } else {

            if (($deletedFirst == true) && ($key == (count($AerrayData) - 1))) {
                $val["next"] = $AerrayData[1]["value"];

                // echo $val["next"];exit;
            }

            $val["killer"] = ($killerSet == true) ? $killerSet : false;
            $killerSet = false;
            $arr[$i] = $val;
            $i++;
        }
    }
    return $arr;
}

/**
 * 
 * @param type $inputarray
 * @return type
 */
function killerb($inputarray) {
    $newarr = $inputarray;
    foreach ($inputarray as $key => $val) {
        if ($key % 2 != 0) {
            $newarr = deleteNode($newarr, $key);
        }
    }
    return $newarr;
}

/**
 * 
 * @param type $dataArray
 * @return type
 */
function findNodeValueToBeDeleted($dataArray) {
    foreach ($dataArray as $key => $val) {
        if ($val["killer"] == true) {
            if ($key == (count($dataArray) - 1)) {
                return $dataArray[0]["value"];
            } else {
                return $dataArray[($key + 1)]["value"];
            }
        }
    }
}

function killIt($dataArray) {
    $nodeValueTBeDeleted = findNodeValueToBeDeleted($dataArray);
    $dataArray = deleteNode($dataArray, $nodeValueTBeDeleted);
    $dataArray = resetIndices($dataArray);
    if (count($dataArray) > 1) {
        $dataArray = killIt($dataArray);
    }
    return $dataArray;
}

$result = killIt($a);
print_r($result);
exit;
?>

