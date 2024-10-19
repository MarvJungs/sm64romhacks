import SrcHelper from "./srcHelper";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('eventForm');
    if (!form) return;

    const event_type_dropdown = document.getElementById('event_type');
    const points_system_dropdown = document.getElementById('points_system');
    const leagueSettings = document.getElementById('league_settings');
    const points_per_second_settings = document.getElementById('points_per_second_settings');
    const league_participants_settings = document.getElementById('league_participants_settings');

    const addCategoryUrlButton = document.getElementById('addCategoryUrl');
    const addThresholdButtons = document.getElementsByClassName('addThresholdButton');
    const addParticipantButton = document.getElementById('addParticipantButton');

    const categoryUrlColumn = document.getElementById('categoryUrlColumn');
    const bonusPointsColumn = document.getElementById('bonusPointsColumn');
    const removeButtonColumn = document.getElementById('removeButtonColumn');

    const usernameColumn = document.getElementById('nameColumn');
    const srcNameColumn = document.getElementById('srcNameColumn');
    const removeParticipantColumn = document.getElementById('removeParticipantColumn');

    const gameSelectionColumn = document.getElementById('gameSelectionColumn');
    const categorySelectionColumn = document.getElementById('categorySelectionColumn');

    const addEventListener = (button, columnContainer) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const index = Array.from(columnContainer.children).indexOf(event.target);
            if (index !== -1) {
                Array.from(columnContainer.parentNode.children).forEach((child) => {
                    console.log(child);
                    child.children[index].remove();
                });
            }
        });

        Array.from(button.getElementsByTagName('span')).forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                button.click();
            });
        });
    }

    const srcHelper = new SrcHelper();

    let searchGameButtons = categoryUrlColumn.querySelectorAll('button.searchGameButton');
    let searchGameInputFields = categoryUrlColumn.querySelectorAll('input.searchGameInput');
    let gameSelectionDropdowns = gameSelectionColumn.querySelectorAll('select.gameSelection');
    let categorySelectionDropdowns = categorySelectionColumn.querySelectorAll('select.categorySelection');

    let games;
    Array.from(searchGameButtons).forEach((searchGameButton) => {
        searchGameButton.addEventListener('click', (event) => {
            event.preventDefault();
            const value = event.target.value;
            const searchGameInputField = Array.from(searchGameInputFields)[value - 1];
            const gameSelectionDropdown = Array.from(gameSelectionDropdowns)[value - 1];
            srcHelper.fetchGame(searchGameInputField.value)
                .then((data) => data.json())
                .then((response) => {
                    games = response.data;
                    gameSelectionDropdown.innerHTML = '<option>Select A Hack</option>';
                    games.forEach(game => {
                        const option = document.createElement('option');
                        option.value = game.id;
                        option.innerText = game.names.international;
                        gameSelectionDropdown.appendChild(option);
                    });
                    console.log(response);
                });
        });
    });

    Array.from(gameSelectionDropdowns).forEach((gameSelectionDropdown) => {
        addGameDropDownEventListener(gameSelectionDropdown);
    });

    if (event_type_dropdown.value == 2) {
        leagueSettings.hidden = false;
        league_participants_settings.hidden = false;
    }

    if (points_system_dropdown.value == 1) {
        points_per_second_settings.hidden = false;
    }

    event_type_dropdown.addEventListener('change', (event) => {
        if (event.target.value == 2) {
            leagueSettings.hidden = false;
            league_participants_settings.hidden = false;
        }
        else {
            leagueSettings.hidden = true;
            league_participants_settings.hidden = true;
        }
    });

    points_system_dropdown.addEventListener('change', (event) => {
        if (event.target.value == 1) {
            points_per_second_settings.hidden = false;
        }
        else {
            points_per_second_settings.hidden = true;
        }
    });

    Array.from(document.getElementsByClassName('removeCategoryUrl')).forEach((button) => {
        addEventListener(button, removeButtonColumn);
    });

    Array.from(removeParticipantColumn.querySelectorAll('button')).forEach((button) => {
        addEventListener(button, removeParticipantColumn);
    });

    addCategoryUrlButton.addEventListener('click', (event) => {
        event.preventDefault();
        addRemoveButton(removeButtonColumn, addEventListener);
        addInputfield(bonusPointsColumn, 'number');
        addDropDown(categorySelectionColumn);
        addDropDown(gameSelectionColumn);
        const div = document.createElement('div');
        categoryUrlColumn.appendChild(div);
        div.classList = 'd-flex justify-content-between';
        div.setAttribute('name', 'searchGameInput');
        addInputfield(div, 'text');
        addSearchButton(div);
    });

    addParticipantButton.addEventListener('click', (event) => {
        event.preventDefault();
        addInputfield(usernameColumn, 'text');
        addInputfield(srcNameColumn, 'text');
        addRemoveButton(removeParticipantColumn, addEventListener);
    });

    if (points_system_dropdown.value === 1) {
        Array.from(addThresholdButtons).forEach((button) => {
            const container = document.getElementById(button.name);
            const leagueCategoryIdColumn = container.querySelector('#leagueCategoryIdColumn')
            const cutoffColumn = container.querySelector('#cutoffColumn');
            const pointsPerSecondColumn = container.querySelector('#pointsPerSecondColumn');
            const tierColumn = container.querySelector('#tierColumn');
            const removeThresholdColumn = container.querySelector('#removeThresholdColumn');
            const removeThresholdButtons = container.querySelectorAll('button');

            button.addEventListener('click', (event) => {
                event.preventDefault();
                addInputfield(leagueCategoryIdColumn, 'hidden', button.value);
                addInputfield(cutoffColumn, 'text');
                addInputfield(pointsPerSecondColumn, 'number');
                addInputfield(tierColumn, 'number');
                addRemoveButton(removeThresholdColumn, addEventListener);
            });

            Array.from(removeThresholdButtons).forEach((removeButton) => {
                addEventListener(removeButton, removeThresholdColumn);
            });
        });
    }

    function addInputfield(columnContainer, type, value = null) {
        const inputElement = document.createElement('input');

        inputElement.classList = 'form-control mb-3';
        inputElement.classList.add(columnContainer.getAttribute('name'));
        inputElement.setAttribute('type', type);
        inputElement.setAttribute('name', columnContainer.getAttribute('name') + '[]');

        if (type == 'hidden') {
            inputElement.setAttribute('value', value);
        }

        if (columnContainer.getAttribute('name') == 'searchGameInput') {
            inputElement.setAttribute('list', 'hacknames')
        }

        columnContainer.appendChild(inputElement);
    }

    function addSearchButton(columnContainer) {
        const button = document.createElement('button');
        button.classList = 'btn btn-primary searchGameButton mb-3 ms-3 fa-solid fa-search';
        button.value = Number(categoryUrlColumn.querySelectorAll('button.searchGameButton').length) + 1;
        columnContainer.appendChild(button);
        addSearchGameButtonEventListener(button);
    }

    function addDropDown(columnContainer) {
        const select = document.createElement('select');
        select.classList = 'form-select mb-3';
        select.classList.add(columnContainer.getAttribute('name'));
        select.setAttribute('name', columnContainer.getAttribute('name') + '[]');
        columnContainer.appendChild(select);

        if (columnContainer.getAttribute('name') == 'gameSelection') {
            addGameDropDownEventListener(select);
        }
    }

    function addSearchGameButtonEventListener(button) {
        searchGameButtons = categoryUrlColumn.querySelectorAll('button.searchGameButton');
        searchGameInputFields = categoryUrlColumn.querySelectorAll('input.searchGameInput');
        gameSelectionDropdowns = gameSelectionColumn.querySelectorAll('select.gameSelection');
        categorySelectionDropdowns = categorySelectionColumn.querySelectorAll('select.categorySelection');

        console.log(searchGameInputFields)

        button.addEventListener('click', (event) => {
            event.preventDefault();
            const value = event.target.value;
            console.log(searchGameInputFields);
            const searchGameInputField = Array.from(searchGameInputFields)[value - 1];
            const gameSelectionDropdown = Array.from(gameSelectionDropdowns)[value - 1];
            srcHelper.fetchGame(searchGameInputField.value)
                .then((data) => data.json())
                .then((response) => {
                    games = response.data;
                    gameSelectionDropdown.innerHTML = '<option>Select A Hack</option>';
                    games.forEach(game => {
                        const option = document.createElement('option');
                        option.value = game.id;
                        option.innerText = game.names.international;
                        gameSelectionDropdown.appendChild(option);
                    });
                    console.log(response);
                });
        });
    }

    function addGameDropDownEventListener(dropdown) {
        dropdown.addEventListener('change', (event) => {
            const selectedGame = games.filter((game) => game.id === event.target.value)[0];
            const categories = selectedGame.categories.data.filter((category) => category.type === 'per-game');
            const variables = selectedGame.variables.data;
            const index = Array.from(gameSelectionDropdowns).findIndex((gameSelectionDropdown) => gameSelectionDropdown === dropdown);
            categorySelectionDropdowns[index].innerHTML = '<option>Select A Category</option>';
            categories.forEach(category => {
                const subcategories = variables.filter((variable) => variable['is-subcategory'] === true && (variable.scope.type === 'full-game' || variable.scope.type === 'global') && (variable.category === null ))[0];
                if (subcategories !== undefined) {
                    for (let [key, value] of Object.entries(subcategories.values.values)) {
                        const option = document.createElement('option');
                        option.value = category.id + '+var-' + subcategories.id + '=' + key;
                        option.innerText = category.name + ' (' + value.label + ')';
                        categorySelectionDropdowns[index].appendChild(option);
                    }
                } else {
                    const option = document.createElement('option');
                    option.value = category.id + '+';
                    option.innerText = category.name;
                    categorySelectionDropdowns[index].appendChild(option);
                }
            });

        });
    }

    function addRemoveButton(columnContainer, eventListener) {
        const button = document.createElement('button');
        const minusIcon = document.createElement('span');

        button.setAttribute('class', 'btn btn-danger removeCategoryUrl d-block mb-3');
        minusIcon.setAttribute('class', 'fa-solid fa-minus');

        button.appendChild(minusIcon);
        columnContainer.appendChild(button);

        eventListener(button, columnContainer);
    }
});
