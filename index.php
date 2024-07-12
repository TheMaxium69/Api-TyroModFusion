<?php
require "db.php";
header('Content-Type: application/json');

if (!empty($_GET['item1']) && !empty($_GET['item2']) && !empty($_GET['tier']) && $_GET['tier'] != "final") {

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



} else if (
    !empty($_GET['tier']) && !empty($_GET['item0']) && !empty($_GET['item1']) && !empty($_GET['item2']) && !empty($_GET['item3']) && !empty($_GET['item4']) && !empty($_GET['item5']) && !empty($_GET['item6']) && !empty($_GET['item7']) && !empty($_GET['item8']) && !empty($_GET['item9']) && !empty($_GET['item10']) && !empty($_GET['item11']) && !empty($_GET['item12']) && !empty($_GET['item13']) && !empty($_GET['item14']) && !empty($_GET['item15']) && !empty($_GET['item16']) && !empty($_GET['item17']) && !empty($_GET['item18']) && !empty($_GET['item19']) && !empty($_GET['item20']) && !empty($_GET['item21']) && !empty($_GET['item22']) && !empty($_GET['item23']) && !empty($_GET['item24']) && !empty($_GET['item25']) && !empty($_GET['item26']) && !empty($_GET['item27']) && !empty($_GET['item28']) && !empty($_GET['item29'])
) {

    $tier = $_GET['tier'];
    $item0 = $_GET['item0'];
    $item1 = $_GET['item1'];
    $item2 = $_GET['item2'];
    $item3 = $_GET['item3'];
    $item4 = $_GET['item4'];
    $item5 = $_GET['item5'];
    $item6 = $_GET['item6'];
    $item7 = $_GET['item7'];
    $item8 = $_GET['item8'];
    $item9 = $_GET['item9'];
    $item10 = $_GET['item10'];
    $item11 = $_GET['item11'];
    $item12 = $_GET['item12'];
    $item13 = $_GET['item13'];
    $item14 = $_GET['item14'];
    $item15 = $_GET['item15'];
    $item16 = $_GET['item16'];
    $item17 = $_GET['item17'];
    $item18 = $_GET['item18'];
    $item19 = $_GET['item19'];
    $item20 = $_GET['item20'];
    $item21 = $_GET['item21'];
    $item22 = $_GET['item22'];
    $item23 = $_GET['item23'];
    $item24 = $_GET['item24'];
    $item25 = $_GET['item25'];
    $item26 = $_GET['item26'];
    $item27 = $_GET['item27'];
    $item28 = $_GET['item28'];
    $item29 = $_GET['item29'];


    if ($tier == "final" &&
        $item0 == "item.adamantium_ingot" &&
        $item1 == "item.aventurium_ingot" &&
        $item2 == "item.chromitium_ingot" &&
        $item3 == "item.copperium_gem" &&
        $item4 == "item.coranium_ingot" &&
        $item5 == "item.draconium_ingot" &&
        $item6 == "item.enderium" &&
        $item7 == "item.goldonium" &&
        $item8 == "item.macronium_ingot" &&
        $item9 == "item.mercurium" &&
        $item10 == "item.netherium_ingot" &&
        $item11 == "item.obsidium_ingot" &&
        $item12 == "item.omeganium_ingot" &&
        $item13 == "item.platinium" &&
        $item14 == "item.plutonium_ingot" &&
        $item15 == "item.polonium_ingot" &&
        $item16 == "item.protonium_ingot" &&
        $item17 == "item.rhodonium_ingot" &&
        $item18 == "item.ritonium_ingot" &&
        $item19 == "item.sapphirium" &&
        $item20 == "item.silicium" &&
        $item21 == "item.silverium_ingot" &&
        $item22 == "item.steelium_ingot" &&
        $item23 == "item.thyrium" &&
        $item24 == "item.titanium_ingot" &&
        $item25 == "item.tyrolium" &&
        $item26 == "item.uranium_ingot" &&
        $item27 == "item.vaporium_ingot" &&
        $item28 == "item.volcanium_ingot" &&
        $item29 == "item.yellorium"
    ) {

        $sql = "SELECT * FROM item WHERE id = :ultium_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ultium_id' => "2692"]);
        $itemUltium = $stmt->fetch();


        if (!$itemUltium) {
            echo json_encode("err");
            die();
        } else {
            if ($itemUltium->customClass == 1 || $itemUltium->customClass == 2) {

                if ($itemUltium->className == "vanilla") {
                    echo json_encode("v" . $itemUltium->tyroid);
                } else {
                    echo json_encode("c" . $itemUltium->tyroid);
                }

            } else {
                echo json_encode($itemUltium->tyroid);
            }
        }

    } else {
        echo json_encode("err");
    }

} else {
    echo json_encode("err");
}