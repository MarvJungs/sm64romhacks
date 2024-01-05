<?php
function getClient_id() {
	return "7xxy8kh0hvswrrnnpzjpej41h5qxzz";
}

function getClient_secret() {
	return "26i3l38b88g131htepkjbn8t9rolon";
}

function getNames() {
	return array(
		"Evening_Grace",
		"SigotuSR",
		"SheepSquared",
		"aglab2",
		"RedSlim",
		"Mintynate",
		"Cordbreadsnake",
		"Lahmus",
		"ItsMalexTime",
		"matgeo_",
		"nzjg",
		"The_Second_Try",
		"RisingPhoenix64",
		"SomeBroYouDOntKnow",
		"luvbaseball58",
		"amsixx",
		"Authenticbrine",
		"iamdolphino",
		"Forever_Park",
		"bigfoottouchedme",
		"conichan239",
		"Milasus",
		"Ian_1243",
		"serium__",
		"okamibw",
		"Neo_Is_Me",
		"Jalapinecone",
		"GHDEVIL666",
		"KingToad74EE",
		"Montyvr",
		"sodiumclorideic",
		"AndrewSM64",
		"xviper33",
		"ZenonX_Dest",
		"AussieAdam",
		"submarinecpt",
		"squilliumfancyshot",
		"Jtsdogg0629",
		"aJames_30",
		"Muimania",
		"VitaBlue",
		"themrdoggo",
		"rynnoo64",
		"DNVIC",
		"Tomatobird8",
		"Dackage_",
		"GMDDoesDMG",
		"Kiruuaa__",
		"Pikamu",
		"Epsilon102",
		"wes_dogg",
		"xein64",
		"max954",
		"TheReverserOfTime",
		"DarkMan_",
		"wookissr",
		"PKSMG2",
		"zaikenator",
		"itsbeeve",
		"serpals",
		"Nascar316",
		"SimpleFlips",
		"NitroXNateYT",
		"alex7456",
		"Altaria26",
		"Edgar3EEE",
		"DJ_Tala0",
		"partitionpenguin",
		"LinCrash",
		"Zans64",
		"ChiaraSM64",
		"madware_",
		"Prakxoelpatatita",
		"TeddaySR",
		"maf1sss1",
		"luisitocnvs",
		"Bryce_Jormungandr",
		"mr_zebra776",
		"Falling_Tacos",
		"eldeve",
		"carlitos64_",
		"leopatic",
		"vandemiere",
		"PegiTheLoca",
		"InfiniteVoid316",
		"InkstarLum",
		"CapruSin",
		"anvarmora",
		"BJCMD",
		"Kudo64_",
		"BondsTowardTheFuture",
	);
	//return file("names.txt");
}

function getEndPoint() {
	$names = getNames();
	$endPoint = "";
	foreach ($names as $name) {
		$endPoint = $endPoint . "user_login=" . $name . "&";
	}
	return "https://api.twitch.tv/helix/streams?" . $endPoint;
}

function getTwitchAuthorization() {
	$endPoint = " ";
	$data = "client_id=" . getClient_id() . "&client_secret=" . getClient_secret() . "&grant_type=client_credentials";
	$link = "https://id.twitch.tv/oauth2/token?" . $data;

	// Request cURL POST pour get le token
	$ch = curl_init($link);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	$res = curl_exec($ch);
	curl_close($ch);

	// Decode
	$token = json_decode($res);
	return $token;
}

function getStreams() {
	$endPoint = getEndPoint();
	$authorizationObject = getTwitchAuthorization();
	$authorizationObject = json_decode(json_encode($authorizationObject), true);
	$access_token = $authorizationObject["access_token"];
	$expires_in = $authorizationObject["expires_in"];
	$token_type = $authorizationObject["token_type"];

	$token_type = strtoupper(substr($token_type, 0, 1)) . substr($token_type, 1, strlen($token_type));

	$authorization = $token_type . " " . $access_token;
	$header = array("Authorization: " . $authorization, "Client-ID: " . getClient_id());

	$ch = curl_init($endPoint);

	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


	$res = curl_exec($ch);
	curl_close($ch);

	// Decode
	$data =  json_decode($res);
	return $data->data;
}

