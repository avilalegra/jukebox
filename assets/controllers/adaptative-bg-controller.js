import {Controller} from '@hotwired/stimulus';
import colorPalette from './../adaptative-bg'


export default class extends Controller {

    static targets = ['image'];

    connect() {
        setTimeout(() => this.adjustColorPalette(), 300)
    }

    adjustColorPalette() {
        console.log("hekjk");
        if (this.hasImageTarget) {
            let palette = colorPalette(this.imageTarget)
            let r = document.querySelector(':root');
            r.style.setProperty('--main-color', palette.mainColor);
            r.style.setProperty('--sub-color-light', palette.subColorLight);
            r.style.setProperty('--sub-color-dark', palette.subColorDark);
            r.style.setProperty('--accent-color-light', palette.accentColorLight);
            r.style.setProperty('--accent-color-dark', palette.accentColorDark);
        }
    }
}
