import {Controller} from '@hotwired/stimulus';


export default class extends Controller {

    static values = {audioId: String}

    connect() {
        super.connect();
        window.addEventListener('playing', this.onPlayingStatus.bind(this));
        window.addEventListener('halted', this.onHaltedStatus.bind(this));
    }

    disconnect() {
        super.disconnect();
        window.removeEventListener('playing', this.onPlayingStatus)
        window.removeEventListener('halted', this.onHaltedStatus);
    }

    onPlayingStatus(e) {
        let nowPlayingId = e.detail.nowPlaying

        if (nowPlayingId === this.audioIdValue) {
            this.element.classList.add('-playing')
        }
    }

    onHaltedStatus(e) {
        let lastPlayedId = e.detail.lastPlayed
        this.element.classList.remove('-playing')

        if (lastPlayedId === this.audioIdValue) {
            this.element.classList.add('-lastplayed')
        }
    }
}