function renderStreams($streams) {
	print("<div class=\"streams\">");
	if (sizeof($streams) == 0) {
		print("<div></div><div>Currently Nobody is streaming!</div>");
	}
	foreach ($streams as $stream) {
		$thumbnail = $stream->thumbnail_url;
		$thumbnail = str_replace("{width}", 1280, $thumbnail);
		$thumbnail = str_replace("{height}", 720, $thumbnail);
		$title = $stream->title;
		$title = str_replace("<", "&lt;", $title);
		$title = str_replace(">", "&gt;", $title);
		$viewer_count = $stream->viewer_count;
		$user_name = $stream->user_name;
		$user_login = $stream->user_login;

		$content = '<div class="stream-container">
			<a href="https://www.twitch.tv/' . $user_login . '"' . 'target="_blank_"><img src=' . $thumbnail . '/></a>
			<h2>' . $title . '</h2>
			<h2>' . $user_name . '</h2>
			<p>
				<!--<svg
					viewBox="0 0 15 15"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
					width="15"
					height="15"
					>
					<path
						d="M.5 7.5l-.464-.186a.5.5 0 000 .372L.5 7.5zm14 0l.464.186a.5.5 0 000-.372L14.5 7.5zm-7 4.5c-2.314 0-3.939-1.152-5.003-2.334a9.368 9.368 0 01-1.449-2.164 5.065 5.065 0 01-.08-.18l-.004-.007v-.001L.5 7.5l-.464.186v.002l.003.004a2.107 2.107 0 00.026.063l.078.173a10.368 10.368 0 001.61 2.406C2.94 11.652 4.814 13 7.5 13v-1zm-7-4.5l.464.186.004-.008a2.62 2.62 0 01.08-.18 9.368 9.368 0 011.449-2.164C3.56 4.152 5.186 3 7.5 3V2C4.814 2 2.939 3.348 1.753 4.666a10.367 10.367 0 00-1.61 2.406 6.05 6.05 0 00-.104.236l-.002.004v.001H.035L.5 7.5zm7-4.5c2.314 0 3.939 1.152 5.003 2.334a9.37 9.37 0 011.449 2.164 4.705 4.705 0 01.08.18l.004.007v.001L14.5 7.5l.464-.186v-.002l-.003-.004a.656.656 0 00-.026-.063 9.094 9.094 0 00-.39-.773 10.365 10.365 0 00-1.298-1.806C12.06 3.348 10.186 2 7.5 2v1zm7 4.5a68.887 68.887 0 01-.464-.186l-.003.008-.015.035-.066.145a9.37 9.37 0 01-1.449 2.164C11.44 10.848 9.814 12 7.5 12v1c2.686 0 4.561-1.348 5.747-2.665a10.366 10.366 0 001.61-2.407 6.164 6.164 0 00.104-.236l.002-.004v-.001h.001L14.5 7.5zM7.5 9A1.5 1.5 0 016 7.5H5A2.5 2.5 0 007.5 10V9zM9 7.5A1.5 1.5 0 017.5 9v1A2.5 2.5 0 0010 7.5H9zM7.5 6A1.5 1.5 0 019 7.5h1A2.5 2.5 0 007.5 5v1zm0-1A2.5 2.5 0 005 7.5h1A1.5 1.5 0 017.5 6V5z"
						fill="currentColor"
						></path>
					</svg>-->' .
			//preg_replace("/\B(?=(\d{3})+(?!\d))/",",",$viewer_count). '
			'</p>
			</div>';
		print($content);
	}
	print("</div>");
}

renderStreams(getStreams());
