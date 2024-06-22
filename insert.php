<?php

require "db.php";
header('Content-Type: application/json');

//var_dump($_GET);

if (!empty($_GET["name"]) && !empty( $_GET["tyroid"]) && !empty($_GET["tier"]) && !empty($_GET["customClass"]) && !empty($_GET["version"])) {
    $name = $_GET["name"];
    $tyroid = $_GET["tyroid"];
    $tier = $_GET["tier"];
    $customClass = $_GET["customClass"];
    $version = $_GET["version"];
    $className = $_GET["className"];

    if ($tier == "1"){
        $tierDB = "1";
    } else if ($tier == "2") {
        $tierDB = "2";
    } else if ($tier == "3") {
        $tierDB = "3";
    } else if ($tier == "IUM") {
        $tierDB = "4";
    } else if ($tier == "FINAL") {
        $tierDB = "5";
    } else if ($tier == "6") {
        $tierDB = "6";
    } else {
        $tierDB = "6";
    }

    if ($version == "1") {
        $versionDB = "1";
    } else if($version == "3"){
        $versionDB = "2";
    } else if($version == "V" || $version == "v"){
        $versionDB = "3";
    } else if($version == "V1" || $version == "v1"){
        $versionDB = "4";
    } else if($version == "V3" || $version == "v3"){
        $versionDB = "5";
    } else if($version == "13"){
        $versionDB = "6";
    } else {
        $versionDB = "1";
    }

    if ($customClass == "zero") {
        $customClassDB = "0";
    } else {
        $customClassDB = $customClass;
    }

    if ($tyroid == "zero") {
        $tyroidDB = "0";
    } else {
        $tyroidDB = $tyroid;
    }

    $query = "INSERT INTO item (name, tyroid, tier, customClass, version, className) VALUES ('$name', '$tyroidDB', '$tierDB', '$customClassDB', '$versionDB', '$className')";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($mysqli);
    } else {
        echo 'Success: Query ran successfully.';
    }

} else {
    echo 'Error: Invalid parameters.';
}