document.addEventListener("DOMContentLoaded", main);

function main() {
    const marathonParser = new Horaro("00110ma4off0607a58");
    marathonParser.parseHoraroData();
}