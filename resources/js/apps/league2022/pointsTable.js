export default class PointsTable {
	constructor(cutoffs, pointsMultiplier, weight) {
		this.cutoffs = cutoffs;
		this.pointsMultiplier = pointsMultiplier;
		this.weight = weight;
	}

	getHours(time) {
		return Number(time.substring(0, 1));
	}

	getMinutes(time) {
		return Number(time.substring(2, 4));
	}

	getSeconds(time) {
		return Number(time.substring(5, 7));
	}

	getPossibleSeconds(index) {
		if (index == 0) {
			return 0;
		}
		else {
			return this.getTotalSeconds(this.cutoffs[index - 1]) - this.getTotalSeconds(this.cutoffs[index]);
		}
	}

	getPointsPerSecond(index) {
		if (index == 0) {
			return 0;
		}
		else if (index == 9) {
			return Math.ceil(this.pointsMultiplier[9] * this.getPointsPerSecond(8));
		}
		else if (index > 0) {
			let result = this.weight * this.pointsMultiplier[index] / this.getPossibleSeconds(index);
			result = this.strip(result);
			return Math.ceil(result);
		}
	}

	strip(number) {
		return (parseFloat(number).toPrecision(12));
	}

	getTotalSeconds(time) {
		return this.getHours(time) * 3600 + this.getMinutes(time) * 60 + this.getSeconds(time);
	}

	getPoints(index, startTime, endTime) {
		if (index == 0) {
			return this.getPointsPerSecond(index) * (Math.max(this.getTotalSeconds(startTime), this.getTotalSeconds(this.cutoffs[index])) - Math.max(this.getTotalSeconds(endTime), this.getTotalSeconds(this.cutoffs[index])));
		}
		else {
			if (this.getTotalSeconds(endTime) > this.getTotalSeconds(this.cutoffs[index - 1])) {
				return 0;
			}
			else {
				return this.getPointsPerSecond(index) * Math.max(0, Math.min(this.getTotalSeconds(startTime), this.getTotalSeconds(this.cutoffs[index - 1])) - Math.max(this.getTotalSeconds(endTime), this.getTotalSeconds(this.cutoffs[index])));
			}
		}
	}
}