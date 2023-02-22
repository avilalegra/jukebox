import {Controller} from '@hotwired/stimulus';
import * as Vibrant from "node-vibrant";


export default class extends Controller {

    static targets = ['image'];

    connect() {
        setTimeout(() => this.adjustColorPalette(), 300)
    }

    async adjustColorPalette() {

        if (this.hasImageTarget) {
            let image = document.createElement('img');
            image.src = this.imageTarget.src
            let palette = await this.getPalette(image)
            let r = document.querySelector(':root');
            r.style.setProperty('--main-color', palette.Muted.getHex());
            r.style.setProperty('--sub-color-light', palette.LightMuted.getHex());
            r.style.setProperty('--sub-color-dark', palette.DarkMuted.getHex());
            r.style.setProperty('--accent-color-light', palette.LightMuted.getTitleTextColor());
            r.style.setProperty('--accent-color-dark', palette.DarkMuted.getTitleTextColor());
        }
    }

    getPalette(image) {
        return Vibrant.from(image).getPalette();
    }
}

// debug tool
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