document.addEventListener("DOMContentLoaded", main);

const DEBOUNCE_DELAY = 200;

const HACK_NAME_COLUMN_INDEX = 0;
const AUTHOR_NAME_COLUMN_INDEX = 1;
const HACK_DATE_COLUMN_INDEX = 2;
const HACK_DOWNLOADS_COLUMN_INDEX = 3;
const TAG_COLUMN_INDEX = 4;

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
    const data = await getData();
    const hacksTable = getHacksTable(data);
    const hacksCollectionDiv = document.querySelector("#hacksCollection");
    hacksCollectionDiv.innerHTML = hacksTable;
    const myTable = document.getElementById("hacksTable");

    if (document.getElementById("hack_release_date") != null) document.getElementById("hack_release_date").setAttribute("max", new Date().toISOString().slice(0, 10));



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

    const hackNamesInput = document.getElementById("hackNamesInput");
    setHackNamesFilterHandler(hackNamesInput, tableRowContents);

    const authorNamesInput = document.getElementById("authorNamesInput");
    setAuthorNamesFilterHandler(authorNamesInput, tableRowContents);

    const hackDatesInput = document.getElementById("hackDatesInput");
    setHackDatesFilterHandler(hackDatesInput, tableRowContents);

    const tagInput = document.getElementById("tagInput");
    setTagFilterHandler(tagInput, tableRowContents);

    const sortInput = document.getElementById('sortInput');
    sortInput.addEventListener("change", debounce((onChange) => {
        const sortRequirement = onChange.target.value;
        console.log(sortRequirement)
        data.hacks.sort((a, b) => {
            switch (sortRequirement) {
                case "hack_name_asc":
                    return a.hack_name.toLowerCase() > b.hack_name.toLowerCase();
                case "hack_name_desc":
                    return b.hack_name.toLowerCase() > a.hack_name.toLowerCase();
                case "hack_release_date_asc":
                    return new Date(a.release_date) - new Date(b.releaseDate);
                case "hack_release_date_desc":
                    return new Date(b.releaseDate) - new Date(a.releaseDate);
                case "hack_download_count_asc":
                    return Number(a.total_downloads) - Number(b.total_downloads);
                case "hack_download_count_desc":
                    return Number(b.total_downloads) - Number(a.total_downloads);
                default:
                    return a.hack_name.toLowerCase() - b.hack_name.toLowerCase();
            }
        })
    }))
}

/**
 * @returns {Hack[]}
 */
async function getData() {
    try {
        const response = await fetch(`/api/v1/hacks`);
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
function getHacksTable(hacks) {
    const headerRow = getHacksTableHeaderRow();
    const hackTableRows = hacks.map((hack) => getTableRowFromHack(hack)).join("");

    return `
    <table class="table table-sm table-bordered table-hover" id="hacksTable">
      ${headerRow}
      ${hackTableRows}
    </table>
  `;
}

/**
 * @returns {string}
 */
function getHacksTableHeaderRow() {

    return `
    <tr>
      <th><b>Hackname</b></th>
      <th class="creator"><b>Creator</b></th>
      <th class="text-nowrap">Initial Release Date</th>
      <th>Starcount</th>
      <th>Downloads</th>
      <th hidden>Tag</th>
    </tr>
  `;
}

/**
 * @param {Hack} hack
 * @returns {string}
 */
function getTableRowFromHack(hack) {
    const id = hack.id;
    const name = hack.name;
    const authors = (hack.authors).join(', ');
    const releaseDate = hack.release_date;
    const tag = (hack.tags).join(', ');
    const downloads = hack.total_downloads;
    const starcount = hack.starcount

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