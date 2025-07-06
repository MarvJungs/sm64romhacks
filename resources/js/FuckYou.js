export default class FuckYou
{
    main()
    {
        const image = document.getElementsByClassName('movingImage')[0];
        const troll = document.querySelector('#star-revenge-55-destroyed-memories a');
        console.log(troll)
        if (!image || !troll) return;
        troll.addEventListener('click', (event) => {
            event.preventDefault();
            console.log(troll.getBoundingClientRect());
            image.style.top = `${troll.getBoundingClientRect().top - document.body.getBoundingClientRect().top}px`;
            image.sizes = troll.getBoundingClientRect().height;
            image.classList.add('move', 'ltr');
        });

        image.addEventListener('transitionrun', () => console.log('start'))

    }
}