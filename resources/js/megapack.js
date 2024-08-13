import { computeStyles } from "@popperjs/core";

const HACK_NAME_COLUMN_INDEX = 0;
const AUTHOR_NAME_COLUMN_INDEX = 1;
const STAR_COUNT_COLUMN_INDEX = 2;
const HACK_DATE_COLUMN_INDEX = 3;
const TAG_COLUMN_INDEX = 4;

document.addEventListener('DOMContentLoaded', function () {
    const difficultyFilter = document.getElementById('difficultyFilter');
    if (!difficultyFilter) return;

    const normalHacksTable = document.getElementById('normalHacks');
    const kaizoHacksTable = document.getElementById('kaizoHacks');

    const tableRowContents = Array.from(normalHacksTable.getElementsByTagName('tr')).slice(1).map((tableRow) => {
        const columns = tableRow.getElementsByTagName('td');

        return {
            hackName: columns[HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
            authorName: columns[AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
            starcount: columns[STAR_COUNT_COLUMN_INDEX].innerText.toUpperCase(),
            hackDate: columns[HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
            tag: columns[TAG_COLUMN_INDEX].innerText.toUpperCase(),
            tableRow
        }
    });

    difficultyFilter.addEventListener('change', (event) => {
        const filterString = event.target.value.toUpperCase();


        if (filterString == 'KAIZO') {
            normalHacksTable.hidden = true;
            kaizoHacksTable.hidden = false;
        }
        else if (filterString == '') {
            normalHacksTable.hidden = false;
            kaizoHacksTable.hidden = false;
        }
        else {
            normalHacksTable.hidden = false;
            kaizoHacksTable.hidden = true;
        }
        filterRows(tableRowContents, isTableRowContentKeyEqual(filterString, "tag"));
    });
});

function isTableRowContentKeyEqual(searchString, keyName) {
    return (tableRowContent) => {
        if (searchString === "") {
            return true;
        }
        return tableRowContent[keyName] == (searchString);
    }
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

function showTableRow(tableRow) {
    tableRow.hidden = false;
}

function hideTableRow(tableRow) {
    tableRow.hidden = true;
}