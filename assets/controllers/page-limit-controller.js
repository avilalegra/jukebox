import {Controller} from '@hotwired/stimulus';
import * as Vibrant from "node-vibrant";


export default class extends Controller {
    static targets = ['pageLimit'];

    connect() {
        super.connect();
    }

    changeLimit() {

        console.log(this.pageLimitTarget.value);
        Turbo.visit(this.pageLimitTarget.value)
    }
}