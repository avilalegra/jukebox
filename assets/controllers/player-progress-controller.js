import {Controller} from '@hotwired/stimulus';


export default class extends Controller {
    static values = {isRunning: Boolean, totalTime: Number, elapsedTime: Number}
    static targets = ['progressBar', 'played', 'elapsed', 'remain']

    connect() {
        if (this.isRunningValue) {
            this.updateProgress()
        }
    }

    disconnect() {
        clearInterval(this.ticker);
        super.disconnect();
    }

    updateProgress() {
        let currentSecond = this.elapsedTimeValue;
        this.renderState(currentSecond)

        this.ticker = setInterval(() => {
            if (currentSecond >= this.totalTimeValue) {
                clearInterval(this.ticker)
                return;
            }

            this.renderState(++currentSecond)
        }, 1000)
    }

    renderState(currentSecond) {
        let progressBarWidth = this.progressBarTarget.offsetWidth
        let delta = progressBarWidth / this.totalTimeValue

        this.playedTarget.style.width = (delta * currentSecond) + 'px'
        this.elapsedTarget.textContent = this.timeFormatted(currentSecond)
        this.remainTarget.textContent = this.timeFormatted(this.totalTimeValue - currentSecond)
    }

    timeFormatted(seconds) {
        let m = Math.floor(seconds / 60)
        let s = seconds % 60

        return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`
    }
}
