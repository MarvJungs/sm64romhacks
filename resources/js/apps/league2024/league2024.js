import Runners from "./runner";

document.addEventListener("DOMContentLoaded", main);

let category = "";
let sortedMap;

/**
 * @typedef Userdata
 * @property {string} user
 * @property {string} team
 * @property {int} points
*/

/**
 * @typedef Teamdata
 * @property {string} team
 * @property {int} points
*/

function main() {
	const rankPointsTable = document.getElementById('pointsTable2024');
	if (!rankPointsTable) return;
	calculateRankPoints();
	calculateTimePoints();
}

async function getAllRunnerData() {
	const response = await fetch("https://opensheet.elk.sh/1G8N0nYv4K11PlU2dIhUICQKzcj7MlhF5k0mg78fvqbY/participants");
	const data = await response.json();
	var runners = new Map();
	data.forEach(element => {
		runners.set(element["speedrun.com name"].toLowerCase(), new Runners(
			element["DL 150"] === "" ? "35999" : element["DL 150"].replace(",", ""),
			element["DL ABS"] === "" ? "35999" : element["DL ABS"].replace(",", ""),
			element["DL 80"] === "" ? "35999" : element["DL 80"].replace(",", ""),
			element["ZA2 90"] === "" ? "35999" : element["ZA2 90"].replace(",", ""),
			element["ZA2 Warpless"] === "" ? "35999" : element["ZA2 Warpless"].replace(",", ""),
			element["ZA2 ANY%"] === "" ? "35999" : element["ZA2 ANY%"].replace(",", ""),
			element["Eureka 100"] === "" ? "35999" : element["Eureka 100"].replace(",", ""),
			element["Eureka 60"] === "" ? "35999" : element["Eureka 60"].replace(",", ""),
			element["Eureka 5"] === "" ? "35999" : element["Eureka 5"].replace(",", ""),
			element["discord name"],
			element["speedrun.com name"],
			element["Score"],
			element["Team"]))
	});
	runners = new Map([...runners.entries()].sort())
	runners.forEach(element => {
		document.getElementById("runners").innerHTML += "<option value='" + element["src_name"] + "'>" + element["src_name"] + "</option>";
	})
	return runners;
}

function generateText() {
	const pointsTable = document.getElementById('pointsTable2024');
	const tablesRows = pointsTable.querySelectorAll('tr');
	if (document.getElementById("runners").value != "None") {
		Array.from(tablesRows).forEach((tableRow) => {
			category = tableRow.getAttribute('name')?.toLowerCase();
			if (!category) return;
			sortedMap = new Map([...sortedMap.entries()].sort((a, b) => Number(a[1][category]) - Number(b[1][category])));
			let name = document.getElementById("runners").value.toLowerCase()
			let rank = sortedMap.get(name)[category] === "35999" ? sortedMap.size : getRank(document.getElementById("runners").value)
			let rank0 = sortedMap.get(name)[category] === "35999" ? getRankByTime(getLastNonDefaultTime(), category) : rank - 1
			let selectContent = "<option selected>" + rank0 + "</option>";
			for (let i = rank0 - 1; i >= 0; i--) {
				selectContent = selectContent + "<option>" + i + "</option>"
			}
			document.getElementById(category + "_rank0").innerHTML = selectContent
			rank0 = Number(document.getElementById(category + "_rank0").value)
			document.getElementById(category + "_time1").innerHTML = getTime(sortedMap.get(name)[category]);
			document.getElementById(category + '_timePoints').innerText = getTimePoints(category, sortedMap.get(name)[category]);
			const timePointsContainer = document.getElementById(category + '_timePoints');
			const possibleTimePointsContainer = document.getElementById(category + '_possibleTimePoints');
			const seconds = sortedMap.get(name)[category];
			timePointsContainer.innerText = getTimePoints(category, seconds);
			possibleTimePointsContainer.innerText = rank0 === 0 ? 0 :  getTimePoints(category, getSeconds(getTime(getTimeByRank(rank0)))) - Number(timePointsContainer.innerText);
			
			document.getElementById(category + "_desiredTime").value = rank0 === 0 ? getTime(sortedMap.get(name)[category]) : getTime(getTimeByRank(rank0))
			document.getElementById(category + "_rank1").innerHTML = rank
			
			document.getElementById(category + "_points1").innerHTML = document.getElementById(category + "_time1").innerHTML === "9:59:59" ? 0 : getPoints(rank, category)
			document.getElementById(category + "_possibleRankPoints").innerHTML = rank0 === 0 ? 0 : document.getElementById(category + "_time1").innerHTML === "9:59:59" ? getPoints(rank0, category) : getPoints(rank0, category) - getPoints(rank, category)
			
			// document.getElementById(category + '_desiredTime').value = rank0 === 0 ? "0:00:00" : getTime(getTimeByRank(rank0))
		});

		document.getElementById("total_rankPoints").innerHTML = getSumPoints(true).toString() + " / " + getTotalPossiblePoints()
		document.getElementById("total_gain").innerHTML = getSumPoints(false).toString() + " / " + (getTotalPossiblePoints() - getSumPoints(true))
		getTotalTimePoints();
	}
}

