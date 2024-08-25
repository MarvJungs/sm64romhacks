document.addEventListener("DOMContentLoaded", main);

const DEBOUNCE_DELAY = 200;

const HACK_NAME_COLUMN_INDEX = 0;
const AUTHOR_NAME_COLUMN_INDEX = 1;
const HACK_DATE_COLUMN_INDEX = 2;
const HACK_DOWNLOADS_COLUMN_INDEX = 4;
const TAG_COLUMN_INDEX = 5;

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

async function main() {
    let url = '/api/v1/hacks';
    const hacksTableBody = document.getElementById('hacksTableBody');
    const myTable = document.getElementById("hacksTable");
    const data = await getData(url);
    const hacksTable = getHackTableRows(data);
    hacksTableBody.innerHTML += hacksTable;

    /** @type {HackTableRowContent[]} */
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

    const params = getSearchQuery();

    const hackNamesInput = document.getElementById("hacknameFilter");
    setHackNamesFilterHandler(hackNamesInput, tableRowContents);

    const authorNamesInput = document.getElementById("authornameFilter");
    setAuthorNamesFilterHandler(authorNamesInput, tableRowContents);

    const hackDatesInput = document.getElementById("releasedateFilter");
    setHackDatesFilterHandler(hackDatesInput, tableRowContents);

    const tagInput = document.getElementById("tagFilter");
    setTagFilterHandler(tagInput, tableRowContents);

    const headers = Array.from(myTable.rows[0].children);
    headers.forEach((header) => {
        header.addEventListener('click', () => {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('order', header.id);
            if (header.id == params.order || !params.order) {
                urlParams.set('direction', 'desc');
            }
            else {
                urlParams.set('direction', 'asc');
            }
            window.location.search = urlParams;
        });
    });

    const index = headers.findIndex((header) => header.id == params.order);
    if (index == -1) {
        sortTable(0, 'asc');
    }
    else {
        sortTable(index, params.direction);
    }
}

function sortTable(columnIndex, direction) {
    const table = document.getElementById("hacksTable");
    const rows = Array.from(table.rows).slice(1);

    rows.sort((rowA, rowB) => {
        let cellA = rowA.cells[columnIndex].innerText.toLowerCase();
        let cellB = rowB.cells[columnIndex].innerText.toLowerCase();
        let factor;
        if (direction == 'desc') {
            factor = -1;
        }
        else {
            factor = 1;
        }

        switch (columnIndex) {
            case 0:
            case 1:
                return factor * cellA.localeCompare(cellB);
            case 2:
                return factor * (new Date(cellA) - new Date(cellB));
            case 3:
                return factor * (Number(cellA) - Number(cellB));
            case 4:
                cellA = cellA.replace('downloads: ', '');
                cellB = cellB.replace('downloads: ', '');
                return factor * (Number(cellA) - Number(cellB));
            default:
                break;
        }
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
}

function getSearchQuery() {
    const urlParams = new URLSearchParams(window.location.search);
    return {
        order: urlParams.get('order'),
        direction: urlParams.get('direction')
    };
}

/**
 * @returns {Hack[]}
 */
async function getData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`${response.status} ${response.statusText}`);
        }
        const r = await response.json()
        return r;
    }
    catch (error) {
        console.log(error);
    }
}

/**
 * @param {Hack[]} hacks
 * @returns {string}
 */
function getHackTableRows(hacks) {
    const hackTableRows = hacks.map((hack) => getTableRowFromHack(hack)).join("");

    return `
      ${hackTableRows}
  `;
}

/**
 * @param {Hack} hack
 * @returns {string}
 */
