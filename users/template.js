document.addEventListener("DOMContentLoaded", main);

async function main() {
    const username = window.location.pathname.replace('/users/', '');
    const data = await getHacksByUser(username);
    console.log(data)

    const templatePageContainer = document.querySelector("#template-page");
    templatePageContainer.innerHTML = getTemplatePageContent(data);
}

async function getHacksByUser(username) {
    try {
        const response = await fetch(`/api/users?user_name=${username}`);
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

function getTemplatePageContent(data) {
    const tableHeaderRow = getTableHeaderRow();
    const tableContent = data.map((hack) => getHackTableRow(hack)).join("");

    const user_id = data[0].discord_id;
    const avatar_id = data[0].discord_avatar;
    const username = data[0].discord_username;

    const template = data[0].author_id ? `
                    <div class="table-responsive">
                        <table class="table-sm table-bordered">
                            ${tableHeaderRow}
                            ${tableContent}
                        </table>
                    </div>
                    ` : "This User has no published Rom Hacks!";

    return `
        <h1><img src="https://cdn.discordapp.com/avatars/${user_id}/${avatar_id}.jpg" height=64 width=64>${username}</h1><hr/>
        ${template}
    `
}

function getTableHeaderRow() {
    return `
        <tr>
            <th><b>Hack Name</b></th>
            <th><b>Creator</b></th>
            <th><b>Release Date</b></th>
        </tr>
    `
}

function getHackTableRow(hack) {
    const hack_name = hack.hack_name;
    const creator = hack.author_name;
    const release_date = hack.hack_release_date;

    return `
        <tr>
            <td><a href="/hacks/${getURLName(hack_name)}">${hack_name}</a></td>
            <td>${creator}</td>
            <td>${release_date}</td>
        </tr>
    `;
}

function getURLName(hackName) {
    hackName = (hackName + '')
    hackName = hackName.replaceAll(':', '_')
    return encodeURIComponent(hackName)
        .replace(/!/g, '%21')
        .replace(/'/g, '%27')
        .replace(/\(/g, '%28')
        .replace(/\)/g, '%29')
        .replace(/\*/g, '%2A')
        .replace(/~/g, '%7E')
        .replace(/%20/g, '+')
}
