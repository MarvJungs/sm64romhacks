document.addEventListener("DOMContentLoaded", main);

const DEBOUNCE_DELAY = 200;

const HACK_NAME_COLUMN_INDEX = 0;
const AUTHOR_NAME_COLUMN_INDEX = 1;
const HACK_DATE_COLUMN_INDEX = 2;
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
  const data = await getData();
  const user = await getUser();
  console.log(user);
  const users = await getAllUsers();
  const tagsDropdownMenu = getTagsDropdownMenu(data.tags);
  const hacksTable = getHacksTable(data.hacks, user, users);
  const hacksCollectionDiv = document.querySelector("#hacksCollection");
  hacksCollectionDiv.innerHTML = hacksTable;
  const myTable = document.getElementById("myTable");
  const tagsDropDownElement = document.getElementById('tagInput');
  tagsDropDownElement.innerHTML += tagsDropdownMenu;

  if (document.getElementById("hack_release_date") != null) document.getElementById("hack_release_date").setAttribute("max", new Date().toISOString().slice(0, 10));



  /** @type {HackTableRowContent[]} */
  const tableRowContents = Array.from(myTable.getElementsByTagName("tr")).slice(1).map((tableRow) => {
    const columns = tableRow.getElementsByTagName("td");
    return {
      hackName: columns[HACK_NAME_COLUMN_INDEX].innerText.toUpperCase(),
      authorName: columns[AUTHOR_NAME_COLUMN_INDEX].innerText.toUpperCase(),
      hackDate: columns[HACK_DATE_COLUMN_INDEX].innerText.toUpperCase(),
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
}

/**
 * @returns {Hack[]}
 */
async function getData() {
  try {
    const response = await fetch(`/api/hacks`);
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

async function getUser() {
  try {
    const response = await fetch(`/api/user`);
    if (!response.ok) {
      throw new Error(`${response.status} ${response.statusText}`);
    }
    const r = await response.json()
    return r;
  }
  catch (error) {
    return { logged_in: false, admin: false, data: { twitch_handle: null } };
  }
}

async function getAllUsers() {
  try {
    const response = await fetch(`/api/users`);
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
function getHacksTable(hacks, user, users) {
  const headerRow = getHacksTableHeaderRow(user);
  const hackTableRows = hacks.map((hack) => getTableRowFromHack(hack, user, users)).join("");

  return `
    <table class="table-sm table-bordered" id="myTable">
      ${headerRow}
      ${hackTableRows}
    </table>
  `;
}

function getTagsDropdownMenu(tags) {
  const tagsDropdownMenu = tags.map((tag) => {
    tag = tag.tag_name
    return `<option value="${tag}">${tag}</option>`
  }).join("")
  return tagsDropdownMenu
}

/**
 * @returns {string}
 */
function getHacksTableHeaderRow(user) {

  const addButton = user.logged_in ? `<a class="btn btn-success text-nowrap" href="addHack.php"><img src="/_assets/_img/icons/add.svg"></a>` : `&nbsp;`

  return `
    <tr>
      <th><b>Hackname</b></th>
      <th class="creator"><b>Creator</b></th>
      <th class="text-nowrap">Initial Release Date</th>
      <th>Downloads</th>
      <th hidden>Tag</th>
      <th class="border-0 add-button" colspan="2">${addButton}</th>
    </tr>
  `;
}

/**
 * @param {Hack} hack
 * @returns {string}
 */
function getTableRowFromHack(hack, user, users) {
  const hackName = hack.hack_name;
  const hackURL = hack.hack_url;
  const creators = hack.hack_author
  const releaseDate = hack.release_date;
  const tag = hack.hack_tags;
  const downloads = hack.total_downloads;
  const link = hack.hack_url;
  const deleteButton = checkActionsAbilities(creators, user) ? `<a class="btn btn-danger btn-block text-nowrap" href="deleteHack.php?hack_name=${hackURL}"><img src="/_assets/_img/icons/delete.svg"></a>` : "&nbsp;"
  const editButton = checkActionsAbilities(creators, user) ? `<a class="btn btn-info btn-block text-nowrap" href="editHack.php?hack_name=${hackURL}"><img src="/_assets/_img/icons/edit.svg"></a>` : "&nbsp;";
  const creatorsMarkUp = getCreatorsMarkUp(creators, users);


  // TODO: use the correct relative url path
  // Might need to add this to data.json or use single page app framework

  return `
    <tr>
      <td><a href="/hacks/${link}">${hackName}</a></td>
      <td>${creatorsMarkUp}</td>
      <td class="text-nowrap">${releaseDate}</td>
      <td class="text-nowrap text-muted">Downloads: ${downloads}</td>
      <td hidden>${tag}</td>
      <td class="border-0 delete-button">${deleteButton}</td>
      <td class="border-0 edit-button">${editButton}</td>
    </tr>
  `;
}

function checkActionsAbilities(creators, user) {
  creators = creators.split(", ");
  let r = false;
  creators.forEach((creator) => {
    if (user.admin || user.logged_in && (creator.toLowerCase() === user.data.discord_username.toLowerCase() || user.data.twitch_handle != null && creator.toLowerCase() === user.data.twitch_handle.toLowerCase())) {
      r = true;
      return false;
    }
  })
  return r;
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
  return encodeURIComponent(hackName)
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