function getLastNonDefaultTime() {
	let lastTime = "35999";
	const leaderboard = new Map([...sortedMap.entries()].sort((a, b) => {
		return Number(a[1][category]) > Number(b[1][category]) ? 1 : -1;
	}));
	for (const x of leaderboard.keys()) {
		if (leaderboard.get(x)[category] === "35999") {
			return lastTime;
		}
		lastTime = leaderboard.get(x)[category]
	}
	return '35999';
}

function getRankByTime(timeInSeconds, category) {
	let i = 0
	const leaderboard = new Map([...sortedMap.entries()].sort((a, b) => {
		return Number(a[1][category]) > Number(b[1][category]) ? 1 : -1;
	}));
	for (const x of leaderboard.keys()) {
		i += 1
		if (parseFloat(leaderboard.get(x)[category]) >= parseFloat(timeInSeconds)) {
			return i;
		}
	}
}

function getSumPoints(gain) {
	let points = 0
	let pointsField
	if (gain) {
		pointsField = document.querySelectorAll("[id*='points1']")
	}
	else {
		pointsField = document.querySelectorAll("[id*='possibleRankPoints']")
	}
	for (let i = 0; i < pointsField.length; i++) {
		points = points + Number(pointsField[i].innerHTML)
	}
	return points
}

function getRank(name) {
	let i = 0
	const leaderboard = new Map([...sortedMap.entries()].sort((a, b) => {
		return Number(a[1][category]) > Number(b[1][category]) ? 1 : -1;
	}));
	name = name.toLowerCase()
	for (const x of leaderboard.keys()) {
		i += 1;
		if (name === x) {
			return i
		}
	}
}

function getTimeByRank(rank) {
	let i = 1
	for (const [key, value] of sortedMap.entries()) {
		if (i != rank) {
			i++
		}
		else
			return value[category]
	}
}

function getTime(seconds) {
	let second = ((seconds % 60) | 0).toString()
	let minute = (seconds / 60)
	let hour = (minute / 60 | 0).toString()
	minute = (minute % 60 | 0).toString()

	if (Number(second) < 10) {
		second = "0" + second
	}
	if (Number(minute) < 10) {
		minute = "0" + minute
	}

	return hour + ":" + minute + ":" + second
}

function getBasePoints() {
	let points = new Map();
	let point = 1;
	for (let i = sortedMap.size + 1; i > 0; i--) {
		points.set(i, point)

		if (i < 7) {
			point = point + 3
		}
		else if (i < 12) {
			point = point + 2
		}
		else {
			point++
		}
	}
	return points
}

function getBonusPoints(category) {
	if (category === "eureka5") return 2;
	if (category === "eureka60") return 8;
	if (category === "eureka100") return 15;
	if (category === "dl80") return 10;
	if (category === "dlabs") return 10;
	if (category == "dl150") return 20;
	if (category === "za2any5") return 2;
	if (category === "za2warpless") return 5;
	if (category === "za290") return 10;
}

function getPoints(rank, category) {
	return getBasePoints().get(rank) + getBonusPoints(category);
}

function getTotalPossiblePoints() {
	return getPoints(1, "eureka5") + getPoints(1, "eureka60") + getPoints(1, "eureka100") + getPoints(1, "dl80") + getPoints(1, "dlabs") + getPoints(1, "dl150") + getPoints(1, "za2any5") + getPoints(1, "za2warpless") + getPoints(1, "za290")
}

function changeValues(cat) {
	category = cat
	let rank0 = Number(document.getElementById(category + "_rank0").value)
	let rank = Number(document.getElementById(category + "_rank1").innerHTML)
	sortedMap = new Map([...sortedMap.entries()].sort((a, b) => Number(a[1][category]) - Number(b[1][category])))
	document.getElementById(category + "_desiredTime").value = rank0 === 0 ? "None" : getTime(getTimeByRank(rank0))
	document.getElementById(category + "_possibleRankPoints").innerHTML = rank0 === 0 ? 0 : document.getElementById(cat + "_time1").innerHTML === "9:59:59" ? getPoints(rank0, category) : getPoints(rank0, category) - getPoints(rank, category);
	document.getElementById(category + "_possibleTimePoints").innerHTML = rank0 === 0 ? 0 : getTimePoints(category, getTimeByRank(rank0)) - getTimePoints(category, getTimeByRank(rank));
	document.getElementById("total_gain").innerHTML = getSumPoints(false).toString() + " / " + (getTotalPossiblePoints() - getSumPoints(true))
	getTotalTimePoints();
}

