import {Controller} from '@hotwired/stimulus';
import * as Vibrant from "node-vibrant";


export default class extends Controller {

    static targets = ['image'];

    connect() {
        setTimeout(() => this.adjustColorPalette(), 300)
    }

    async adjustColorPalette() {

        if (this.hasImageTarget) {
            let palette = await this.getPalette(this.imageTarget)
            let r = document.querySelector(':root');
            r.style.setProperty('--main-color', palette.Vibrant.getHex());
            r.style.setProperty('--sub-color-light', palette.LightVibrant.getHex());
            r.style.setProperty('--sub-color-dark', palette.DarkVibrant.getHex());
            r.style.setProperty('--accent-color-light', palette.LightVibrant.getTitleTextColor());
            r.style.setProperty('--accent-color-dark', palette.DarkVibrant.getTitleTextColor());
        }
    }

    getPalette(image) {
        return Vibrant.from(image).getPalette();
    }
}

function showPalette(palette) {
    let body = document.getElementById('palette');
    body.innerHTML = ""

    for (var swatch in palette) {
        if (palette.hasOwnProperty(swatch) && palette[swatch]) {
            let colorDiv = document.createElement('div');
            colorDiv.style.backgroundColor = palette[swatch].getHex()
            colorDiv.style.width = "100%";
            colorDiv.style.height = "50px";
            colorDiv.innerHTML = '<span>' + swatch + '</span>'
            body.appendChild(colorDiv)
        }
    }
}