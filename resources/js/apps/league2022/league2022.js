import PointsTable from "./pointsTable";

document.addEventListener("DOMContentLoaded", calc);

const pointsMultiplier = new Array(0, 0.03, 0.05, 0.07, 0.09, 0.11, 0.14, 0.17, 0.35, 1.5);

const starRoad20CutOffs = new Array("0:25:00", "0:21:00", "0:18:00", "0:15:30", "0:14:00", "0:13:00", "0:12:30", "0:12:00", "0:11:30", "0:00:00");
const starRoad20Weight = 10000;
const starRoad20Table = new PointsTable(starRoad20CutOffs, pointsMultiplier, starRoad20Weight);

const starRoad80CutOffs = new Array("1:30:00", "1:20:00", "1:13:00", "1:07:00", "1:02:00", "0:58:00", "0:54:30", "0:52:00", "0:51:00", "0:00:00");
const starRoad80Weight = 18000;
const starRoad80Table = new PointsTable(starRoad80CutOffs, pointsMultiplier, starRoad80Weight);

const starRoad130Cutoffs = new Array("2:45:00", "2:30:00", "2:18:00", "2:07:00", "1:58:00", "1:50:00", "1:47:00", "1:45:00", "1:44:00", "0:00:00");
const starRoad130Weight = 23000;
const starRoad130Table = new PointsTable(starRoad130Cutoffs, pointsMultiplier, starRoad130Weight);

const sm74_10CutOffs = new Array("0:25:00", "0:20:00", "0:17:30", "0:15:30", "0:13:45", "0:12:15", "0:11:00", "0:10:00", "0:08:50", "0:00:00");
const sm74_10Weight = 7000;
const sm74_10Table = new PointsTable(sm74_10CutOffs, pointsMultiplier, sm74_10Weight);

const sm74_50CutOffs = new Array("1:00:00", "0:50:00", "0:42:00", "0:37:30", "0:34:15", "0:31:40", "0:29:30", "0:28:30", "0:27:45", "0:00:00");
const sm74_50Weight = 10000;
const sm74_50Table = new PointsTable(sm74_50CutOffs, pointsMultiplier, sm74_50Weight);

const sm74_110CutOffs = new Array("2:05:00", "1:52:00", "1:40:00", "1:32:00", "1:25:00", "1:19:00", "1:14:00", "1:10:00", "1:08:00", "0:00:00");
const sm74_110Weight = 15000;
const sm74_110Table = new PointsTable(sm74_110CutOffs, pointsMultiplier, sm74_110Weight);

const sm74_151CutOffs = new Array("4:00:00", "3:05:00", "2:48:00", "2:36:00", "2:26:00", "2:17:00", "2:09:00", "2:02:30", "2:00:00", "0:00:00");
const sm74_151Weight = 21000;
const sm74_151Table = new PointsTable(sm74_151CutOffs, pointsMultiplier, sm74_151Weight);

const dmg0CutOffs = new Array("0:08:30", "0:07:40", "0:06:55", "0:06:15", "0:05:40", "0:05:10", "0:04:45", "0:04:25", "0:04:10", "0:00:00");
const dmg0Weight = 8000;
const dmg0Table = new PointsTable(dmg0CutOffs, pointsMultiplier, dmg0Weight);

const dmg53CutOffs = new Array("0:50:00", "0:45:30", "0:42:00", "0:39:15", "0:36:30", "0:34:15", "0:32:45", "0:31:45", "0:31:00", "0:00:00");
const dmg53Weight = 13000;
const dmg53Table = new PointsTable(dmg53CutOffs, pointsMultiplier, dmg53Weight);

const dmg120CutOffs = new Array("2:10:00", "2:00:00", "1:52:00", "1:45:00", "1:40:00", "1:36:30", "1:33:30", "1:31:00", "1:29:00", "0:00:00");
const dmg120Weight = 22000;
const dmg120Table = new PointsTable(dmg120CutOffs, pointsMultiplier, dmg120Weight);

const ldd51CutOffs = new Array("0:52:00", "0:45:00", "0:40:00", "0:36:00", "0:33:00", "0:30:30", "0:28:30", "0:27:00", "0:25:45", "0:00:00");
const ldd51Weight = 13000;
const ldd51Table = new PointsTable(ldd51CutOffs, pointsMultiplier, ldd51Weight);

const ldd74CutOffs = new Array("1:15:00", "1:09:00", "1:03:00", "0:58:00", "0:53:00", "0:49:00", "0:47:00", "0:45:00", "0:43:00", "0:00:00");
const ldd74Weight = 18000;
const ldd74Table = new PointsTable(ldd74CutOffs, pointsMultiplier, ldd74Weight);

const ttm16CutOffs = new Array("0:30:30", "0:27:15", "0:24:15", "0:21:45", "0:20:15", "0:19:00", "0:18:00", "0:17:15", "0:16:45", "0:00:00");
const ttm16Weight = 9000;
const ttm16Table = new PointsTable(ttm16CutOffs, pointsMultiplier, ttm16Weight);

const ttm41Cutoffs = new Array("0:55:00", "0:47:00", "0:43:00", "0:39:30", "0:37:30", "0:36:00", "0:34:30", "0:33:30", "0:32:40", "0:00:00");
const ttm41Weight = 15000;
const ttm41Table = new PointsTable(ttm41Cutoffs, pointsMultiplier, ttm41Weight);

