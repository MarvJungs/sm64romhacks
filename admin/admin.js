document.addEventListener("DOMContentLoaded", main);

async function main() {
	const allPendingHacks = await getAllPendingHacks();
	const adminPageContainer = document.querySelector("#admin-page");
	adminPageContainer.innerHTML = getAllPendingHacksTable(allPendingHacks);
}

async function getAllPendingHacks() {
	try {
		const response = await fetch('/api/admin');
		if (!response.ok) {
			throw new Error(`${response.status} ${response.statusText}`);
		}
		const r = await response.json();
		return r;
	}
	catch (error) {
		console.log(error);
	}
}

function getAllPendingHacksTable(allPendingHacks) {
	const pendingHacksTableHeaderRow = getPendingHacksTableHeaderRow();
	const pendingHacksTableContent = allPendingHacks.map((pendingHack) => getPendingHackTableRowContent(pendingHack));

	return allPendingHacks.length > 0 ? `
		<div class="table-responsive">
			<table class="table-sm table-bordered">
				${pendingHacksTableHeaderRow}
				${pendingHacksTableContent}
			</table>
	` : "Currently No Hacks for Review available!";
}

function getPendingHacksTableHeaderRow() {
	return `
		<tr>
			<th><b>Hack Name</b></th>
			<th><b>Version</b></th>
			<th><b>Star Count</b></th>
			<th><b>Release Date</b></th>
			<th class="border-0">&nbsp;</th>
		</tr>
	`;
}

function getPendingHackTableRowContent(pendingHack) {
	const hackID = pendingHack.hack_id;
	const hackName = pendingHack.hack_name;
	const hackVersion = pendingHack.hack_version;
	const hackStarcount = pendingHack.hack_starcount;
	const hackReleaseDate = pendingHack.hack_release_date;

	return `
		<tr>
			<td>${hackName}</td>
			<td>${hackVersion}</td>
			<td>${hackStarcount}</td>
			<td>${hackReleaseDate}</td>
			<td class="border-0 align-top"><a class="btn btn-success text-nowrap" href="/admin?hack_id=${hackID}&mode=accept"><img src="/_assets/_img/icons/accept.svg"></a>&nbsp;<a class="btn btn-danger text-nowrap" href="/admin?hack_id=${hackID}&mode=reject"><img src="/_assets/_img/icons/delete.svg"></a></td>
		</tr>
	`;
}
