document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('hackForm');

    if (!form) return;

    const addTagButton = document.getElementById('addTag');
    const addAuthorButton = document.getElementById('addAuthor');
    const removeTagButtons = document.getElementsByClassName('removeTag');
    const removeAuthorButtons = document.getElementsByClassName('removeAuthor');

    const tagsColumn = document.getElementById('tagsColumn');
    const authorColumn = document.getElementById('authorsColumn');

    if (addTagButton) {
        addTagButton.addEventListener('click', (event) => {
            event.preventDefault();
            addInputfield(tagsColumn);
        });
    }

    if (removeTagButtons) {
        Array.from(removeTagButtons).forEach(removeTagButton => {
            removeTagButton.addEventListener('click', (event) => {
                event.preventDefault();
                removeTagButton.parentNode.remove();
            });
        });
    }

    if (addAuthorButton) {
        addAuthorButton.addEventListener('click', (event) => {
            event.preventDefault();
            addInputfield(authorColumn);
        });
    }

    if (removeAuthorButtons) {
        Array.from(removeAuthorButtons).forEach(removeAuthorButton => {
            removeAuthorButton.addEventListener('click', (event) => {
                event.preventDefault();
                removeAuthorButton.parentNode.remove();
            });
        });
    }
});

function addInputfield(columnContainer) {
    console.log(columnContainer);
    const divElement = document.createElement('div');
    divElement.setAttribute('class', 'd-flex justify-content-between');

    const inputElement = document.createElement('input');
    inputElement.setAttribute('class', 'form-control mb-2 me-2');
    inputElement.setAttribute('type', 'text');
    inputElement.setAttribute('name', columnContainer.getAttribute('name') + '[]');
    inputElement.setAttribute('list', columnContainer.getAttribute('name') + 's');

    const removeButton = document.createElement('button');
    removeButton.setAttribute('class', 'btn btn-danger mb-2');

    const minusIcon = document.createElement('span');
    minusIcon.setAttribute('class', 'fa-solid fa-minus');

    removeButton.appendChild(minusIcon);
    divElement.appendChild(inputElement);
    divElement.appendChild(removeButton);
    columnContainer.appendChild(divElement);

    removeButton.addEventListener('click', () => {
        divElement.remove();
    });

}