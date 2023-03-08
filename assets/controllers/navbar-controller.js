import {Controller} from '@hotwired/stimulus';


export default class extends Controller {
    static targets = ['jukebox'];

    close() {
        this.jukeboxTarget.classList.remove('-navbar-opened')

    }
    open() {
        this.jukeboxTarget.classList.add('-navbar-opened')
    }
}