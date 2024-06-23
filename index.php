<?php
require "db.php";
header('Content-Type: application/json');

if (!empty($_GET['item1']) && !empty($_GET['item2'])) {

    $item1_name = (substr($_GET['item1'], 0, 5) === "item.") ? substr($_GET['item1'], 5) : $_GET['item1'];
    $item2_name = (substr($_GET['item2'], 0, 5) === "item.") ? substr($_GET['item2'], 5) : $_GET['item2'];

    /* *
     * REQUETE ID ITEM
     * */

        $sql = "SELECT * FROM item WHERE name = :item1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':item1' => $item1_name]);
        $item1 = $stmt->fetch();

        if (!$item1) {
            echo json_encode("err");
            die();
        }


        $sql = "SELECT * FROM item WHERE name = :item2";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':item2' => $item2_name]);
        $item2 = $stmt->fetch();

        if (!$item2) {
            echo json_encode("err");
            die();
        }

    /* *
     * FUSION
     * */

        if (!empty($_GET['tier'])){
            $sql = "SELECT * FROM fusion WHERE item1 = :item1 AND item2 = :item2 AND tier = :tier";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':item1' => $item1->id,':item2' => $item2->id, ':tier' => $_GET['tier']]);
        } else {
            $sql = "SELECT * FROM fusion WHERE item1 = :item1 AND item2 = :item2";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':item1' => $item1->id,':item2' => $item2->id]);
        }
        $fusion1 = $stmt->fetch();

        if (!$fusion1) {

            if (!empty($_GET['tier'])){
                $sql = "SELECT * FROM fusion WHERE item1 = :item1 AND item2 = :item2 AND tier = :tier";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':item2' => $item1->id,':item1' => $item2->id, ':tier' => $_GET['tier']]);
            } else {
                $sql = "SELECT * FROM fusion WHERE item1 = :item1 AND item2 = :item2";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':item2' => $item1->id,':item1' => $item2->id]);
            }
            $fusion2 = $stmt->fetch();

            if (!$fusion2){
                echo json_encode("err");
                die();
            } else {
                $fusion = $fusion2;
            }

        } else {
            $fusion = $fusion1;
        }

        $sql = "SELECT * FROM item WHERE id = :itemResult_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':itemResult_id' => $fusion->itemResult]);
        $itemResult = $stmt->fetch();

        if (!$itemResult) {
            echo json_encode("err");
            die();
        } else {
            if ($itemResult->customClass == 1 || $itemResult->customClass == 2) {
                
                if ($itemResult->className == "vanilla") {
                    echo json_encode("v" . $itemResult->tyroid);
                } else {
                    echo json_encode("c" . $itemResult->tyroid);
                }

            } else {
                echo json_encode($itemResult->tyroid);
            }
        }



} else {

    echo json_encode("err");

}