import {Controller} from '@hotwired/stimulus';


export default class extends Controller {

    static values = {'nowPlaying': String, 'lastPlayed': String}

    connect() {
        super.connect();
        let nowPlaying = this.nowPlayingValue
        let lastPlayed = this.lastPlayedValue

        if (nowPlaying === '') {
            window.dispatchEvent(new CustomEvent('halted',
                {detail: {lastPlayed}}))
        } else {
            window.dispatchEvent(new CustomEvent('playing', {
                detail: {nowPlaying}
            }))
        }
    }
}
