<?php
$scripts = array(
    'vault/add-password.js',
    'vault/modify-password.js'
);

require './../globals.php';
require './../header.php';

$panda->lockdown();

$modify = null;
$modifyData = array(
    'SiteName' => '',
    'SiteUrl' => '',
    'Identifier1' => 'Email',
    'Identifier1String' => '',
    'Identifier2' => 'Username',
    'Identifier2String' => '',
    'Password' => '',
    'Comments' => ''
);

if (isset($_GET['modifyId'])) {
    $modifyId = addslashes($_GET['modifyId']);
    $uid = $panda->user['ID'];
    
    $getPasswordQ = $panda->db->prepare("SELECT * FROM `passwords` WHERE `ID`='$modifyId' AND `AccountID`='$uid'");
    $getPasswordQ->execute();

    if ($getPasswordQ->rowCount() > 0) {
        $modify = $getPasswordQ->fetch(PDO::FETCH_ASSOC);
        $modifyData['SiteName'] = $modify['SiteName'];
        $modifyData['SiteUrl'] = $modify['SiteUrl'];
        $modifyData['Identifier1'] = $modify['Identifier1'];
        $modifyData['Identifier1String'] = $modify['Identifier1String'];
        $modifyData['Identifier2'] = $modify['Identifier2'];
        $modifyData['Identifier2String'] = $modify['Identifier2String'];
        $modifyData['Password'] = $panda->decode(base64_decode($modify['Password']), base64_decode($modify['EncIv']), base64_decode($modify['EncTag']));
        $modifyData['Comments'] = $modify['Comments'];
    }
}
?>
<div class="container vault-add-password">
    <a href="./" class="btn btn-primary mb-4">Back to Vault</a>
    
    <?php
    $panda->errorHolder();
    ?>

    <div class="card mb-5">
        <div class="card-header">
            <?php
            if ($modify == null) {
                ?>
                <p class="mb-0">Add Password</p>
                <?php
            } else {
                ?>
                <p class="mb-0">Modify Password</p>
                <?php
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            if ($modify == null) {
                ?><form action="" method="post" id="add-password-form"><?php
            } else {
                ?><form action="" method="post" id="modify-password-form"><input hidden name="i_ID" type="text" value="<?php echo $modify['ID']; ?>" /><?php
            }

                $panda->form();
                ?>
                <label for="site_name" class="my-0">Site Name</label>
                <input type="text" name="i_site_name" class="form-control" id="site_name" value="<?php echo $modifyData['SiteName']; ?>" />
                
                <label for="site_url" class="mt-3 mb-0">Site Url</label>
                <input type="text" name="i_site_url" class="form-control" id="site_url" value="<?php echo $modifyData['SiteUrl']; ?>" />
                
                <label for="identifier1" class="mt-3 mb-0">Identifier - Value</label>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="i_identifier1" class="form-control" id="identifier1" value="<?php echo $modifyData['Identifier1']; ?>" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <input type="text" name="i_identifier1string" class="form-control" id="identifier1string" placeholder="me@mail.com" value="<?php echo $modifyData['Identifier1String']; ?>" />
                    </div>
                </div>
                
                <label for="identifier2" class="mt-3 mb-0">Identifier - Value</label>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="i_identifier2" class="form-control" id="identifier2" value="<?php echo $modifyData['Identifier2']; ?>" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <input type="text" name="i_identifier2string" class="form-control" id="identifier2string" placeholder="me" value="<?php echo $modifyData['Identifier2String']; ?>" />
                    </div>
                </div>
                
                <label for="password" class="mt-3 mb-0">Password <a href="#" class="generate-password p-0">[ Generate Random ]</a></label>
                <input type="password" name="i_password" class="form-control" id="password" value="<?php echo $modifyData['Password']; ?>" />

                <label for="comments" class="mt-3 mb-0">Comments</label>
                <textarea name="i_comments" class="form-control" id="comments" style="height: 160px;"><?php echo $modifyData['Comments']; ?></textarea>

                <?php
                if ($modify == null) {
                    ?>
                    <input type="submit" class="btn btn-success mt-3" value="Add Password" />
                    <?php
                } else {
                    ?>
                    <input type="submit" class="btn btn-success mt-3" value="Modify Password" />
                    <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>