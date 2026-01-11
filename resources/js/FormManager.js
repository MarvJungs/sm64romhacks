export default class FormManager {
    form;
    constructor(formid) {
        this.form = document.getElementById(formid);
        if (!this.form) return;
        this.main();
    }

    main() {
        let rows = this.form.querySelectorAll('.row');
        if (Array.from(rows).length == 0) return;

        let fieldWithMultipleEntries = Array.from(rows).filter((row) => row.dataset.enableMultipleFields);
        Array.from(fieldWithMultipleEntries).forEach((field, index) => {
            const addButton = field.querySelector('button.btn');
            addButton.addEventListener('click', (e) => this.addInputfield(field));

            Array.from(field.querySelectorAll('div.row')).forEach((row) => {
                const button = row.querySelector('button.btn.btn-danger');
                if (!button.disabled) {
                    button.addEventListener('click', () => row.remove());
                }
            });
        });
    }

    addInputfield(row) {
        const deleteIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"></path></svg>';
        const label = row.querySelector('label');
        const name = label.getAttribute('for');

        const input = document.createElement('input');
        input.classList.add('form-control', 'mb-2');
        input.type = 'url';
        input.name = `${name}[]`;
        input.required = true;

        const inputContainer = document.createElement('div');
        inputContainer.classList.add('offset-2', 'col-9');
        inputContainer.appendChild(input);

        const button = document.createElement('button');
        button.classList.add('btn', 'btn-danger');
        button.type = 'button';
        button.innerHTML = deleteIcon;

        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('col-1');
        buttonContainer.appendChild(button);

        const rowContainer = document.createElement('div');
        rowContainer.classList.add('row', 'g-2', 'mb-2');
        rowContainer.appendChild(inputContainer);
        rowContainer.appendChild(buttonContainer);
        
        row.appendChild(rowContainer);
        
        button.addEventListener('click', () => rowContainer.remove());
    }
}