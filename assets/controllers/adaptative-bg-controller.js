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
            r.style.setProperty('--main-muted', palette.Muted.getHex());
            r.style.setProperty('--sub-muted-light', palette.LightMuted.getHex());
            r.style.setProperty('--sub-muted-dark', palette.DarkMuted.getHex());
            r.style.setProperty('--accent-muted-light', palette.LightMuted.getTitleTextColor());
            r.style.setProperty('--accent-muted-dark', palette.DarkMuted.getTitleTextColor());

            r.style.setProperty('--main-vibrant', palette.Vibrant.getHex());
            r.style.setProperty('--sub-vibrant-light', palette.LightVibrant.getHex());
            r.style.setProperty('--sub-vibrant-dark', palette.DarkVibrant.getHex());
            r.style.setProperty('--accent-vibrant-light', palette.LightVibrant.getTitleTextColor());
            r.style.setProperty('--accent-vibrant-dark', palette.DarkVibrant.getTitleTextColor());
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