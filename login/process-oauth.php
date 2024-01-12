<?php
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);


if (!isset($_GET['code'])) {
    echo 'no code';
    exit();
}

$discord_code = $_GET['code'];


$payload = [
    'code' => $discord_code,
    'client_id' => DISCORD_CLIENT_ID,
    'client_secret' => DISCORD_CLIENT_SECRET,
    'grant_type' => 'authorization_code',
    'redirect_uri' => DISCORD_REDIRECT_URI,
    'scope' => 'identify+email+connections',
];


$payload_string = http_build_query($payload);
$discord_token_url = "https://discordapp.com/api/oauth2/token";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $discord_token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);

if (!$result) {
    echo curl_error($ch);
}

$result = json_decode($result, true);
$access_token = $result['access_token'];


$discord_users_url = "https://discordapp.com/api/users/@me";
$discord_users_connections_url = "https://discordapp.com/api/users/@me/connections";
$header = array("Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded");


$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $discord_users_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

array_push($result, curl_exec($ch));

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $discord_users_connections_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

array_push($result, curl_exec($ch));

$userData = json_decode($result[0], true);

$twitch_username = getTwitchUserName(json_decode($result[1], true));

$user_data = getUserFromDatabase($pdo, $userData['id']);

if (!$user_data) {
    addUserToDatabase($pdo, $userData['id'], $userData['avatar'], $userData['email'], $userData['global_name'], $twitch_username);
} else {
    updateUserInDatabase($pdo, $userData['id'], $userData['avatar'], stripChars($userData['email']), stripChars($userData['global_name']), $twitch_username);
}

setcookie("logged_in", "true", time() + (86400 * 30), "/");
setcookie("discord_id", $userData['id'], time() + (86400 * 30), "/");
setcookie("name", stripChars($userData['username']), time() + (86400 * 30), "/");
setcookie("avatar", $userData['avatar'], time() + (86400 * 30), "/");
setcookie("email", stripChars($userData['email']), time() + (86400 * 30), "/");
setcookie("global_name", stripChars($userData['global_name']), time() + (86400 * 30), "/");
if ($twitch_username) setcookie("twitch_handle", $twitch_username, time() + (86400 * 30), "/");

header("Location: " . $_COOKIE['redirect']);
exit();



function getTwitchUserName($userData)
{

    foreach ($userData as $entry) {
        if ($entry['type'] == 'twitch') {
            return $entry['name'];
        }
    }
    return NULL;
}
