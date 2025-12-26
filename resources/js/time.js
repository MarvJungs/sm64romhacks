export default class Time 
{
    timeElements;
    options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: false
    };

    constructor()
    {
        this.timeElements = Array.from(document.getElementsByClassName('time'));
    }

    run()
    {
        this.timeElements.forEach(element => {
            const time = element.innerText;
            if (!time) return;
            console.log(time);
            const utc = new Date(time + " UTC");
            element.innerText = new Intl.DateTimeFormat('sv', this.options).format(utc);
        });
    }
}