const ttm85CutOffs = new Array("2:45:00", "2:20:00", "2:05:00", "1:55:00", "1:47:00", "1:40:00", "1:34:00", "1:29:00", "1:25:40", "0:00:00");
const ttm85Weight = 22000;
const ttm85Table = new PointsTable(ttm85CutOffs, pointsMultiplier, ttm85Weight);

const dataBase = new Array(starRoad20Table, starRoad80Table, starRoad130Table, sm74_10Table, sm74_50Table, sm74_110Table, sm74_151Table, dmg0Table, dmg53Table, dmg120Table, ldd51Table, ldd74Table, ttm16Table, ttm41Table, ttm85Table);
const bonus = new Array(100, 300, 600, 100, 250, 350, 600, 100, 250, 500, 250, 400, 100, 250, 500);
const table = document.getElementById("calc");

function calc() {
    if(!table) return;
	for (var a = 0; a < 15; a++) {
		table.getElementsByTagName('tr')[2].getElementsByTagName('td')[a + 1].children[0].value = "9:59:59";
		table.getElementsByTagName('tr')[3].getElementsByTagName('td')[a + 1].children[0].value = "9:59:59";
		computePoints(a);
	}
}

function computePoints(index) {
	const pointsTable = dataBase[index];
	var startTime = "9:59:59", endTime = "9:59:59";
	table.getElementsByTagName('tr')[2].getElementsByTagName('td')[index + 1].children[0].addEventListener("keyup", ((keyUpEvent) => {
		startTime = table.getElementsByTagName('tr')[2].getElementsByTagName('td')[index + 1].children[0].value;
		if (startTime.length === 7 && endTime.length === 7) {
			helperFunction(index, startTime, endTime, pointsTable);
		}
	}));
	table.getElementsByTagName('tr')[3].getElementsByTagName('td')[index + 1].children[0].addEventListener("keyup", ((keyUpEvent) => {
		endTime = table.getElementsByTagName('tr')[3].getElementsByTagName('td')[index + 1].children[0].value;
		if (startTime.length === 7 && endTime.length === 7) {
			helperFunction(index, startTime, endTime, pointsTable);
		}
	}));
}

function helperFunction(index, startTime, endTime, pointsTable) {
	var totalPoints = 0;

	for (var i = 0; i < 10; i++) {
		totalPoints = totalPoints + pointsTable.getPoints(i, startTime, endTime);
	}

	table.getElementsByTagName('tr')[4].getElementsByTagName('td')[index + 1].innerText = totalPoints;
	if (pointsTable.getTotalSeconds(startTime) > pointsTable.getTotalSeconds(endTime)) {
		var result = bonus[index] * (getTier(startTime, pointsTable) + getAdditionalBonusFactor(getTier(startTime, pointsTable), startTime, pointsTable));
		result = parseFloat(result).toPrecision(12);
		result = Math.ceil(result);
		table.getElementsByTagName('tr')[5].getElementsByTagName('td')[index + 1].innerText = result;
	}
	else {
		table.getElementsByTagName('tr')[5].getElementsByTagName('td')[index + 1].innerText = 0;
	}
	table.getElementsByTagName('tr')[6].getElementsByTagName('td')[index + 1].innerText = totalPoints + Number(table.getElementsByTagName('tr')[5].getElementsByTagName('td')[index + 1].innerText);
	calculateTotals();
}

function getTier(startTime, pointsTable) {
	const seconds = pointsTable.getTotalSeconds(startTime);
	if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[8])) {
		return 10;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[7])) {
		return 9;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[6])) {
		return 8;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[5])) {
		return 7;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[4])) {
		return 6;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[3])) {
		return 5;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[2])) {
		return 4;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[1])) {
		return 3;
	}
	else if (seconds < pointsTable.getTotalSeconds(pointsTable.cutoffs[0])) {
		return 2;
	}
	else {
		return 1;
	}
}

function getAdditionalBonusFactor(tier, starttime, pointsTable) {
	var possibleSeconds = pointsTable.getPossibleSeconds(tier - 1);
	var secondsIntoTier = pointsTable.getTotalSeconds(pointsTable.cutoffs[tier - 1]) - pointsTable.getTotalSeconds(starttime);
	if (possibleSeconds == 0) {
		return 0;
	}
	else {
		return secondsIntoTier / possibleSeconds;

	}

}

function calculateTotals() {
	var sum1 = 0, sum2 = 0, sum3 = 0;
	for (var i = 0; i < 15; i++) {
		sum1 += Number(table.getElementsByTagName('tr')[4].getElementsByTagName('td')[i + 1].innerText);
		sum2 += Number(table.getElementsByTagName('tr')[5].getElementsByTagName('td')[i + 1].innerText);
		sum3 += Number(table.getElementsByTagName('tr')[6].getElementsByTagName('td')[i + 1].innerText);
	}
	table.getElementsByTagName('tr')[4].getElementsByTagName('td')[16].innerText = sum1;
	table.getElementsByTagName('tr')[5].getElementsByTagName('td')[16].innerText = sum2;
	table.getElementsByTagName('tr')[6].getElementsByTagName('td')[16].innerText = sum3;

}