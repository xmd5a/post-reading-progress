class WordpressReadingProgress {

    constructor(element) {
        this.element = document.getElementById(element);
        this.screenHeight = this.getScreenHeight();
        this.elementOffset = this.getElementOffset();
        this.scrollPosition = this.getScrollPosition();
        this.scrollbarElement = null;
        this.scrollbarElementID = 'wordpress-reading-progress-bar';

        this.appendScrollbarElement(document.getElementsByTagName('body')[0]);

        window.addEventListener('resize', this.checkReadingProgress.bind(this));
        window.addEventListener('scroll', this.checkReadingProgress.bind(this));
    }

    getElementOffset() {
        return this.element.getBoundingClientRect().bottom;
    }

    getScreenHeight() {
        return Math.max(document.documentElement.clientHeight, window.innerHeight);
    }

    getScrollPosition() {
        return document.documentElement.scrollTop;
    }

    appendScrollbarElement(appendTo) {
        this.scrollbarElement = document.createElement('div');
        this.scrollbarElement.setAttribute('id', this.scrollbarElementID);
        appendTo.appendChild(this.scrollbarElement);
        this.scrollbarElement.appendChild(document.createElement('div'));
    }

    checkReadingProgress() {
        this.elementOffset = this.getElementOffset();
        this.screenHeight = this.getScreenHeight();
        this.scrollPosition = this.getScrollPosition();

        const currentOffset = this.elementOffset - this.screenHeight;
        const totalOffset = this.scrollPosition + currentOffset;
        let currentPercentPosition = Math.abs((currentOffset * 100 / totalOffset) - 100);

        if(currentPercentPosition > 100)
            currentPercentPosition = 100;

        document.querySelector(`#${this.scrollbarElementID} > div`).style.width = currentPercentPosition + '%';
    }
}

export default WordpressReadingProgress;