async function calculateRankPoints() {
	document.getElementById("runners").addEventListener("change", generateText)
	sortedMap = await getAllRunnerData()
	document.querySelectorAll("[id*='rank0']").forEach((element) => element.addEventListener("change", function () { changeValues(element.attributes["id"].value.replace("_rank0", "")) }))


	document.querySelectorAll("[id*='time1']").forEach((element) => element.innerHTML = "9:59:59")
	document.querySelectorAll("[id*='time0']").forEach((element) => element.innerHTML = "9:59:59")
	document.querySelectorAll("[id*='rank1']").forEach((element) => element.innerHTML = sortedMap.size)
	document.querySelectorAll("[id*='rank0']").forEach((element) => element.innerHTML = "<option selected>" + (sortedMap.size - 1) + "</option>")
	document.querySelectorAll("[id*='points1']").forEach((element) => element.innerHTML = "0")
	document.querySelectorAll("[id*='points0']").forEach((element) => element.innerHTML = "0")
	document.getElementById("total_rankPoints").innerHTML = "0 / " + getTotalPossiblePoints()
	document.getElementById("total_gain").innerHTML = "0 / " + getTotalPossiblePoints()
}

function calculateTimePoints() {
	const timePointsTable = document.getElementById('pointsTable2024');
	const tableRows = timePointsTable.querySelectorAll('tr');
	Array.from(tableRows).forEach((tableRow) => {
		const categoryName = tableRow.getAttribute('name')?.toLowerCase();
		if (!categoryName) return;
		const inputField = document.getElementById(categoryName + '_desiredTime');
		inputField.addEventListener('input', (inputEvent) => {
			const timeValue = inputEvent.target.value;
			const seconds = getSeconds(timeValue);
			if (timeValue.length != 7) return;
			const timePointsContainer = document.getElementById(categoryName + '_timePoints');
			const rankPointsContainer = document.getElementById(categoryName + '_points1');
			const possibleRankPointsContainer = document.getElementById(categoryName + '_possibleRankPoints');
			const possibleTimePointsContainer = document.getElementById(categoryName + '_possibleTimePoints');
			const rank = getRankByTime(seconds, categoryName);
			possibleTimePointsContainer.innerText =  getTimePoints(categoryName, seconds) - Number(timePointsContainer.innerText);
			possibleRankPointsContainer.innerText = getPoints(rank, categoryName) - Number(rankPointsContainer.innerText);
			document.getElementById("total_gain").innerHTML = getSumPoints(false).toString() + " / " + (getTotalPossiblePoints() - getSumPoints(true));
			getTotalTimePoints();
		});
	});
}

function getSeconds(timeString) {
	const hours = Number(timeString.substring(0, 1));
	const minutes = Number(timeString.substring(2, 4));
	const seconds = Number(timeString.substring(5));

	const totalSeconds = hours * 3600 + minutes * 60 + seconds;
	return totalSeconds;
}

function getTimePoints(categoryName, seconds) {
	const cutoff = Number(document.getElementById(categoryName + '_cutoff').innerText);
	const barrier = Number(document.getElementById(categoryName + '_barrier').innerText);
	const points = Number((cutoff - seconds) / barrier);
	if (seconds > cutoff) return 0;
	return Math.ceil(points);
}

function getTotalTimePoints() {
	const pointsTable = document.getElementById('pointsTable2024');

	const totalTimePointsContainer = document.getElementById('total_timePoints');
	const totalPointsContainer = document.getElementById('total_points');
	const totalPossibleTimePointsContainer = document.getElementById('total_possibleTimePoints');
	const totalPossiblePointsContainer = document.getElementById('total_possiblePoints');
	
	const rankPointFields = pointsTable.querySelectorAll('td.rankPoints');
	const timePointFields = pointsTable.querySelectorAll('td.timePoints');
	const totalPointFields = pointsTable.querySelectorAll('td.totalPoints');
	
	const possibleRankPointFields = pointsTable.querySelectorAll('td.possibleRankPoints');
	const possibleTimePointFields = pointsTable.querySelectorAll('td.possibleTimePoints');
	const totalPossiblePointFields = pointsTable.querySelectorAll('td.possibleTotalPoints');

	let totalPoints = 0;
	let totalPossiblePoints = 0;

	Array.from(timePointFields).forEach((pointField) => {
		const points = Number(pointField.innerText);
		totalPoints += points;
	});
	totalTimePointsContainer.innerText = totalPoints;

	totalPoints = 0;

	for(let i = 0; i < rankPointFields.length; i++) {
		const rankPoints = Number(rankPointFields[i].innerText);
		const timePoints = Number(timePointFields[i].innerText);
		totalPointFields[i].innerText = rankPoints + timePoints;

		const possibleRankPoints = Number(possibleRankPointFields[i].innerText);
		const possibleTimePoints = Number(possibleTimePointFields[i].innerText);
		totalPossiblePointFields[i].innerText = possibleRankPoints + possibleTimePoints;

		totalPoints += rankPoints + timePoints;
		totalPossiblePoints += possibleRankPoints + possibleTimePoints;
	}

	totalPointsContainer.innerText = totalPoints;
	totalPossiblePointsContainer.innerText = totalPossiblePoints;

	totalPoints = 0;

	Array.from(possibleTimePointFields).forEach((possibleTimePointField) => {
		totalPoints += Number(possibleTimePointField.innerText);
	});

	totalPossibleTimePointsContainer.innerText = totalPoints;
}