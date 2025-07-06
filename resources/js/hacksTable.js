import FuckYou from "./FuckYou";

export default class HacksTable {

    #DEBOUNCE_DELAY = 200;

    #HACK_NAME_COLUMN_INDEX = 0;
    #AUTHOR_NAME_COLUMN_INDEX = 1;
    #HACK_DATE_COLUMN_INDEX = 2;
    #HACK_DOWNLOADS_COLUMN_INDEX = 4;
    #TAG_COLUMN_INDEX = 5;

    /**
     * @typedef {Object} HackTableRowContent
     * @property {string} hackName
     * @property {string} authorName
     * @property {string} hackDate
     * @property {string} tag
     * @property {HTMLTableRowElement} tableRow
     */

    /**
     * @typedef Hack
     * @property {string[]} authors
     * @property {string} id
     * @property {string} name
     * @property {string} release_date
     * @property {Number} starcount
     * @property {string[]} tags
     * @property {Number} total_downloads
     */

    /**
     * @typedef {"hackName" | "authorName" | "hackDate" | "tag"} SearchKey
     */

    /**
     * @typedef {(tableRowContent: HackTableRowContent) => boolean} FilterPredicate
     */
    
    async main() {
        this.section = document.getElementById('hacksTable');
        if (!this.section) return;
        const table = await this.getTable();
        this.section.appendChild(table);
        this.removeSpinner();

        /** @type {HackTableRowContent[]} */
        const tableRowContents = Array.from(table.getElementsByTagName("tr")).slice(1).map((tableRow) => {
            const columns = tableRow.getElementsByTagName("td");
            return {
                hackName: columns[this.#HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
                authorName: columns[this.#AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
                hackDate: columns[this.#HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
                hackDownloads: Number(columns[this.#HACK_DOWNLOADS_COLUMN_INDEX].innerText.replace("Downloads: ", "")),
                tag: columns[this.#TAG_COLUMN_INDEX].innerText.toUpperCase(),
                tableRow,
            }
        });

        const hackNamesInput = document.getElementById("hacknameFilter");
        this.setHackNamesFilterHandler(hackNamesInput, tableRowContents);

        const authorNamesInput = document.getElementById("authornameFilter");
        this.setAuthorNamesFilterHandler(authorNamesInput, tableRowContents);

        const hackDatesInput = document.getElementById("releasedateFilter");
        this.setHackDatesFilterHandler(hackDatesInput, tableRowContents);

        const tagsInput = document.getElementById("tagsFilter");
        this.setTagFilterHandler(tagsInput, tableRowContents);
    }

    async getTable() {
        const table = document.createElement('table');
        const tableHeader = this.getTableHeader();
        const tableBody = await this.getTableBody();

        table.classList.add('table', 'table-hover', 'table-responsive');

        table.appendChild(tableHeader);
        table.appendChild(tableBody);
        return table;
    }

    getTableHeader() {
        const tableHeader = document.createElement('thead');
        const row = document.createElement('tr');
        const headerElements = [
            {label: 'Hackname', hidden: false}, 
            {label: 'Creator', hidden: false}, 
            {label: 'Release Date', hidden: false}, 
            {label: 'Starcount', hidden: false}, 
            {label: 'Downloads', hidden: false}, 
            {label: 'Tags', hidden: true},
            // {label: 'Actions', hidden: false}
        ];
        headerElements.forEach((element) => {
            const data = document.createElement('th');
            data.innerText = element.label;
            data.hidden = element.hidden;
            row.appendChild(data);
        });
        tableHeader.appendChild(row);
        return tableHeader;
    }

    async getTableBody() {
        let json = await this.getData('/api/v1/hacks');
        const tableBody = document.createElement('tbody');

        json.data.forEach(element => {
            const row = document.createElement('tr');
            const nameData = document.createElement('td');
            const creatorData = document.createElement('td');
            const releaseData = document.createElement('td');
            const starcountData = document.createElement('td');
            const downloadsData = document.createElement('td');
            const tagsData = document.createElement('td');
            const actions = document.createElement('td');

            downloadsData.classList.add('text-muted');
            row.id = element.slug;

            const anchor = document.createElement('a');
            anchor.innerText = element.name;
            anchor.href = `/hacks/${element.slug}`;
            nameData.appendChild(anchor);

            releaseData.innerText = element.releasedate;
            starcountData.innerText = element.starcount;
            downloadsData.innerText = `Downloads: ${element.downloads}`;
            creatorData.innerText = [... new Set(element.versions.flatMap((v => {
                const authors = v.authors.map(a => a.name);
                return authors;
            })))].join(', ');
            
            tagsData.innerText = element.tags.map((t) => t.name).join(', ');
            tagsData.hidden = true;

            const deleteButton = document.createElement('a');
            const deleteIcon = document.createElement('img');

            deleteIcon.src = '/icons/delete.svg';
            deleteButton.classList.add('btn', 'btn-danger');
            deleteButton.href = `/hacks/${element.slug}/delete`;
            deleteButton.appendChild(deleteIcon);

            actions.appendChild(deleteButton);


            row.appendChild(nameData);
            row.appendChild(creatorData);
            row.appendChild(releaseData);
            row.appendChild(starcountData);
            row.appendChild(downloadsData);
            row.appendChild(tagsData);
            // row.appendChild(actions);

            tableBody.appendChild(row);
        });

        return tableBody;
    }

    async getData(url) {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }

    removeSpinner()
    {
       const spinnerContainer = document.getElementById('spinner');
       spinnerContainer.remove(); 

        const fuck = new FuckYou();
        fuck.main();
    }

    /**
 * @param {HTMLInputElement} hackNamesInput
 * @param {HackTableRowContent[]} tableRowContents
 */
    setHackNamesFilterHandler(hackNamesInput, tableRowContents) {
        hackNamesInput.addEventListener("keyup", this.debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            this.filterRows(tableRowContents, this.isTableRowContentKeySubstring(searchString, "hackName"));
        }), this.#DEBOUNCE_DELAY);
    }

    /**
     * @param {HTMLInputElement} authorNamesInput
     * @param {HackTableRowContent[]} tableRowContents
     */
    setAuthorNamesFilterHandler(authorNamesInput, tableRowContents) {
        authorNamesInput.addEventListener("keyup", this.debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            this.filterRows(tableRowContents, this.isTableRowContentKeySubstring(searchString, "authorName"));
        }), this.#DEBOUNCE_DELAY);
    }

    /**
     * @param {HTMLInputElement} hackDatesInput
     * @param {HackTableRowContent[]} tableRowContents
     */
    setHackDatesFilterHandler(hackDatesInput, tableRowContents) {
        hackDatesInput.addEventListener("keyup", this.debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            this.filterRows(tableRowContents, this.isTableRowContentKeySubstring(searchString, "hackDate"));
        }), this.#DEBOUNCE_DELAY);
    }

    /**
     * @param {HTMLSelectElement} tagInput
     * @param {HackTableRowContent[]} tableRowContents
     */
    setTagFilterHandler(tagInput, tableRowContents) {
        tagInput.addEventListener("change", this.debounce((changeEvent) => {
            const searchString = changeEvent.target.value.toUpperCase();
            this.filterRows(tableRowContents, this.isTableRowContentKeyIncluded(searchString, "tag"));
        }), this.#DEBOUNCE_DELAY);
    }

    /**
     * @param {HackTableRowContent[]} tableRowContents
     * @param {FilterPredicate} predicate
     */
    filterRows(tableRowContents, predicate) {
        tableRowContents.forEach((tableRowContent) => {
            const tableRow = tableRowContent.tableRow;
            if (predicate(tableRowContent)) {
                this.showTableRow(tableRow);
            } else {
                this.hideTableRow(tableRow);
            }
        });
    }

    /**
     * @param {string} searchString
     * @param {SearchKey} keyName
     * @return {FilterPredicate}
     */
    isTableRowContentKeySubstring(searchString, keyName) {
        return (tableRowContent) => {
            if (searchString === "") {
                return true;
            }
            return tableRowContent[keyName].includes(searchString);
        }
    }

    /**
     * @param {string} searchString
     * @param {SearchKey} keyName
     * @return {FilterPredicate}
     */
    isTableRowContentKeyIncluded(searchString, keyName) {
        return (tableRowContent) => {
            if (searchString === "") {
                return true;
            }
            const elements = searchString.split(', ');
            return elements.includes(tableRowContent[keyName]);
        }
    }

    /**
     * @param {HTMLTableRowElement} tableRow
     */
    showTableRow(tableRow) {
        tableRow.style.display = "table-row";
    }

    /**
     * @param {HTMLTableRowElement} tableRow
     */
    hideTableRow(tableRow) {
        tableRow.style.display = "none";
    }

    /**
     * @function debounce
     * @param {Function} callback function to invoke after calls have been debounced
     * @param {number} delay number of milliseconds of debounce delay
     * 
     * @returns {Function} modified function with debounce logic
     */
    debounce(callback, delay) {
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
}