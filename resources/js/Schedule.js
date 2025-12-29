export default class Schedule {
    constructor() {
        const schedule = document.getElementById('schedule');
        if (!schedule) return;

        const table = document.getElementsByTagName('tbody')[0];
        Array.from(table.children).forEach((row) => {
            const children = row.children;
            const time = children[0];
            const length = children[1];

            length.innerText = this.convertSecondstoLength(length.innerText);
            time.innerText = this.convertTimestamptoDate(time.innerText);
            // console.log(new Date(time.innerText * 1000))
        });
    }

    convertSecondstoLength(duration_t) {
        const hours = String(Math.floor(duration_t / 3600)).padStart(2, '0');
        const minutes = String(Math.floor((duration_t / 60) % 60)).padStart(2, '0');
        const seconds = String(Math.floor(duration_t % 60)).padStart(2, '0');
        return `${hours}:${minutes}:${seconds}`
    }

    convertTimestamptoDate(time_t) {
        const date = new Date(time_t * 1000);
        const options = {
            hour12: false
        };
        return date.toLocaleString(undefined, options );
    }
}