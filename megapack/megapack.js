document.addEventListener("DOMContentLoaded", main);

const DEBOUNCE_DELAY = 200;

const HACK_NAME_COLUMN_INDEX = 0;
const AUTHOR_NAME_COLUMN_INDEX = 1;
const STAR_COUNT_COLUMN_INDEX = 2;
const HACK_DATE_COLUMN_INDEX = 3;
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
 * @property {string} name
 * @property {HackVersion[]} versions
 * @property {string} releaseDate
 * @property {string} tag
 */

/**
 * @typedef HackVersion
 * @property {string} versionName
 * @property {string[]} creators
 * @property {string} starCount // maybe this should be a number instead for sorting purposes
 * @property {string} fileName
 */

/**
 * @typedef {"hackName" | "authorName" | "hackDate" | "tag"} SearchKey
 */

/**
 * @typedef {(tableRowContent: HackTableRowContent) => boolean} FilterPredicate
 */


async function main() {
  const normalHacks = await getNormalHacks();
  const normalHacksTable = getHacksTable(normalHacks);
  const normalHacksCollectionDiv = document.querySelector("#normalmegapack");
  normalHacksCollectionDiv.innerHTML += normalHacksTable;

  const kaizoHacks = await getKaizoHacks();
  const kaizoHacksTable = getHacksTable(kaizoHacks);
  const kaizoHacksCollectionDiv = document.querySelector("#kaizomegapack");
  kaizoHacksCollectionDiv.innerHTML += kaizoHacksTable;

  const tables = document.getElementsByClassName('myTable');

  for (let myTable of tables) {
    /** @type {HackTableRowContent[]} */
    const tableRowContents = Array.from(myTable.getElementsByTagName("tr")).slice(1).map((tableRow) => {
      const columns = tableRow.getElementsByTagName("td");
      return {
        hackName: columns[HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
        authorName: columns[AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
        starcount: columns[STAR_COUNT_COLUMN_INDEX].innerText.toUpperCase(),
        hackDate: columns[HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
        tag: columns[TAG_COLUMN_INDEX].innerText.toUpperCase(),
        tableRow,
      }
    });

    const tagInput = document.getElementById("tagInput");
    tagInput.value = "";
    setTagFilterHandler(tagInput, tableRowContents);

  }



}

/**
 * @returns {Hack[]}
 */
async function getNormalHacks() {
  try {
    const response = await fetch(`/api/megapack?type=normal`);
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
 * @returns {Hack[]}
 */
async function getKaizoHacks() {
  try {
    const response = await fetch(`/api/megapack?type=kaizo`);
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
    <table class="table-sm table-bordered myTable">
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
      <th><b>Star Count</b></th>
      <th><b>Release Date</b></th>
      <th>Tags</th>
    </tr>
  `;
}

/**
 * @param {Hack} hack
 * @returns {string}
 */
function getTableRowFromHack(hack) {
  const hackName = hack.hack_name;
  const creators = hack.hack_author
  const releaseDate = hack.hack_release_date;
  const starcount = hack.hack_starcount;
  const link = getURLName(hackName);
  const tags = hack.hack_tags;
  //const creatorsMarkUp = getCreatorsMarkUp(creators, users);


  // TODO: use the correct relative url path
  // Might need to add this to data.json or use single page app framework

  return `
    <tr>
      <td><a href="/hacks/${link}">${hackName}</a></td>
      <td>${creators}</td>
      <td>${starcount}</td>
      <td class="text-nowrap">${releaseDate}</td>
      <td>${tags}</td>
    </tr>
  `;
}

function getCreatorsMarkUp(creators, users) {
  const data = creators.split(', ');
  const userData = data.map((creator) => {
    const x = users.filter(e => e.discord_username === creator || e.twitch_handle != null && e.twitch_handle === creator)
    return x.length != 0 ? `<a href="/users/${x[0].discord_id}" target="_blank">${creator}</a>` : creator
  }).join(", ")
  return userData
}

function getURLName(hackName) {
  hackName = (hackName + '')
  hackName = hackName.replaceAll(':', '_');
  return encodeURIComponent(hackName)
    .replace(/!/g, '%21')
    .replace(/'/g, '%27')
    .replace(/\(/g, '%28')
    .replace(/\)/g, '%29')
    .replace(/\*/g, '%2A')
    .replace(/~/g, '%7E')
}

/**
* @param {HTMLSelectElement} tagInput
* @param {HackTableRowContent[]} tableRowContents
*/
function setTagFilterHandler(tagInput, tableRowContents) {
  tagInput.addEventListener("change", debounce((changeEvent) => {
    const searchString = changeEvent.target.value.toUpperCase();
    const normalmegapackdiv = document.getElementById('normalmegapack');
    const kaizomegapackdiv = document.getElementById('kaizomegapack');
    console.log(normalmegapackdiv.style, kaizomegapackdiv.style)
    if (searchString === 'KAIZO') {
      normalmegapackdiv.style.display = "none";
      kaizomegapackdiv.style.display = "block";
    }
    else if (searchString === '') {
      normalmegapackdiv.style.display = "block";
      kaizomegapackdiv.style.display = "block";
    }
    else {
      normalmegapackdiv.style.display = "block";
      kaizomegapackdiv.style.display = "none";
    }
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