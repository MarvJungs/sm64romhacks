document.addEventListener('DOMContentLoaded', function () {
    const currentTimeContainer = document.getElementById('currentTime');
    const timeElements = Array.from(document.getElementsByClassName('time'));
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
        currentTimeContainer.innerHTML = time;
    }, 1000);

    timeElements.forEach((timeElement) => {
        let date = new Date(timeElement.innerText + " UTC");
        date = new Intl.DateTimeFormat('sv', options).format(date);
        timeElement.innerText = date;
    });
});