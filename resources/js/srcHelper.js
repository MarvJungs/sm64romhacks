export default class SrcHelper {
    constructor() {
        //ROM Hack ID
        this.gametype = 'v4m291qw';
    }
    async fetchGame(name) {
        return await fetch('https://www.speedrun.com/api/v1/games?name=' + name + '&embed=categories,variables');
        // return await fetch('https://www.speedrun.com/api/v1/games?name=' + name + '&gametype=' + this.gametype + '&embed=categories,variables');
    }
}