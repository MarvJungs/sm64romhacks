export default class VideoPlayer {
    videoSection;
    player;
    // done = false;

    constructor() {
        this.videoSection = document.getElementById('video');
        if (!this.videoSection) return;
        this.main();
    }

    main() {
        const playButton = this.videoSection.querySelector('#video__playButton');
        if (!playButton) return;
        playButton.addEventListener('click', () => this.loadVideo());
    }

    loadVideo() {
        const playerDiv = document.createElement('div');
        playerDiv.id = 'player';
        Array.from(this.videoSection.childNodes).forEach((node) => node.remove());
        this.videoSection.insertBefore(playerDiv, this.videoSection.firstChild);

        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    initPlayer() {
        console.log('init');
        this.player = new YT.Player('player', {
            height: '480',
            width: '640',
            videoId: this.videoSection.dataset.videoId,
            playerVars: {
                'playsinline': 1
            },
            events: {
                'onReady': this.onPlayerReady.bind(this),
                // 'onStateChange': this.onPlayerStateChange.bind(this)
            }
        });
    }

    onPlayerReady(event) {
        event.target.playVideo();
    }

    // onPlayerStateChange(event) {
    //     if (event.data == YT.PlayerState.PLAYING && !this.done) {
    //         setTimeout(this.stopVideo.bind(this), 6000);
    //         this.done = true;
    //     }
    // }

    // stopVideo() {
    //     this.player.stopVideo();
    // }
}