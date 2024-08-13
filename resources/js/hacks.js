document.addEventListener('DOMContentLoaded', function () {

    const DEBOUNCE_DELAY = 200;

    const HACK_NAME_COLUMN_INDEX = 0;
    const AUTHOR_NAME_COLUMN_INDEX = 1;
    const HACK_DATE_COLUMN_INDEX = 2;
    const HACK_DOWNLOADS_COLUMN_INDEX = 4;
    const TAG_COLUMN_INDEX = 5;

    const myTable = document.getElementById("hacksCollection");
    if(!myTable) return;

    const tableRowContents = Array.from(myTable.getElementsByTagName("tr")).slice(1).map((tableRow) => {
        const columns = tableRow.getElementsByTagName("td");
        return {
            hackName: columns[HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
            authorName: columns[AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
            hackDate: columns[HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
            hackDownloads: Number(columns[HACK_DOWNLOADS_COLUMN_INDEX].innerText.replace("Downloads: ", "")),
            tag: columns[TAG_COLUMN_INDEX].innerText.toUpperCase(),
            tableRow,
        }
    });

    const sortDropdown = document.getElementById('sortDropdown');
    sortDropdown.addEventListener('change', (event) => {
        const queryParams = event.target.value.split('_');
        const sortBy = queryParams[0];
        const direction = queryParams[1];
        const sortQuery = 'sortBy=' + sortBy + '&direction=' + direction; 
        window.location.search = sortQuery;
    });

    const hackNamesInput = document.getElementById("hacknameFilter");
    setHackNamesFilterHandler(hackNamesInput, tableRowContents);

    const authorNamesInput = document.getElementById("hackauthorFilter");
    setAuthorNamesFilterHandler(authorNamesInput, tableRowContents);

    const hackDatesInput = document.getElementById("releasedateFilter");
    setHackDatesFilterHandler(hackDatesInput, tableRowContents);

    const tagInput = document.getElementById("tagFilter");
    setTagFilterHandler(tagInput, tableRowContents);

    function setHackNamesFilterHandler(hackNamesInput, tableRowContents) {
        hackNamesInput.addEventListener("keyup", debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "hackName"));
        }), DEBOUNCE_DELAY);
    }

    function setAuthorNamesFilterHandler(authorNamesInput, tableRowContents) {
        authorNamesInput.addEventListener("keyup", debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "authorName"));
        }), DEBOUNCE_DELAY);
    }

    function setHackDatesFilterHandler(hackDatesInput, tableRowContents) {
        hackDatesInput.addEventListener("keyup", debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value;
            filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "hackDate"));
        }), DEBOUNCE_DELAY);
    }

    function setTagFilterHandler(tagInput, tableRowContents) {
        tagInput.addEventListener("change", debounce((changeEvent) => {
            const searchString = changeEvent.target.value.toUpperCase();
            filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "tag"));
        }), DEBOUNCE_DELAY);
    }

    function filterRows(tableRowContents, predicate) {
        tableRowContents.forEach((tableRowContent) => {
            const tableRow = tableRowContent.tableRow;
            if (predicate(tableRowContent)) {
                showTableRow(tableRow);
            } else {
                hideTableRow(tableRow);
            }
        });
    }

    function isTableRowContentKeySubstring(searchString, keyName) {
        return (tableRowContent) => {
            if (searchString === "") {
                return true;
            }
            return tableRowContent[keyName].includes(searchString);
        }
    }

    function isTableRowContentKeyEqual(searchString, keyName) {
        return (tableRowContent) => {
            if (searchString === "") {
                return true;
            }
            return tableRowContent[keyName] === searchString;
        }
    }

    function showTableRow(tableRow) {
        tableRow.style.display = "table-row";
    }

    function hideTableRow(tableRow) {
        tableRow.style.display = "none";
    }

    function debounce(callback, delay) {
        let timeout;

        return function debouncedFunction(...args) {
            const delayedFunction = () => {
                clearTimeout(timeout);
                callback(...args);
            };

            clearTimeout(timeout);
            timeout = setTimeout(delayedFunction, delay);
        };
    }
});