import {Controller} from '@hotwired/stimulus';


export default class extends Controller {

    static values =  {'promptMsg': String}
    connect() {
        super.connect();
        let message = this.promptMsgValue
        this.element.addEventListener('submit', function (e) {
            let ok = confirm(message)
            if (!ok) {
                e.preventDefault();
            }
        })
    }
}
