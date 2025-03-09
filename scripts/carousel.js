class Carousel {
    constructor(el) {
        this.el = el;
        this.current = 0;
        this.slides = el.querySelectorAll('.slide').length;

        this.init();
        setInterval(() => this.move(0), 5000);
    }

    init() {
        const dots = [...Array(this.slides)].map((_, i) =>
            `<div class="dot ${i === 0 ? 'active' : ''}" data-slide="${i}"></div>`
        ).join('');

        this.el.querySelector('.dots').innerHTML = dots;

        this.el.addEventListener('click', e => {
            if (e.target.matches('.prev')) this.move(-1);
            if (e.target.matches('.next')) this.move(1);
            if (e.target.matches('.dot')) this.goto(+e.target.dataset.slide);
        });
    }

    move(dir) {
        this.goto((this.current + dir + this.slides) % this.slides);
    }

    goto(n) {
        this.el.querySelector('.carousel').style.transform = `translateX(-${n * 100}%)`;
        this.el.querySelectorAll('.dot').forEach((dot, i) =>
            dot.classList.toggle('active', i === n)
        );
        this.current = n;
    }
}

// Initialize the carousel when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new Carousel(document.querySelector('.carousel-container'));
});
