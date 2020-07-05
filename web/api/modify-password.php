<?php
define('API', 1);
require './../globals.php';

if ($panda->loggedIn) {
    if (isset($_POST['i_password']) && isset($_POST['i_ID'])) {
        $ID = addslashes($_POST['i_ID']);
        $uid = $panda->user['ID'];
    
        $getPasswordQ = $panda->db->prepare("SELECT * FROM `passwords` WHERE `ID`='$ID' AND `AccountID`='$uid'");
        $getPasswordQ->execute();

        if ($getPasswordQ->rowCount() > 0) {

            $site_name = '';
            $site_url = '';
            $comments = '';
            $identifier1 = '';
            $identifier1string = '';
            $identifier2 = '';
            $identifier2string = '';

            if (isset($_POST['i_site_name']))
                $site_name = addslashes(strip_tags($_POST['i_site_name']));

            if (isset($_POST['i_site_url']))
                $site_url = addslashes(strip_tags($_POST['i_site_url']));

            if (isset($_POST['i_comments']))
                $comments = addslashes(strip_tags($_POST['i_comments']));

            if (isset($_POST['i_identifier1']))
                $identifier1 = addslashes(strip_tags($_POST['i_identifier1']));

            if (isset($_POST['i_identifier1string']))
                $identifier1string = addslashes(strip_tags($_POST['i_identifier1string']));

            if (isset($_POST['i_identifier2']))
                $identifier2 = addslashes(strip_tags($_POST['i_identifier2']));

            if (isset($_POST['i_identifier2string']))
                $identifier2string = addslashes(strip_tags($_POST['i_identifier2string']));

            $encode_data = $panda->encode($_POST['i_password']);
            $encoded_pass = base64_encode($encode_data['encoded_string']);
            $encoded_iv = base64_encode($encode_data['iv']);
            $encoded_tag = base64_encode($encode_data['tag']);

            // update to database
            $uid = $panda->user['ID'];

            $updateQ = $panda->db->prepare("UPDATE `passwords` SET `Password`='$encoded_pass', `SiteName`='$site_name', `Comments`='$comments',
            `SiteUrl`='$site_url', `Identifier1`='$identifier1', `Identifier1String`='$identifier1string', `Identifier2`='$identifier2',
            `Identifier2String`='$identifier2string', `EncIv`='$encoded_iv', `EncTag`='$encoded_tag' WHERE `ID`='$ID'");
            $updateQ->execute();

            echo json_encode(array(
                'Result' => 'Success',
            ));

            die;
        }
    }
}