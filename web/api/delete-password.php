<?php
define('API', 1);
require './../globals.php';

if ($panda->loggedIn) {
    if (isset($_POST['ID'])) {
        $uid = $panda->user['ID'];
        $id = addslashes($_POST['ID']);

        // get password
        $passwordQ = $panda->db->prepare("SELECT * FROM `passwords` WHERE `ID`='$id' AND `AccountID`='$uid'");
        $passwordQ->execute();

        if ($passwordQ->rowCount() > 0) {
            $deleteQ = $panda->db->prepare("DELETE FROM `passwords` WHERE `ID`='$id' AND `AccountID`='$uid'");
            $deleteQ->execute();

            echo json_encode(array(
                'Result' => 'Success'
            ));

            die;
        }
    }
}