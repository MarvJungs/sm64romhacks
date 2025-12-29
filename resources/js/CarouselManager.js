import { Carousel } from "bootstrap";

export default class CarouselManager
{
    constructor()
    {
        const elements = document.getElementsByClassName('carousel');
        if (Array.from(elements).length > 0) {
            this.main(elements);
        }
    }

    main(elements)
    {
        Array.from(elements).forEach((el) => new Carousel(el, {interval: 2000, touch: false}));
    }
}