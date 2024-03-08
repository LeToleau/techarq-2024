class Navbar {
    constructor(block) {
        this.block = block;
        this.container = block.querySelector(".container");
        this.home = document.querySelector('.home');
        this.menuItems = this.block.querySelectorAll('.main-menu>li');
        this.logo = this.block.querySelector('.logo');
        
        this.init();
    }

    init() {
        window.addEventListener('scroll', this.toggleScrolled.bind(this));
        this.block.querySelector('.nav-tgl').addEventListener('click', this.toggleMenu.bind(this));

        const delayTime = window.scrollY !== 0 ? 500 : 1500;
        if (this.home) {
            let delayIncrement = 150;
            setTimeout(() => {
                this.menuItems.forEach((item, index) => {
                    setTimeout(() => {
                        this.showMenuItem(item);
                    }, delayIncrement * (index + 1));
                });
                setTimeout(() => {
                    this.showLogo();
                }, (delayTime === 500 ? delayTime : delayTime - 500));
            }, delayTime);
        } else {
            this.menuItems.forEach((item, index) => {
                this.showMenuItem(item, index * 150);
            });
            setTimeout(() => {
                this.showLogo();
            }, delayTime);
        }
    }

    toggleScrolled() {
        if (window.scrollY > 0) {
            this.block.classList.add('scrolled');
        } else {
            this.block.classList.remove('scrolled');
        }
    }

    toggleMenu(evt) {
        this.container.classList.toggle('active');
    }

    showMenuItem(item, delay = 0) {
        item.style.transition = `opacity .3s, transform .3s`;
        item.style.opacity = `1`;
        item.style.transform = `translateY(0)`;
        setTimeout(() => {
            item.classList.add('visible');
        }, delay);
    }

    showLogo() {
        this.logo.style.transition = `opacity .3s, transform .3s`;
        this.logo.style.opacity = `1`;
        this.logo.style.transform = `translateY(0)`;
    }
}

export default Navbar;