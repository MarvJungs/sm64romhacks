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
	const pointsTable = document.getElementById('pojntsTable');
	if(!pointsTable) return;
	calc();
}

async function getAllRunnerData() {
	const response = await fetch("https://opensheet.elk.sh/14ja7ooTwjQzVkw-bjO3F8Xf2c21OLA0QU4vtPtfFpKQ/participants");
	const data = await response.json();
	var runners = new Map();
	data.forEach(element => {
		runners.set(element["speedrun.com name"].toLowerCase(), new Runners(
			element["GS 1 Star (v3.4)"] === "" ? "359999" : element["GS 1 Star (v3.4)"].replace(",", ""),
			element["GS 81 Star (v3.4)"] === "" ? "359999" : element["GS 81 Star (v3.4)"].replace(",", ""),
			element["GS 131 Star (v3.4)"] === "" ? "359999" : element["GS 131 Star (v3.4)"].replace(",", ""),
			element["MNE 70 Star"] === "" ? "359999" : element["MNE 70 Star"].replace(",", ""),
			element["MNE 125 Star"] === "" ? "359999" : element["MNE 125 Star"].replace(",", ""),
			element["ZAR 12 Ztar"] === "" ? "359999" : element["ZAR 12 Ztar"].replace(",", ""),
			element["ZAR 96 Ztar"] === "" ? "359999" : element["ZAR 96 Ztar"].replace(",", ""),
			element["ZAR 170 Ztar"] === "" ? "359999" : element["ZAR 170 Ztar"].replace(",", ""),
			element["discord name"],
			element["speedrun.com name"],
			element["Score"],
			element["Team"]))
	});
	runners = new Map([...runners.entries()].sort())
	runners.forEach(element => {
		document.getElementById("runners").innerHTML += "<option>" + element["src_name"] + "</option>";
	})
	return runners;
}

function generateText() {
	if (document.getElementById("runners").value != "Please Select A Runner") {
		for (let i = 0; i < 56; i += 7) {
			category = document.querySelectorAll("td")[i].innerHTML.toLowerCase()
			sortedMap = new Map([...sortedMap.entries()].sort((a, b) => Number(a[1][category]) - Number(b[1][category])))
			let name = document.getElementById("runners").value.toLowerCase()
			let rank = sortedMap.get(name)[category] === "359999" ? sortedMap.size : getRank(document.getElementById("runners").value)
			let rank0 = sortedMap.get(name)[category] === "359999" ? getRankByTime(getLastNonDefaultTime()) : rank - 1
			let selectContent = "<option selected>" + rank0 + "</option>"
			for (let i = rank0 - 1; i >= 0; i--) {
				selectContent = selectContent + "<option>" + i + "</option>"
			}
			document.getElementById(category + "_rank0").innerHTML = selectContent
			rank0 = Number(document.getElementById(category + "_rank0").value)
			document.getElementById(category + "_time1").innerHTML = getTime(sortedMap.get(name)[category])
			document.getElementById(category + "_time0").innerHTML = rank0 === 0 ? "None" : getTime(getTimeByRank(rank0))
			document.getElementById(category + "_rank1").innerHTML = rank

			document.getElementById(category + "_points1").innerHTML = document.getElementById(category + "_time1").innerHTML === "99:59:59" ? 0 : getPoints(rank, category)
			document.getElementById(category + "_points0").innerHTML = rank0 === 0 ? 0 : document.getElementById(category + "_time1").innerHTML === "99:59:59" ? getPoints(rank0, category) : getPoints(rank0, category) - getPoints(rank, category)


		}
		document.getElementById("total").innerHTML = getSumPoints(true).toString() + " / " + getTotalPossiblePoints()
		document.getElementById("total_gain").innerHTML = getSumPoints(false).toString() + " / " + (getTotalPossiblePoints() - getSumPoints(true))

	}
}

function getLastNonDefaultTime() {
	let lastTime = "359999"
	for (const x of sortedMap.keys()) {
		if (sortedMap.get(x)[category] === "359999") {
			return lastTime
		}
		lastTime = sortedMap.get(x)[category]

	}
}

function getRankByTime(timeInSeconds) {
	let i = 0
	for (const x of sortedMap.keys()) {
		i += 1
		if (sortedMap.get(x)[category] === timeInSeconds) {
			return i
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
		pointsField = document.querySelectorAll("[id*='points0']")
	}
	for (let i = 0; i < pointsField.length; i++) {
		points = points + Number(pointsField[i].innerHTML)
	}
	return points
}

function getRank(name) {
	let i = 0
	name = name.toLowerCase()
	for (const x of sortedMap.keys()) {
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
	if (Number(hour) < 10) {
		hour = "0" + hour
	}

	return hour + ":" + minute + ":" + second
}

function getBasePoints() {
	let points = new Map()
	let point = 1
	for (let i = sortedMap.size; i > 0; i--) {
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
	if (category === "gs1") return 0;
	if (category === "gs81") return 5;
	if (category === "gs131") return 15;
	if (category === "mne70") return 5;
	if (category === "mne125") return 10;
	if (category === "zar12") return 0;
	if (category === "zar96") return 5;
	if (category === "zar170") return 15;
}

function getPoints(rank, category) {
	return getBasePoints().get(rank) + getBonusPoints(category)
}

function getTotalPossiblePoints() {
	return getPoints(1, "gs1") + getPoints(1, "gs81") + getPoints(1, "gs131") + getPoints(1, "mne70") + getPoints(1, "mne125") + getPoints(1, "zar12") + getPoints(1, "zar96") + getPoints(1, "zar170")
}

function changeValues(cat) {
	category = cat
	let rank0 = Number(document.getElementById(category + "_rank0").value)
	let rank = Number(document.getElementById(category + "_rank1").innerHTML)
	sortedMap = new Map([...sortedMap.entries()].sort((a, b) => Number(a[1][category]) - Number(b[1][category])))
	document.getElementById(category + "_time0").innerHTML = rank0 === 0 ? "None" : getTime(getTimeByRank(rank0))
	document.getElementById(category + "_points0").innerHTML = rank0 === 0 ? 0 : document.getElementById(cat + "_time1").innerHTML === "99:59:59" ? getPoints(rank0, category) : getPoints(rank0, category) - getPoints(rank, category)
	document.getElementById("total_gain").innerHTML = getSumPoints(false).toString() + " / " + (getTotalPossiblePoints() - getSumPoints(true))


}

async function calc() {
	document.getElementById("runners").addEventListener("change", generateText)
	sortedMap = await getAllRunnerData()
	document.querySelectorAll("[id*='rank0']").forEach((element) => element.addEventListener("change", function () { changeValues(element.attributes["id"].value.replace("_rank0", "")) }))


	document.querySelectorAll("[id*='time1']").forEach((element) => element.innerHTML = "99:59:59")
	document.querySelectorAll("[id*='time0']").forEach((element) => element.innerHTML = "99:59:59")
	document.querySelectorAll("[id*='rank1']").forEach((element) => element.innerHTML = "104")
	document.querySelectorAll("[id*='rank0']").forEach((element) => element.innerHTML = "<option selected>103</option>")
	document.querySelectorAll("[id*='points1']").forEach((element) => element.innerHTML = "0")
	document.querySelectorAll("[id*='points0']").forEach((element) => element.innerHTML = "0")
	document.getElementById("total").innerHTML = "0 / " + getTotalPossiblePoints()
	document.getElementById("total_gain").innerHTML = "0 / " + getTotalPossiblePoints()
}