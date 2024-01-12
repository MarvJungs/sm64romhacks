class Horaro {
	constructor(id) {
		this.id = id;
	}


	async parseHoraroData() {
		const scheduleID = this.id;
		const marathon_data = (await this.getMarathonData(scheduleID)).data;
		const marathon_ticker = (await this.getMarathonTicker(scheduleID)).data.ticker;
		const scheduleHeader = this.getHeaderTableRow(marathon_data.columns);
		const scheduleRuns = this.getRunsData(marathon_data.items, marathon_ticker.current);
		const schedule = this.getScheduleTable(scheduleHeader, scheduleRuns);
		const current = this.tickerToString(marathon_ticker.current);
		const next = this.tickerToString(marathon_ticker.next);


		const scheduleDiv = document.querySelector("#schedule");
		const tickerDiv = document.querySelector("#ticker");
		scheduleDiv.innerHTML = schedule;
		tickerDiv.innerHTML = `
			<table class="table-sm table-bordered table-secondary">
				<tr>
					<th>Current Run:</th>
					<th>Next Run:</th>
				</tr>
				<tr>
					<td>${current}</td>
					<td>${next}</td>
				</tr>
			</table>
			<hr/>`;

		if (marathon_ticker.current === null && marathon_ticker.next === null) tickerDiv.remove(); //Marathon is over
	}

	tickerToString(ticker) {
		if (ticker) return `${ticker.data[0]} - ${ticker.data[1]} by ${ticker.data[2]}`
		else return ``;
	}

	async getMarathonData(id) {
		try {
			const response = await fetch(`/api/schedule?id=${id}`);
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

	async getMarathonTicker(id) {
		try {
			const response = await fetch(`/api/schedule?id=${id}/ticker`);
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

	getHeaderTableRow(coloumns) {
		const header =
			`
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>${coloumns[0]}</th>
				<th>Estimate</th>
				<th>${coloumns[1]}</th>
				<th>${coloumns[2]}</th>
				<th>${coloumns[3]}</th>
			</tr>
		`


		return header;
	}

	getRunsData(runs, current) {
		const content = Array.from(runs).map((run) => {
			return `${this.getRunData(run, current)}`
		}).join("");
		return content;
	}

	getRunData(run, current) {
		const estimate = new Date(run.length_t * 1000).toISOString().slice(11, 19);
		const highlightCurrentRun = current != null && current.scheduled_t === run.scheduled_t ? `class="table-primary"` : ``;
		const time = this.convertTimestampToTime(run.scheduled_t);
		const date = this.convertTimestampToDate(run.scheduled_t);
		const hack = run.data[0];
		const category = run.data[1];
		const runner = run.data[2];
		const commentator = run.data[3];
		return `
			<tr ${highlightCurrentRun}>
				<td class="text-nowrap">${date}</td>
				<td class="text-nowrap">${time}</td>
				<td>${hack}</td>
				<td>${estimate}</td>
				<td>${category}</td>
				<td>${runner}</td>
				<td>${commentator}</td>
			</tr>
		`
	}

	getScheduleTable(scheduleHeader, scheduleRuns) {
		return `
			<table class="table-sm table-bordered">
				${scheduleHeader}
				${scheduleRuns}
			</table>
		`
	}

	convertTimestampToTime(timestamp) {
		const d = new Date(timestamp * 1000);
		const hh = ('0' + d.getHours()).slice(-2)			// Add leading 0.
		const m = ('0' + d.getMinutes()).slice(-2)			// Add leading 0.
		const ss = ('0' + d.getSeconds()).slice(-2)		// Add leading 0.

		const time = hh + ':' + m + ':' + ss;

		return time;
	}

	convertTimestampToDate(timestamp) {
		const d = new Date(timestamp * 1000);				// Convert the passed timestamp to milliseconds
		const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
		const yyyy = d.getFullYear()
		const mm = ('0' + (d.getMonth() + 1)).slice(-2)		// Months are zero based. Add leading 0.
		const dd = ('0' + d.getDate()).slice(-2)			// Add leading 0.

		const time = days[d.getDay()] + ', ' + yyyy + '-' + mm + '-' + dd;

		return time;


	}
}