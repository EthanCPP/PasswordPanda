<?php
$scripts = array(
    'vault/index.js'
);

require './../globals.php';
require './../header.php';

include './../api/grap-favicon.php';
$panda->lockdown();
?>
<div class="container vault-index">
    <?php
    if (isset($_GET['verified'])) {
        $panda->message('success', 'Your email has been verified!');
    }
    ?>
    <a href="add-password.php" class="btn btn-primary">Add Password</a>

    <input type="text" id="search-q" class="form-control my-4" placeholder="Search .." />
    <?php
    $panda->form();

    // get all passwords
    $uid = $panda->user['ID'];
    $apiKey = $panda->user['ApiSecret'];

    $passwordsQ = $panda->db->prepare("SELECT * FROM `passwords` WHERE `AccountID`='$uid' ORDER BY `SiteName`");
    $passwordsQ->execute();

    $password_data = array();

    ?>
    <div class="passwords-list">
        <div class="row">
            <?php
            if ($passwordsQ->rowCount() > 0) {
                while ($password_item = $passwordsQ->fetch(PDO::FETCH_ASSOC)) {
                    $fav_path = '../assets/images/favicons/';

                    if ($password_item['FaviconName'] == '') {
                        $grap_favicon = array(
                            'URL' => $password_item['SiteUrl'],
                            'SAVE' => false
                        );
                        $fav_url = grap_favicon($grap_favicon);
                        $ext = explode(".", $fav_url);
                        $faviconName = hash('sha1', rand()) . '.' . $ext[count($ext) - 1];
                        copy($fav_url, '../assets/images/favicons/' . $faviconName);

                        $password_itemId = $password_item['ID'];
                        $updateQ = $panda->db->prepare("UPDATE `passwords` SET `FaviconName`='$faviconName' WHERE `ID`='$password_itemId'");
                        $updateQ->execute();

                        $fav_path .= $faviconName;
                    } else {
                        $fav_path .= $password_item['FaviconName'];
                    }
                    ?>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="card h-100" data-site-name="<?php echo $password_item['SiteName']; ?>">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-lg-auto pr-2 pb-0">
                                        <div class="d-flex h-100 align-items-center">
                                            <?php echo '<img class="favicon" src="'.$fav_path.'">'; ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-auto pb-0">
                                        <p class="pass-site"><?php echo $password_item['SiteName']; ?></p>
                                        <p class="pass-url"><a target="_blank" href="<?php echo $password_item['SiteUrl']; ?>"><?php echo $password_item['SiteUrl']; ?></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                if ($password_item['Identifier1'] != '' && $password_item['Identifier1String']) {
                                    ?>
                                    <strong><?php echo $password_item['Identifier1']; ?></strong>
                                    <?php echo $password_item['Identifier1String']; ?>
                                    <button class="password-copy" data-clipboard-text="<?php echo $password_item['Identifier1String']; ?>">[Copy]</button><br /><br />
                                    <?php
                                }
                                
                                if ($password_item['Identifier2'] != '' && $password_item['Identifier2String']) {
                                    ?>
                                    <strong><?php echo $password_item['Identifier2']; ?></strong>
                                    <?php echo $password_item['Identifier2String']; ?>
                                    <button class="password-copy" data-clipboard-text="<?php echo $password_item['Identifier2String']; ?>">[Copy]</button><br /><br />
                                    <?php
                                }
                                ?>
                                <strong>Password</strong>
                                <span class="password" data-id="<?php echo $password_item['ID']; ?>">
                                    <span class="password-polite">****</span>
                                    <span class="password-raw"><?php echo $panda->decode(base64_decode($password_item['Password']), base64_decode($password_item['EncIv']), base64_decode($password_item['EncTag'])); ?></span>
                                </span>
                                <button class="password-toggle" data-show-id="<?php echo $password_item['ID']; ?>">[Toggle]</button>
                                <button class="password-copy" data-clipboard-text="<?php echo $panda->decode(base64_decode($password_item['Password']), base64_decode($password_item['EncIv']), base64_decode($password_item['EncTag'])); ?>">[Copy]</button>

                                <?php
                                if ($password_item['Comments'] != '') {
                                    ?>
                                    <br /><br />
                                    <strong>Comments</strong><br />
                                    <pre class="mt-3"><?php echo $password_item['Comments']; ?></pre>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end w-100">
                                    <a class="btn btn-warning mr-2" href="./add-password.php?modifyId=<?php echo $password_item['ID']; ?>">Modify</a>
                                    <button class="password-delete btn btn-danger" data-delete-id="<?php echo $password_item['ID']; ?>">Delete Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>