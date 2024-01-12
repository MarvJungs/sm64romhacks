<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);

function getEndPoint()
{
	$endPoint = "game_id=2692&first=100";
	return "https://api.twitch.tv/helix/streams?" . $endPoint;
}

function getTwitchAuthorization()
{
	$endPoint = " ";
	$data = "client_id=" . TWITCH_CLIENT_ID . "&client_secret=" . TWITCH_CLIENT_SECRET . "&grant_type=client_credentials";
	$link = "https://id.twitch.tv/oauth2/token?" . $data;

	// Request cURL POST pour get le token
	$ch = curl_init($link);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$res = curl_exec($ch);
	curl_close($ch);

	// Decode
	$token = json_decode($res);
	return $token;
}

function getStreams()
{
	$endPoint = getEndPoint();
	$authorizationObject = getTwitchAuthorization();
	$authorizationObject = json_decode(json_encode($authorizationObject), true);
	$access_token = $authorizationObject["access_token"];
	$expires_in = $authorizationObject["expires_in"];
	$token_type = $authorizationObject["token_type"];

	$token_type = strtoupper(substr($token_type, 0, 1)) . substr($token_type, 1, strlen($token_type));

	$authorization = $token_type . " " . $access_token;
	$header = array("Authorization: " . $authorization, "Client-ID: " . TWITCH_CLIENT_ID);

	$ch = curl_init($endPoint);

	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


	$res = curl_exec($ch);
	curl_close($ch);

	// Decode
	$data =  json_decode($res);
	return $data->data;
}

print(json_encode(getStreams()));
