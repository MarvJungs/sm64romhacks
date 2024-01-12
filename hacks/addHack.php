<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

//Allow adding hacks only if logged in
if (!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN)) {
    header("Location: /404.php");
    die();
}

//Data from form is received
if (sizeof($_POST) != 0) {
    //Values from submitted data
    $hack_name = stripChars($_POST['hack_name']);
    $hack_url = getURLEncodedName($hack_name);
    $hack_version = stripChars($_POST['hack_version']);
    $hack_author = stripChars($_POST['hack_author']);
    $hack_starcount = isset($_POST['hack_amount']) ? intval($_POST['hack_amount']) : 0;
    $hack_release_date = $_POST['hack_release_date'];
    $hack_patchname = stripChars($_FILES['hack_patchname']["name"]);
    $hack_tags = "";
    $hack_description = "";

    $hack = getHackFromDatabase($pdo, $hack_url);
    //Hack already exists
    if ($hack) {
        //Get Tags and Description from Hack
        $hack_tags = $hack[0]['hack_tags'];
        $hack_description = $hack[0]['hack_description'];
        foreach ($hack as $entry) {
            //If database already has the same version or file, throw an error
            if ($entry['hack_version'] == $hack_version || $entry['hack_patchname'] == $hack_patchname) {
                header("Location: /404.php");
                die();
            }
        }
    }

    //If user is an admin, verify the patch immediately
    if (in_array($_COOKIE['discord_id'], ADMIN_SITE)) {
        $result = move_uploaded_file($_FILES['hack_patchname']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/patch/' . $hack_patchname);
        $hack_patchname = substr($hack_patchname, 0, -4);
        addHackToDatabase($pdo, $hack_name, $hack_url, $hack_version, $hack_starcount, $hack_release_date, $hack_patchname, $hack_description, 1, 0, 0);
    }

    //Else, patch gets put into a pending queue
    else {
        $result = move_uploaded_file($_FILES['hack_patchname']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/admin/' . $hack_patchname);
        $hack_patchname = substr($hack_patchname, 0, -4);
        addHackToDatabase($pdo, $hack_name, $hack_url, $hack_version, $hack_starcount, $hack_release_date, $hack_patchname, $hack_description, 0, 0, 0);
    }

    //Iterate through all hack authors and add them to the database if not exist
    $hack_authors = explode(", ", $hack_author);
    foreach ($hack_authors as $author) {
        $author_id = getAuthorFromDatabase($pdo, $author)[0]['author_id'];
        if (!$author_id) {
            addAuthorToDatabase($pdo, $author);
            $author_id = getAuthorFromDatabase($pdo, $author)[0]['author_id'];
        }
        $hack_id = getLastHackId($pdo)[0]['hack_id'];
        addHackAuthorToDatabase($pdo, $hack_id, $author_id);
    }

    //If picture upload went wrong, thtow error
    if (!$result) {
        header("Location: /404.php");
        die();
    }

    if (!$hack) {
        addHackTagToDatabase($pdo, getLastHackId($pdo)[0]['hack_id'], 1);
    }

    //Redirect
    header("Location: /hacks");
    die();
}

?>
<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
    <title>sm64romhacks - Add Hack</title> <!--CHANGE TITLE-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
    <meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
    <link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="/_assets/_img/icon.ico" />
    <script src="addHack.js?t=<?php print(filemtime('addHack.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
        <div align="center">
            <form action="#" method="post" enctype="multipart/form-data">
                <table class="table">
                    <tr>
                        <td>
                            <label for="hack_name" class="col-form-label text-nowrap">Hack Name:</label>
                        </td>
                        <td>
                            <input class="form-control" list="hack_name_options" name="hack_name" placeholder="Type to search..." required>
                            <datalist id="hack_name_options">
                            </datalist>
                        </td>
                        <td>
                            <label for="hack_version" class="col-form-label text-nowrap">Version:</label>
                        </td>
                        <td>
                            <input type="text" name="hack_version" class="form-control" required>
                        </td>
                        <td>
                            <label for="hack_author" class="col-form-label text-nowrap">Author:</label>
                        </td>
                        <td>
                            <input type="text" name="hack_author" class="form-control">
                            <small id="hack_author_help" class="form-text text-muted">Seperate multiple author with &quot;&lt;Name&gt;,&nbsp;&lt;Name&gt;&quot;</small>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="hack_amount" class="col-form-label text-nowrap">Starcount:</label>
                        </td>
                        <td>
                            <input type="number" name="hack_amount" class="form-control" min="0">
                        </td>
                        <td>
                            <label for="hack_release_date" class="col-form-label text-nowrap">Release Date:</label>
                        </td>
                        <td>
                            <input type="date" name="hack_release_date" class="form-control">
                        </td>
                        <td>
                            <label for="hack_patchname" class="col-form-label text-nowrap">Patchname:</label>
                        </td>
                        <td>
                            <input type="file" name="hack_patchname" class="form-control" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>&nbsp;</td>
                        <td colspan=2 class="text-center"><button type="submit" class="btn btn-secondary align-middle">Add Hack!</button></td>
                        <td colspan=2>&nbsp;</td>
                    </tr>
                </table>
            </form>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
    </div>
    </div>
</body>

</html>