document.addEventListener("DOMContentLoaded", main);

const DEBOUNCE_DELAY = 200;

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

async function main() {

  const data = await getData();
  const user = await getUser();
  const users = await getUsers();
  const templatePageContainer = document.querySelector("#template-page");
  templatePageContainer.innerHTML = getTemplatePageContent(data, user, users);

  const hacksTable = getHacksTable(data.patches, user, users);
  const hacksCollectionDiv = document.querySelector("#hacksCollection");
  const hacksDescriptionDiv = document.querySelector("#hacksDescription");

  hacksCollectionDiv.innerHTML += hacksTable;
  hacksDescriptionDiv.innerHTML = data.patches[0].hack_description;

  const allImages = data.images
  const hacksImagesContent = getHacksImagesContent(allImages);
  const hacksImagesDiv = document.querySelector("#hacksImages");
  hacksImagesDiv.innerHTML = hacksImagesContent;
}

/**
 * @returns {Hack[]}
 */
async function getData() {
  const urlName = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1]
  try {
    const response = await fetch(`/api/hacks?hack_name=${urlName}`);
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

async function getUsers() {
  try {
    const response = await fetch(`/api/users`);
    if (!response.ok) {
      throw new Error(`${response.status} ${response.statusText}`);
    }
    const r = await response.json()
    return r;
  }
  catch (error) {
    console.log(error)
  }

}


function getTemplatePageContent(data, user) {
  console.log(data);
  const hack_name = data.patches[0].hack_name;
  const hack_url = data.patches[0].hack_url;
  //console.log(user)
  const options = user.admin || user.logged_in && (data.patches[0].authors.toLowerCase().includes(user.data.discord_username.toLowerCase()) || user.data.twitch_handle != null && data.patches[0].authors.toLowerCase().includes(user.data.twitch_handle.toLowerCase())) ? `&nbsp;<a class="btn btn-danger text-nowrap" href="deleteHack.php?hack_name=${hack_url}"><img src="/_assets/_img/icons/delete.svg"></a>&nbsp;<a class="btn btn-info text-nowrap" href="editHack.php?hack_name=${hack_url}"><img src="/_assets/_img/icons/edit.svg"></a>` : `&nbsp;`;

  return `
    <h1><u>${hack_name}</u>${options}</h1>
    <div class="table-responsive" id="hacksCollection"></div>
						<div class="text-nowrap" id="hacksImages"></div>
				<br/>
				
                <div class="bg-dark text-left" id="hacksDescription"></div>
  `;
}

/**
 * @param {Hack[]} hacks
 * @returns {string}
 */
function getHacksTable(hacks, user, users) {
  const headerRow = getHacksTableHeaderRow(user);
  const hackTableRows = hacks.map((hack) => getTableRowFromHack(hack, user, users)).join("");

  return `
    <table class="table-sm table-bordered">
      ${headerRow}
      ${hackTableRows}
    </table>
  `;
}

function getHacksImagesContent(images) {
  const imagesContent = images.map((image) => getImage(image)).join("")
  return `
    <div class="container">
      <div class="row">
        ${imagesContent}
      </div>
    </div>`
}

function getImage(image) {
  return `<div class="col"><img class="p-3" width=320 height=240 src="/api/images/${image}"></div>`
}

function getCreatorsMarkUp(creators, users) {
  const data = creators.split(', ');
  const userData = data.map((creator) => {
    const x = users.filter(e => e.discord_username.toLowerCase() === creator.toLowerCase() | e.twitch_handle != null && e.twitch_handle.toLowerCase() === creator.toLowerCase())
    return x.length != 0 ? `<a href="/users/${x[0].discord_id}" target="_blank">${creator}</a>` : creator
  }).join(", ")
  return userData
}

/**
 * @returns {string}
 */
function getHacksTableHeaderRow(user) {
  const hidden = !user.admin ? `hidden` : ``;

  return `
    <tr>
      <th ${hidden}><b>Hack ID</b></th>
      <th><b>Hack Name</b></th>
      <th><b>Hack Version</b></th>
      <th><b>Download Link</b></th>
      <th><b>Creator</b></th>
      <th><b>Starcount</b></th>
      <th><b>Date</b></th>
      <th ${hidden}><b>Tag</b></th>
      <th class="border-0" colspan="3">&nbsp;</th>
    </tr>
  `;
}

/**
 * @param {Hack} hack
 * @returns {string}
 */
function getTableRowFromHack(hack, user, users) {
  const hackID = hack.hack_id;
  const hackName = hack.hack_name;
  const hackVersion = hack.hack_version;
  const hackDownloads = hack.hack_downloads;
  const hackCreator = hack.authors;
  const hackStarcount = hack.hack_starcount;
  const hackReleaseDate = hack.hack_release_date;
  const hackTags = hack.hack_tags;
  const adminLoad = checkActionsAbilities(hackCreator, user) ? `<td class="border-0"><a class="btn btn-danger btn-block text-nowrap" href="deleteHack.php?hack_id=${hackID}"><img src="/_assets/_img/icons/delete.svg"></a></td><td class="border-0"><a class="btn btn-info btn-block text-nowrap" href="editHack.php?hack_id=${hackID}"><img src="/_assets/_img/icons/edit.svg"></a>` : `&nbsp;`
  const hackRecommend = hack.hack_recommend
  const recommendRow = hackRecommend == 1 ? `class=table-primary` : ``
  const creatorsMarkUp = getCreatorsMarkUp(hackCreator, users);
  const hidden = !user.admin ? ` hidden` : ``;


  return `
    <tr>
      <td ${recommendRow}${hidden}>${hackID}</td>
      <td ${recommendRow}>${hackName}</td>
      <td ${recommendRow}>${hackVersion}</td>
      <td ${recommendRow}><a href="/hacks/download.php?hack_id=${hackID}">Download</a><br><span class="text-muted">Downloads: ${hackDownloads}</span></td>
      <td ${recommendRow}>${creatorsMarkUp}</td>
      <td ${recommendRow}>${hackStarcount}</td>
      <td ${recommendRow}>${hackReleaseDate}</td>
      <td ${recommendRow}${hidden}>${hackTags}</td>
      <td class="border-0">${adminLoad}</td>
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
    .replace(/%20/g, '+')
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