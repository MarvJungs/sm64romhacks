export default class PillButton
{
    constructor(form = null)
    {
        this.form = form;
    }

    main()
    {
        if (!this.form || !document.getElementById(this.form.id)) return;
        const input = document.getElementById(this.form.inputid);
        const datalist = document.getElementById(input.getAttribute('list'));
        const oldValues = Array.from(document.getElementsByTagName('input')).filter((node) => node.getAttribute('type') === 'hidden' && node.name === `${this.form.inputid}[]`);

        input.addEventListener('keypress', (e) => {
            if (e.key == "Enter")
            {
                e.preventDefault();
                this.addPillButton(input.value);
                input.value = '';
            }
        });

        input.addEventListener('input', (e) => {
            const text = e.target.value;
            const values = Array.from(datalist.childNodes).map((node) => node.value);
            if (values.includes(text))
            {
                this.addPillButton(text);
                input.value = '';
            }
        });

        oldValues.forEach((e) => {
            e.remove(); 
            this.addPillButton(e.value)
        });
    }

    addPillButton(string)
    {
        const parent = document.getElementById(this.form.inputid).parentNode;
        const span = document.createElement('span');
        const button = document.createElement('button');
        const image = document.createElement('img');
        const input = document.createElement('input');

        span.classList.add('badge', 'rounded-pill', 'text-bg-primary', 'me-1');
        span.innerText = string;

        button.classList.add('button-pill');
        button.type = 'button';
        button.addEventListener('click', () => {
            span.remove();
            input.remove();
        });

        image.src = '/icons/x-circle.svg';

        button.appendChild(image);
        span.appendChild(button);

        parent.firstElementChild.appendChild(span);

        input.hidden = true;
        input.name = `${this.form.inputid}[]`;
        input.setAttribute('value', string);

        document.getElementById(this.form.id).appendChild(input);
    }
}