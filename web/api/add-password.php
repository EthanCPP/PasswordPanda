<?php
define('API', 1);
require './../globals.php';

if ($panda->loggedIn) {
    if (isset($_POST['i_password'])) {
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

        // add to database
        $uid = $panda->user['ID'];

        $addQ = $panda->db->prepare("INSERT INTO `passwords` (`AccountID`, `Password`, `SiteName`, `Comments`, `SiteUrl`, `Identifier1`,
         `Identifier1String`, `Identifier2`, `Identifier2String`, `EncIv`, `EncTag`)
         VALUES ('$uid', '$encoded_pass', '$site_name', '$comments', '$site_url', '$identifier1', '$identifier1string', '$identifier2', '$identifier2string',
         '$encoded_iv', '$encoded_tag')");
        $addQ->execute();

        echo json_encode(array(
            'Result' => 'Success',
        ));

        die;
    }
}