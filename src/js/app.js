class WordpressReadingProgress {

    constructor(element) {
        this.element = document.getElementById(element);
        this.screenHeight = this.getScreenHeight();
        this.elementOffset = this.getElementOffset();

        window.addEventListener('resize', this.checkReadingProgress.bind(this));
        window.addEventListener('scroll', this.checkReadingProgress.bind(this));
    }

    getElementOffset() {
        return this.element.getBoundingClientRect().bottom;
    }

    getScreenHeight() {
        return Math.max(document.documentElement.clientHeight, window.innerHeight);
    }

    checkReadingProgress() {
        this.elementOffset = this.getElementOffset();
        this.screenHeight = this.getScreenHeight();
    }
}

export default WordpressReadingProgress;