function getTableRowFromHack(hack) {
    const id = hack.id;
    const name = hack.name;
    const versionData = getVersionsData(hack);
    const authors = versionData.authors;
    const releaseDate = versionData.releaseDate;
    const tag = (hack.tags).join(', ');
    const downloads = versionData.downloads;
    const starcount = versionData.starcount

    return `
    <tr>
      <td><a href="/hacks/${id}">${name}</a></td>
      <td>${authors}</td>
      <td class="text-nowrap">${releaseDate}</td>
      <td>${starcount}</td>
      <td class="text-nowrap text-muted">Downloads: ${downloads}</td>
      <td hidden>${tag}</td>
    </tr>
  `;
}

function getVersionsData(hack) {
    const versions = hack.versions;
    if(versions.length == 0) {
        return {
            authors: 'unknown',
            releaseDate: '9999-12-31',
            downloads: 0,
            starcount: 0
        }
    }
    return {
        authors: versions[0].authors.map((author) => author.name).join(', '),
        releaseDate: versions[0].releasedate,
        downloads: getDownloads(versions),
        starcount: getMaxStarcount(versions)
    }
}

function getDownloads(versions) {
    let downloads = 0;
    versions.forEach(version => {
        downloads += version.downloadcount
    });
    return downloads;
}

function getMaxStarcount(versions) {
    let starcount = 0;
    versions.forEach(version => {
        if (version.starcount > starcount) {
            starcount = version.starcount;
        }
    });
    return starcount;
}

/**
 * @param {HTMLInputElement} hackNamesInput
 * @param {HackTableRowContent[]} tableRowContents
 */
function setHackNamesFilterHandler(hackNamesInput, tableRowContents) {
    hackNamesInput.addEventListener("keyup", debounce((keyUpEvent) => {
        const searchString = keyUpEvent.target.value.toUpperCase();
        filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "hackName"));
    }), DEBOUNCE_DELAY);
}

/**
 * @param {HTMLInputElement} authorNamesInput
 * @param {HackTableRowContent[]} tableRowContents
 */
function setAuthorNamesFilterHandler(authorNamesInput, tableRowContents) {
    authorNamesInput.addEventListener("keyup", debounce((keyUpEvent) => {
        const searchString = keyUpEvent.target.value.toUpperCase();
        filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "authorName"));
    }), DEBOUNCE_DELAY);
}

/**
 * @param {HTMLInputElement} hackDatesInput
 * @param {HackTableRowContent[]} tableRowContents
 */
function setHackDatesFilterHandler(hackDatesInput, tableRowContents) {
    hackDatesInput.addEventListener("keyup", debounce((keyUpEvent) => {
        const searchString = keyUpEvent.target.value.toUpperCase();
        filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "hackDate"));
    }), DEBOUNCE_DELAY);
}

/**
 * @param {HTMLSelectElement} tagInput
 * @param {HackTableRowContent[]} tableRowContents
 */
function setTagFilterHandler(tagInput, tableRowContents) {
    tagInput.addEventListener("change", debounce((changeEvent) => {
        const searchString = changeEvent.target.value.toUpperCase();
        filterRows(tableRowContents, isTableRowContentKeySubstring(searchString, "tag"));
    }), DEBOUNCE_DELAY);
}

/**
 * @param {HackTableRowContent[]} tableRowContents
 * @param {FilterPredicate} predicate
 */
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

/**
 * @param {string} searchString
 * @param {SearchKey} keyName
 * @return {FilterPredicate}
 */
function isTableRowContentKeySubstring(searchString, keyName) {
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
function isTableRowContentKeyEqual(searchString, keyName) {
    return (tableRowContent) => {
        if (searchString === "") {
            return true;
        }
        return tableRowContent[keyName] === searchString;
    }
}

/**
 * @param {HTMLTableRowElement} tableRow
 */
function showTableRow(tableRow) {
    tableRow.style.display = "table-row";
}

/**
 * @param {HTMLTableRowElement} tableRow
 */
function hideTableRow(tableRow) {
    tableRow.style.display = "none";
}

/**
 * @function debounce
 * @param {Function} callback function to invoke after calls have been debounced
 * @param {number} delay number of milliseconds of debounce delay
 * 
 * @returns {Function} modified function with debounce logic
 */
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