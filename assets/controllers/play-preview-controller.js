import {Controller} from '@hotwired/stimulus';
import * as Vibrant from "node-vibrant";


window.stopPlaying = function () {
    if (this.playing) {
        this.playing.stop();
    }
}

window.setPlaying = function (playing) {
    this.playing = playing;
}
export default class extends Controller {
    static targets = ['playPreview', 'player'];


    async play() {
        window.stopPlaying()
        let player = this.playerTarget
        let playPreview = this.playPreviewTarget

        await player.play()
        playPreview.classList.add('-play')
        window.setPlaying(this)

        player.addEventListener('pause', function () {
            playPreview.classList.remove('-play')
        }, {'once': true});
    }

    stop() {
        this.playerTarget.src = this.playerTarget.src
        this.playPreviewTarget.classList.remove('-play')
    }
}
