import Swiper from 'swiper/bundle';

class PhotoSlider {
    constructor(block) {
        this.block = block;
        this.container = block.querySelector(".swiper");
        
        this.init();
    }

    init() {
        const swiper = new Swiper(this.container, {
            slidesPerView: 1,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoHeight: true
        });
    }
}

export default PhotoSlider;