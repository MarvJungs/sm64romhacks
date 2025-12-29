export default class MegapackFilter {
    #HACK_NAME_COLUMN_INDEX = 0;
    #AUTHOR_NAME_COLUMN_INDEX = 1;
    #STAR_COUNT_COLUMN_INDEX = 2;
    #HACK_DATE_COLUMN_INDEX = 3;
    #TAG_COLUMN_INDEX = 4;

    main() {
        const difficultyFilter = document.getElementById('difficultyFilter');
        if (!difficultyFilter) return;

        const normalHacksTable = document.getElementById('normalHacks');
        const kaizoHacksTable = document.getElementById('kaizoHacks');

        const tableRowContents = Array.from(normalHacksTable.getElementsByTagName('tr')).slice(1).map((tableRow) => {
            const columns = tableRow.getElementsByTagName('td');

            return {
                hackName: columns[this.#HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
                authorName: columns[this.#AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
                starcount: columns[this.#STAR_COUNT_COLUMN_INDEX].innerText.toUpperCase(),
                hackDate: columns[this.#HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
                tag: columns[this.#TAG_COLUMN_INDEX].innerText.toUpperCase(),
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
            this.#filterRows(tableRowContents, this.#isTableRowContentKeyEqual(filterString, "tag"));
        });
    }

    #isTableRowContentKeyEqual(searchString, keyName) {
        return (tableRowContent) => {
            if (searchString === "") {
                return true;
            }
            return tableRowContent[keyName] == (searchString);
        }
    }

    #filterRows(tableRowContents, predicate) {
        tableRowContents.forEach((tableRowContent) => {
            const tableRow = tableRowContent.tableRow;
            if (predicate(tableRowContent)) {
                this.#showTableRow(tableRow);
            } else {
                this.#hideTableRow(tableRow);
            }
        });
    }

    #showTableRow(tableRow) {
        tableRow.hidden = false;
    }

    #hideTableRow(tableRow) {
        tableRow.hidden = true;
    }
}