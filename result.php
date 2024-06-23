<?php
require "db.php";
header('Content-Type: application/json');

if (!empty($_GET['itemResult'])) {

    $itemResult_name = $_GET['itemResult'];

    /* *
     * REQUETE ID ITEM
     * */

    $sql = "SELECT * FROM item WHERE name = :itemResult";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':itemResult' => $itemResult_name]);
    $itemResult = $stmt->fetch();

    if (!$itemResult) {
        echo json_encode("err");
        die();
    }

    /* *
     * FUSION
     * */

    $sql = "SELECT * FROM fusion WHERE itemResult = :itemResult";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':itemResult' => $itemResult->id]);
    $fusionAll = $stmt->fetchAll();

    $newFusion = [];

    foreach($fusionAll as $fusion){


        /* *
         * REQUETE ID ITEM RESULT
         * */

        $sql = "SELECT * FROM item WHERE id = :itemResultID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':itemResultID' => $fusion->itemResult]);
        $itemResult = $stmt->fetch();

        if (!$itemResult) {
            echo json_encode("err");
            die();
        }

        /* *
         * REQUETE ID ITEM 1
         * */

        $sql = "SELECT * FROM item WHERE id = :item1ID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':item1ID' => $fusion->item1]);
        $item1 = $stmt->fetch();

        if (!$item1) {
            echo json_encode("err");
            die();
        }

        /* *
         * REQUETE ID ITEM 2
         * */

        $sql = "SELECT * FROM item WHERE id = :item2ID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':item2ID' => $fusion->item2]);
        $item2 = $stmt->fetch();

        if (!$item2) {
            echo json_encode("err");
            die();
        }


        if ($fusion->tier == 1){
            $itemFuel = "mercure_ingot";
        } else if ($fusion->tier == 2){
            $itemFuel = "sunstone_ingot";
        } else if ($fusion->tier == 3){
            $itemFuel = "ium_ingot";
        } else {
            echo json_encode("err");
            die();
        }


        $tempFusion = [
            "id" => $fusion->id,
            "tier" => $fusion->tier,
            "item1" => $item1->name,
            "item2" => $item2->name,
            "itemResult" => $itemResult->name,
            "itemFuel" => $itemFuel,
        ];

        $newFusion[] = $tempFusion;
    }

    echo json_encode($newFusion);





} else {

    echo json_encode("err");

}