<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$hack_name = stripChars($_GET['hack_name']);
$hack_id = intval($_GET['hack_id']);

$twitch_handle = strtolower($_COOKIE['twitch_handle']);
$name = strtolower($_COOKIE['name']);
$authors_patch = strtolower(getPatchFromDatabase($pdo, $hack_id)[0]['authors']);
$authors_hack = strtolower(getHackFromDatabase($pdo, getURLEncodedName($hack_name))[0]['authors']);

$is_author = isUserAuthor($authors_patch) || isUserAuthor(($authors_hack));

//Only allow editing if: Only either the whole hack or a patch should be edited AND the user is the author OR an admin
if (strlen($hack_name) == 0 && $hack_id == 0 || strlen($hack_name) != 0 && $hack_id != 0 || !filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || (!$is_author && !in_array($_COOKIE['discord_id'], ADMIN_SITE))) {
    header("Location: /hacks");
    die();
}

if (sizeof($_POST) != 0) {
    $hack_description = stripChars($_POST['hack_description']);

    //Entire Hack gets edited
    if ($_POST['type'] == 'editHack') {
        //List all images
        $img_name = stripChars($hack_name);
        $img_name = str_replace(':', '_', $img_name);
        $images = (glob($_SERVER['DOCUMENT_ROOT'] . "/api/images/img_" . $img_name . "_*.{png,jpg}", GLOB_NOSORT | GLOB_BRACE));
        foreach ($images as $image) {
            $image = explode("/", $image)[sizeof(explode("/", $image)) - 1];
            $ext = substr($image, -3);
            $image = substr_replace($image, "", -4);

            //Delete the images whose checkboxes were not checked
            if (($_POST['hack_images_checked'] != null && !in_array($image, $_POST['hack_images_checked'])) || $_POST['hack_images_checked'] == null) {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/api/images/$image.$ext");
            }
            //Rename images if the hack name has been changed
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/images/$image.$ext")) {
                $new_image = str_replace($img_name, stripChars(stripChars($_POST['hack_new_name'])), $image);
                rename($_SERVER['DOCUMENT_ROOT'] . "/api/images/$image.$ext", $_SERVER['DOCUMENT_ROOT'] . "/api/images/$new_image.$ext");
            }
        }
        //Get data and update hack data
        $hack_old_name = stripChars($_POST['hack_old_name']);
        $hack_old_tags = getHackFromDatabase($pdo, getURLEncodedName($hack_old_name))[0]['hack_tags'];
        $hack_name = stripChars($_POST['hack_new_name']);
        $hack_url = getURLEncodedName($hack_name);
        $hack_description = str_replace("\r\n", "<br/>", $hack_description);
        $hack_description = stripChars($hack_description);
        $hack_description = str_replace("&lt;br/&gt;", "<br/>", $hack_description);
        $hack_tags = stripChars($_POST['hack_tags']);
        $hack_megapack = isset($_POST['hack_megapack']) ? 1 : 0;
        updateHackInDatabase($pdo, $hack_old_name, $hack_name, $hack_url, $hack_description, $hack_megapack);

        $hack_tags = explode(", ", $hack_tags);

        $hack = getHackFromDatabase($pdo, $hack_url);

        //Set hack_recommend flag to 1 if hack should be recommened (checkbox check)
        foreach ($hack as $entry) {
            unrecommendPatchFromDatabase($pdo, intval($entry['hack_id']));
            if (isset($_POST[$entry['hack_id']])) {
                recommendPatchFromDatabase($pdo, intval($entry['hack_id']));
            }
            $hack_id = $entry['hack_id'];
            //Set Tag Entries in Database
            deleteHackTagFromDatabase($pdo, $hack_id);
            foreach ($hack_tags as $tag) {
                if (!getTagFromDatabase($pdo, $tag)) addTagToDatabase($pdo, $tag);
                $tag_id = getTagFromDatabase($pdo, $tag)[0]['tag_id'];
                addHackTagToDatabase($pdo, $hack_id, $tag_id);
            }
        }

        //Delete those tags which had been overwritten
        $hack_old_tags = explode(", ", $hack_old_tags);
        foreach ($hack_old_tags as $tag) {
            if (getHacksByTagFromDatabase($pdo, $tag)[0]['count'] == 0) {
                deleteTagFromDatabase($pdo, $tag);
            }
        }

        //Interate through the uplaoded images and move them to the api/images folder
        for ($i = 0; $i < sizeof($_FILES['hack_images']['tmp_name']); $i++) {
            $image_name = $_FILES['hack_images']['name'][$i];
            $ext = pathinfo($_FILES['hack_images']['name'][$i], PATHINFO_EXTENSION);
            $tmp_name = $_FILES['hack_images']['tmp_name'][$i];

            $logo_result = move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . '/api/images/img_' . $img_name . "_" . uniqid() . ".$ext");
        }
    } else {
        //Get Patchdata
        $hack_name = stripChars($_POST['hack_name']);
        $hack_version = stripChars($_POST['hack_version']);
        $hack_author = stripChars($_POST['hack_author']);
        $hack_starcount = intval($_POST['hack_starcount']);
        $hack_release_date = $_POST['hack_release_date'];

        deleteHackAuthorFromDatabase($pdo, $hack_id);

        //Iterate through submitted list of authors, add them to the database if not exist
        $hack_authors = explode(", ", $hack_author);
        foreach ($hack_authors as $author) {
            $author_new_id = getAuthorFromDatabase($pdo, $author)[0]['author_id'];
            if (!$author_new_id) {
                addAuthorToDatabase($pdo, $author);
                $author_new_id = getAuthorFromDatabase($pdo, $author)[0]['author_id'];
            }
            addHackAuthorToDatabase($pdo, $hack_id, $author_new_id);
        }
        updatePatchInDatabase($pdo, $hack_id, $hack_name, $hack_version, $hack_starcount, $hack_release_date, 1);
    }

    header("Location: /hacks/" . getURLEncodedName($hack_name));
    die();
}

?>
<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
    <title>sm64romhacks - Edit Hack</title> <!--CHANGE TITLE-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
    <meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
    <link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="/_assets/_img/icon.ico" />
    <script src="editHack.js?t=<?php print(filemtime('editHack.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
        <div id="content" align="center">
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
    </div>
    </div>
</body>

</html>