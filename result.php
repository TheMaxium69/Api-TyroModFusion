<?php
require "db.php";
header('Content-Type: application/json');

if (!empty($_GET['itemResult'])) {

    $itemResult_name = $_GET['itemResult'];
    $reponse = [];

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


    $isFuel = "Non";
    if ($itemResult->tier == 1) {
        $newTier = "Tier 1";
    }
    if ($itemResult->tier == 2) {
        $newTier = "Tier 2";
    }
    if ($itemResult->tier == 3) {
        $newTier = "Tier 3";
    }
    if ($itemResult->tier == 4) {
        $newTier = "Tier IUM";
    }
    if ($itemResult->tier == 5) {
        $newTier = "Tier Final";
    }
    if ($itemResult->tier == 6) {
        $newTier = "No Fusion";
        if ($itemResult->name == "mercure_ingot" || $itemResult->name == "ium_ingot" || $itemResult->name == "sunstone_ingot") {
            $isFuel = "Oui";
        }
    }



    $sql = "SELECT * FROM version WHERE id = :idVersion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idVersion' => $itemResult->version]);
    $version = $stmt->fetch();

    $sql = "SELECT COUNT(*) as fusion_count FROM fusion WHERE itemResult = :idItem";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idItem' => $itemResult->id]);
    $count = $stmt->fetchAll();
    $fusionCount = $count[0]->fusion_count;




    $tempItem = [
      "id" => $itemResult->id,
      "tyroid" => $itemResult->tyroid,
      "name" => $itemResult->name,
      "tier" => $newTier,
      "version" => $version->name,
      "fusion_count" => $fusionCount,
      "isFuel" => $isFuel,
    ];

    $reponse[] = $tempItem;

    /* *
     * FUSION RESULT
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

    $reponse[] = $newFusion;

    /* *
     * FUSION IMPLICATION
     * */

    $fusionImplication = [];


    $sql = "SELECT * FROM fusion WHERE item1 = :itemResult OR item2 = :itemResult";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':itemResult' => $itemResult->id]);
    $fusionImplicationResult = $stmt->fetchAll();

    if (!empty($fusionImplicationResult)) {

        foreach($fusionImplicationResult as $fusionImplicationOne){

            /* *
             * REQUETE ID ITEM RESULT
             * */

            $sql = "SELECT * FROM item WHERE id = :itemResultID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':itemResultID' => $fusionImplicationOne->itemResult]);
            $itemResultImplication = $stmt->fetch();

            if (!$itemResultImplication) {
                echo json_encode("err");
                die();
            }

            /* *
             * REQUETE ID ITEM 1
             * */

            $sql = "SELECT * FROM item WHERE id = :item1ID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':item1ID' => $fusionImplicationOne->item1]);
            $item1Implication = $stmt->fetch();

            if (!$item1Implication) {
                echo json_encode("err");
                die();
            }

            /* *
             * REQUETE ID ITEM 2
             * */

            $sql = "SELECT * FROM item WHERE id = :item2ID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':item2ID' => $fusionImplicationOne->item2]);
            $item2Implication = $stmt->fetch();

            if (!$item2Implication) {
                echo json_encode("err");
                die();
            }


            if ($fusionImplicationOne->tier == 1){
                $itemFuel = "mercure_ingot";
            } else if ($fusionImplicationOne->tier == 2){
                $itemFuel = "sunstone_ingot";
            } else if ($fusionImplicationOne->tier == 3){
                $itemFuel = "ium_ingot";
            } else {
                echo json_encode("err");
                die();
            }

            $tempFusion2 = [
                "id" => $fusionImplicationOne->id,
                "tier" => $fusionImplicationOne->tier,
                "item1" => $item1Implication->name,
                "item2" => $item2Implication->name,
                "itemResult" => $itemResultImplication->name,
                "itemFuel" => $itemFuel,
            ];

            $fusionImplication[] = $tempFusion2;
        }

    }

    $reponse[] = $fusionImplication;





    echo json_encode($reponse);





} else {

    echo json_encode("err");

}