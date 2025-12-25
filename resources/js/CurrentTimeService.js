export default class CurrentTimeService {
    constructor() {
        const timeElement = document.getElementById('currentTime');
        if (!timeElement) {
            return;
        }
        this.run(timeElement);
    }

    run(timeElement) {
        const options = {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: false
        };

        setInterval(() => {
            let time = new Date();
            time = new Intl.DateTimeFormat('sv', options).format(time);
            timeElement.innerHTML = time;
        }, 1000);
    }
}