import { Tooltip } from "bootstrap";

export default class HacksTable {

    #DEBOUNCE_DELAY = 200;

    #HACK_MEGAPACK_COLUMN_INDEX = 0;
    #HACK_NAME_COLUMN_INDEX = 1;
    #AUTHOR_NAME_COLUMN_INDEX = 2;
    #HACK_DATE_COLUMN_INDEX = 3;
    #HACK_DOWNLOADS_COLUMN_INDEX = 5;
    #TAG_COLUMN_INDEX = 6;

    #SVG_AWARD = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-award" viewBox="0 0 16 16"><path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702z"/><path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z"/></svg>';

    /**
     * @typedef {Object} HackTableRowContent
     * @property {string} megapack
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
     * @property {boolean} megapack
     */

    /**
     * @typedef {"hackName" | "authorName" | "hackDate" | "tag" | "megapack"} SearchKey
     */

    /**
     * @typedef {(tableRowContent: HackTableRowContent) => boolean} FilterPredicate
     */

    async main() {
        this.section = document.getElementById('hacksTable');
        if (!this.section) return;
        this.table = await this.getTable();
        this.updateCounter(Array.from(this.table.rows).length - 1);
        this.section.appendChild(this.table);
        this.removeSpinner();

        /** @type {HackTableRowContent[]} */
        const tableRowContents = Array.from(this.table.getElementsByTagName("tr")).slice(1).map((tableRow) => {
            const columns = tableRow.getElementsByTagName("td");
            return {
                megapack: columns[this.#HACK_MEGAPACK_COLUMN_INDEX],
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

        const megapackInput = document.getElementById('megapackFilter');
        this.setMegapackFilterHandler(megapackInput, tableRowContents);

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
            { label: '', hidden: false },
            { label: 'Hackname', hidden: false },
            { label: 'Creator', hidden: false },
            { label: 'Release Date', hidden: false },
            { label: 'Starcount', hidden: false },
            { label: 'Downloads', hidden: false },
            { label: 'Tags', hidden: true },
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
            const iconData = document.createElement('td');
            const nameData = document.createElement('td');
            const creatorData = document.createElement('td');
            const releaseData = document.createElement('td');
            const starcountData = document.createElement('td');
            const downloadsData = document.createElement('td');
            const tagsData = document.createElement('td');

            if (element.megapack) {
                const span = document.createElement('span');
                span.setAttribute('data-bs-toggle', 'tooltip');
                span.setAttribute('data-bs-placement', 'top');
                span.setAttribute('data-bs-title', 'Megapack Certified');
                span.innerHTML = this.#SVG_AWARD;
                iconData.appendChild(span);
                new Tooltip(span);
                iconData.value = 1;
            } else {
                iconData.value = 0;
            }

            downloadsData.classList.add('text-muted');
            row.id = element.slug;

            releaseData.classList.add('text-nowrap');

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

            row.appendChild(iconData);
            row.appendChild(nameData);
            row.appendChild(creatorData);
            row.appendChild(releaseData);
            row.appendChild(starcountData);
            row.appendChild(downloadsData);
            row.appendChild(tagsData);

            tableBody.appendChild(row);
        });

        return tableBody;
    }

    async getData(url) {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }

    removeSpinner() {
        const spinnerContainer = document.getElementById('spinner');
        spinnerContainer.remove();
    }

    /**
 * @param {HTMLInputElement} hackNamesInput
 * @param {HackTableRowContent[]} tableRowContents
 */
    setHackNamesFilterHandler(hackNamesInput, tableRowContents) {
        hackNamesInput.addEventListener("keyup", this.debounce((keyUpEvent) => {
            const searchString = keyUpEvent.target.value.toUpperCase();
            this.filterRows(tableRowContents, this.isTableRowContentKeySubstring(searchString, "hackName"));
            this.updateCounter(Array.from(this.table.rows).filter(row => row.style.display == "table-row").length);
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
            this.updateCounter(Array.from(this.table.rows).filter(row => row.style.display == "table-row").length);
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
            this.updateCounter(Array.from(this.table.rows).filter(row => row.style.display == "table-row").length);
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
            this.updateCounter(Array.from(this.table.rows).filter(row => row.style.display == "table-row").length);
        }), this.#DEBOUNCE_DELAY);
    }

        /**
     * @param {HTMLSelectElement} megapackInput
     * @param {HackTableRowContent[]} tableRowContents
     */
    setMegapackFilterHandler(megapackInput, tableRowContents) {
        megapackInput.addEventListener("change", this.debounce((changeEvent) => {
            const filter = changeEvent.target.checked;
            console.log(filter);
            this.filterRows(tableRowContents, this.isTableRowContentMegapack(filter, "megapack"));
            this.updateCounter(Array.from(this.table.rows).filter(row => row.style.display == "table-row").length);
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
     * @param {boolean} filter
     * @param {SearchKey} keyName
     * @return {FilterPredicate}
     */
    isTableRowContentMegapack(filter, keyName) {
        return (tableRowContents) => {
            return !filter ? true : Boolean(tableRowContents[keyName].value);
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

    updateCounter(number) {
        const counterElement = document.getElementById('counter');
        counterElement.innerText = Number(number);
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