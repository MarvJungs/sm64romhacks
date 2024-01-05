<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/config.php');

$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASS;
$db = DB_NAME;

try {
	$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

function createUsersDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `users` (
			`discord_email` varchar(255) NULL,
			`discord_username` varchar(255) NOT NULL,
			`discord_id` varchar(255) NOT NULL,
			`discord_avatar` varchar(255) NULL,
			`twitch_handle` varchar(255) NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`discord_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
	if (!getUserFromDatabase($pdo, "0")) addUserToDatabase($pdo, "0", NULL, NULL, "Deleted User", NULL);
}

function addUserToDatabase($pdo, $discord_id, $discord_avatar, $discord_email, $discord_username, $twitch_handle) {
	$sql = "INSERT INTO users (discord_email,discord_username,discord_id,discord_avatar,twitch_handle) VALUES (:discord_email,:discord_username,:discord_id,:discord_avatar,:twitch_handle)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'discord_id' => $discord_id,
			'discord_avatar' => $discord_avatar,
			'discord_email' => $discord_email,
			'discord_username' => $discord_username,
			'twitch_handle' => $twitch_handle
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function updateUserInDatabase($pdo, $discord_id, $discord_avatar, $discord_email, $discord_username, $twitch_handle) {
	$sql = "UPDATE users SET
		discord_avatar = :discord_avatar,
		discord_email = :discord_email,
		discord_username = :discord_username,
		twitch_handle = :twitch_handle
		WHERE discord_id = :discord_id";

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'discord_avatar' => $discord_avatar,
			'discord_email' => $discord_email,
			'discord_username' => $discord_username,
			'twitch_handle' => $twitch_handle,
			'discord_id' => $discord_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}


function getUserFromDatabase($pdo, $discord_id) {
	$sql = "SELECT * FROM users WHERE discord_id=:discord_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'discord_id' => $discord_id,
		]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getUserByNameFromDatabase($pdo, $discord_username) {
	$sql = "SELECT * FROM users WHERE discord_username=:discord_username";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'discord_username' => $discord_username,
		]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteUserFromDatabase($pdo, $discord_id) {
	$sql = "DELETE FROM users WHERE discord_id = :discord_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'discord_id' => $discord_id
		]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		echo $e;
	}
}


function getAllUsersFromDatabase($pdo) {
	$sql = "SELECT * FROM users";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function createNewspostDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `news` (
			`post_id` int(11) NOT NULL AUTO_INCREMENT,
			`post_author` varchar(255) NOT NULL,
			`created_at` datetime NOT NULL,
			`edited_at` datetime NOT NULL,
			`post_title` tinytext NOT NULL,
			`post_text` longtext NOT NULL,
			PRIMARY KEY (`post_id`),
			CONSTRAINT fk_post_author FOREIGN KEY (post_author) REFERENCES users(discord_id)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function addNewspostToDatabase($pdo, $post_title, $post_text, $post_author) {
	$sql = "INSERT INTO news (post_title,post_text,post_author,created_at, edited_at) VALUES (:post_title,:post_text,:post_author,UTC_TIMESTAMP(),UTC_TIMESTAMP())";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'post_title' => $post_title,
			'post_text' => $post_text,
			'post_author' => $post_author,
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteNewspostFromDatabase($pdo, $post_id) {
	$sql = "DELETE FROM news WHERE post_id = :post_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'post_id' => $post_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function updateNewspostInDatabase($pdo, $post_id, $post_author, $post_title, $post_text) {
	$UTC_TIMESTAMP = "UTC_TIMESTAMP()";
	$sql = "UPDATE news SET
		post_author = :post_author,
		post_title = :post_title,
		post_text = :post_text,
		edited_at = $UTC_TIMESTAMP
		WHERE post_id = :post_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'post_author' => $post_author,
			'post_title' => $post_title,
			'post_text' => $post_text,
			'post_id' => $post_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}


function getNewspostFromDatabase($pdo, $post_id) {
	$sql = "SELECT * FROM news WHERE post_id=:post_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'post_id' => $post_id,
		]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getAllNewspostsFromDatabase($pdo) {
	$sql = "SELECT n.post_id, n.post_author, n.created_at, n.edited_at, n.post_title, n.post_text, u.discord_username, u.discord_avatar FROM news n
		LEFT JOIN users u ON (n.post_author = u.discord_id) 
		ORDER BY post_id desc";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function createHacksDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `hacks` (
			`hack_id` int(11) NOT NULL AUTO_INCREMENT,
			`hack_name` varchar(255) NOT NULL,
			`hack_url` varchar(255) NOT NULL,
			`hack_version` varchar(255) DEFAULT NULL,
			`hack_starcount` int(11) DEFAULT NULL,
			`hack_release_date` date DEFAULT NULL,
			`hack_patchname` varchar(255) NOT NULL,
			`hack_downloads` int(11) NOT NULL,
			`hack_description` text DEFAULT NULL,
			`hack_verified` tinyint(1) NOT NULL,
			`hack_recommend` tinyint(1) NOT NULL,
			`hack_megapack` tinyint(1) NOT NULL,
			PRIMARY KEY (`hack_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function createHackAuthorsDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `hacks_authors` ( 
				hack_id INT(11) NOT NULL, 
				author_id INT(11) NOT NULL, 
				CONSTRAINT fk_hack_id FOREIGN KEY (hack_id) REFERENCES hacks(hack_id),
				CONSTRAINT fk_author_id FOREIGN KEY (author_id) REFERENCES author(author_id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function createAuthorsDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `author` (
				author_id INT(11) NOT NULL AUTO_INCREMENT,
				author_name VARCHAR(255) NOT NULL,
				PRIMARY KEY(`author_id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function addHackToDatabase($pdo, $hack_name, $hack_url, $hack_version, $hack_starcount, $hack_release_date, $hack_patchname, $hack_description, $hack_verified, $hack_recommend, $hack_megapack) {
	$sql = "INSERT INTO hacks (hack_name,hack_url,hack_version,hack_starcount,hack_release_date,hack_patchname,hack_description,hack_verified,hack_recommend,hack_megapack) VALUES (:hack_name,:hack_url,:hack_version,:hack_starcount,:hack_release_date,:hack_patchname,:hack_description,:hack_verified,:hack_recommend,:hack_megapack)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_name' => $hack_name,
			'hack_url' => $hack_url,
			'hack_version' => $hack_version,
			'hack_starcount' => $hack_starcount,
			'hack_release_date' => $hack_release_date,
			'hack_patchname' => $hack_patchname,
			'hack_description' => $hack_description,
			'hack_verified' => $hack_verified,
			'hack_recommend' => $hack_recommend,
			'hack_megapack' => $hack_megapack
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function getAuthorFromDatabase($pdo, $author_name) {
	$sql = "SELECT * FROM author WHERE author_name=:author_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'author_name' => $author_name
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function addAuthorToDatabase($pdo, $author_name) {
	$sql = "INSERT INTO author (author_name) VALUES (:author_name)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'author_name' => $author_name
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function addHackAuthorToDatabase($pdo, $hack_id, $author_id) {
	$sql = "INSERT INTO hacks_authors (hack_id, author_id) VALUES (:hack_id,:author_id)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id,
			'author_id' => $author_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteHackAuthorFromDatabase($pdo, $hack_id) {
	$sql = "DELETE FROM hacks_authors WHERE hack_id=:hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function getAmountOfHacksInDatabase($pdo) {
	$sql = "SELECT COUNT(*) AS 'count' FROM hacks";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getHackFromDatabase($pdo, $hack_url) {
	$sql = "SELECT h.hack_id, h.hack_name, h.hack_url, h.hack_version, h.hack_starcount, h.hack_release_date, h.hack_patchname, h.hack_downloads, h.hack_description, h.hack_verified, h.hack_recommend, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS authors, GROUP_CONCAT(DISTINCT t.tag_name SEPARATOR ', ') AS hack_tags, h.hack_megapack  FROM hacks h 
		LEFT JOIN hacks_authors ha ON (h.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id) 
		LEFT JOIN hacks_tags ht ON (h.hack_id = ht.hack_id)
		LEFT JOIN tags t ON (ht.tag_id = t.tag_id)
		WHERE h.hack_url=:hack_url AND hack_verified=1
		GROUP BY h.hack_id
		ORDER BY h.hack_recommend DESC, CASE WHEN h.hack_release_date = '9999-12-31' THEN 2 ELSE 1 END, h.hack_release_date DESC";

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_url' => $hack_url
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getMegapackHacksFromDatabase($pdo) {
	$sql = "SELECT h1.hack_name, h1.hack_url, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS hack_author, h1.hack_starcount, h1.hack_release_date, t.tag_name AS hack_tags
		FROM hacks h1
		LEFT JOIN hacks h2 ON h1.hack_name = h2.hack_name AND h1.hack_release_date > h2.hack_release_date
		LEFT JOIN hacks_authors ha ON (h1.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id)
		LEFT JOIN hacks_tags ht ON (h1.hack_id = ht.hack_id)
		LEFT JOIN tags t ON (ht.tag_id = t.tag_id)
		WHERE h2.hack_release_date IS NULL AND h1.hack_megapack = 1 AND t.tag_name IN ('EASY', 'NORMAL', 'ADVANCED')
		GROUP BY h1.hack_name
		ORDER BY CASE t.tag_name
				WHEN 'EASY' THEN 1
				WHEN 'NORMAL' THEN 2
				WHEN 'ADVANCED' THEN 3
				ELSE 4
		END,
		h1.hack_name;";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getMegapackKaizoHacksFromDatabase($pdo) {
	$sql = "SELECT h1.hack_name, h1.hack_url, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS hack_author, h1.hack_starcount, h1.hack_release_date, t.tag_name AS hack_tags
		FROM hacks h1
		LEFT JOIN hacks h2 ON h1.hack_name = h2.hack_name AND h1.hack_release_date > h2.hack_release_date
		LEFT JOIN hacks_authors ha ON (h1.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id)
		LEFT JOIN hacks_tags ht ON (h1.hack_id = ht.hack_id)
		LEFT JOIN tags t ON (ht.tag_id = t.tag_id)
		WHERE h2.hack_release_date IS NULL AND h1.hack_megapack = 1 AND t.tag_name = 'KAIZO'
		GROUP BY h1.hack_name
		ORDER BY CASE t.tag_name
				WHEN 'KAIZO' THEN 1
				ELSE 2
		END,
		h1.hack_name;";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}


function getHacksByUserFromDatabase($pdo, $user_id) {
	$sql = "SELECT * FROM users u
		LEFT JOIN author a ON(u.discord_username=a.author_name or u.twitch_handle=a.author_name and u.twitch_handle <> null)
		LEFT JOIN hacks_authors ha ON(a.author_id=ha.author_id)
		LEFT JOIN hacks h ON(ha.hack_id=h.hack_id)
		WHERE discord_id=:user_id
		GROUP BY h.hack_name
		";

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'user_id' => $user_id
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getAllPendingHacksFromDatabase($pdo) {
	$sql = "SELECT h.hack_id, h.hack_name, h.hack_version, h.hack_starcount, h.hack_release_date FROM hacks h
		LEFT JOIN hacks_authors ha ON (h.hack_id = ha.hack_id)
		LEFT JOIN author a ON (ha.author_id = a.author_id) 
		WHERE hack_verified=0";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getLastHackId($pdo) {
	$sql = "SELECT h.hack_id FROM hacks h ORDER BY h.hack_id DESC LIMIT 1";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}


function getAllUniqueHacksFromDatabase($pdo) {
	$sql = "SELECT h1.hack_name, h1.hack_url, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS hack_author, GROUP_CONCAT(DISTINCT t.tag_name SEPARATOR ', ') AS hack_tags, h1.hack_release_date AS release_date, SUM(h1.hack_downloads) AS total_downloads, h1.hack_megapack FROM hacks h1 
		LEFT JOIN hacks h2 ON (h1.hack_name = h2.hack_name AND h1.hack_release_date > h2.hack_release_date)
		LEFT JOIN hacks_authors ha ON (h1.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id)
		LEFT JOIN users u ON (u.discord_username=a.author_name OR u.twitch_handle=a.author_name) 
		LEFT JOIN hacks_tags ht ON (h1.hack_id = ht.hack_id)
		LEFT JOIN tags t ON (ht.tag_id = t.tag_id)
		WHERE h1.hack_verified=1 AND h2.hack_release_date IS NULL
		GROUP BY h1.hack_name
		ORDER BY h1.hack_name;";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}


function getPatchFromDatabase($pdo, $hack_id) {
	$sql = "SELECT h.hack_id, h.hack_name, h.hack_version, h.hack_starcount, h.hack_release_date, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS authors, h.hack_patchname   FROM hacks h 
		LEFT JOIN hacks_authors ha ON (h.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id) 
		WHERE h.hack_id=:hack_id AND hack_verified=1";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function getPendingPatchFromDatabase($pdo, $hack_id) {
	$sql = "SELECT h.hack_id, h.hack_name, h.hack_version, h.hack_starcount, h.hack_release_date, GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS authors, h.hack_patchname   FROM hacks h 
		LEFT JOIN hacks_authors ha ON (h.hack_id = ha.hack_id) 
		LEFT JOIN author a ON (ha.author_id = a.author_id) 
		WHERE h.hack_id=:hack_id AND hack_verified=0";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}


function getRandomHackFromDatabase($pdo) {
	$sql = "SELECT * FROM hacks WHERE hack_verified=1 ORDER BY RAND() LIMIT 1";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function updatePatchInDatabase($pdo, $hack_id, $hack_name, $hack_version, $hack_starcount, $hack_release_date, $hack_verified) {
	$sql = "UPDATE hacks SET 
		hack_name = :hack_name,
		hack_version = :hack_version,
		hack_starcount = :hack_starcount,
		hack_release_date = :hack_release_date,
		hack_verified = :hack_verified
		WHERE hack_id = :hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_name' => $hack_name,
			'hack_version' => $hack_version,
			'hack_starcount' => $hack_starcount,
			'hack_release_date' => $hack_release_date,
			'hack_verified' => $hack_verified,
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function recommendPatchFromDatabase($pdo, $hack_id) {
	$sql = "UPDATE hacks SET hack_recommend = 1 WHERE hack_id = :hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function unrecommendPatchFromDatabase($pdo, $hack_id) {
	$sql = "UPDATE hacks SET hack_recommend = 0 WHERE hack_id = :hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function verifyPatchInDatabase($pdo, $hack_id) {
	$sql = "UPDATE hacks SET 
		hack_verified = 1
		WHERE hack_id = :hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function updateDownloadCounter($pdo, $hack_id) {
	$sql = "UPDATE hacks SET hack_downloads=hack_downloads+1 WHERE hack_id=:hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function updateHackInDatabase($pdo, $hack_old_name, $hack_new_name, $hack_url, $hack_description, $hack_megapack) {
	$sql = "UPDATE hacks SET 
						hack_name = :hack_new_name,
						hack_url = :hack_url,
						hack_description = :hack_description,
						hack_megapack = :hack_megapack
						WHERE hack_name = :hack_old_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_new_name' => $hack_new_name,
			'hack_url' => $hack_url,
			'hack_description' => $hack_description,
			'hack_old_name' => $hack_old_name,
			'hack_megapack' => $hack_megapack
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function getAllTagsFromDatabase($pdo) {
	$sql = "SELECT tag_name FROM tags WHERE tag_name <> \"\" ORDER BY tag_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteHackFromDatabase($pdo, $hack_name) {
	$sql = "DELETE FROM hacks WHERE hack_name = :hack_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_name' => $hack_name
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function deletePatchFromDatabase($pdo, $hack_id) {
	$sql = "DELETE FROM hacks WHERE hack_id = :hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function createTagsDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `tags` (
				tag_id INT(11) NOT NULL AUTO_INCREMENT,
				tag_name VARCHAR(255) NOT NULL,
				PRIMARY KEY(`tag_id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function addTagToDatabase($pdo, $tag_name) {
	$sql = "INSERT INTO tags (tag_name) VALUES (:tag_name)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'tag_name' => $tag_name
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function getTagFromDatabase($pdo, $tag_name) {
	$sql = "SELECT * FROM tags WHERE tag_name=:tag_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'tag_name' => $tag_name
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteTagFromDatabase($pdo, $tag_name) {
	$sql = "DELETE FROM tags WHERE tag_name=:tag_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'tag_name' => $tag_name
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function createHacksTagsDatabase($pdo) {
	$sql = "CREATE TABLE IF NOT EXISTS `hacks_tags` ( 
				hack_id INT(11) NOT NULL, 
				tag_id INT(11) NOT NULL, 
				CONSTRAINT fk_patch_id FOREIGN KEY (hack_id) REFERENCES hacks(hack_id),
				CONSTRAINT fk_tag_id FOREIGN KEY (tag_id) REFERENCES tags(tag_id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	} catch (Exception $e) {
		echo $e;
	}
}

function addHackTagToDatabase($pdo, $hack_id, $tag_id) {
	$sql = "INSERT INTO hacks_tags (hack_id, tag_id) VALUES (:hack_id,:tag_id)";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id,
			'tag_id' => $tag_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function deleteHackTagFromDatabase($pdo, $hack_id) {
	$sql = "DELETE FROM hacks_tags WHERE hack_id=:hack_id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'hack_id' => $hack_id
		]);
	} catch (Exception $e) {
		echo $e;
	}
}

function getHacksByTagFromDatabase($pdo, $tag_name) {
	$sql = "SELECT COUNT(*) AS count FROM hacks h 
		LEFT JOIN hacks_tags ht ON (h.hack_id = ht.hack_id)
		LEFT JOIN tags t ON (ht.tag_id = t.tag_id)
		WHERE hack_verified=1 AND t.tag_name = :tag_name";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'tag_name' => $tag_name
		]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	} catch (Exception $e) {
		echo $e;
	}
}
