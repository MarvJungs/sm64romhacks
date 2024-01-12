
document.addEventListener("DOMContentLoaded", main);

async function main() {
    const allStreams = await getAllStreams();
    const streamsContainer = document.querySelector(".streams");
    const HTMLContent = allStreams.map((stream) => getHTMLContentForStream(stream)).join("");
    streamsContainer.innerHTML = HTMLContent;
}

async function getAllStreams() {
    try {
        const response = await fetch(`/api/streams`);
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

function getHTMLContentForStream(stream) {
    const thumbnail = stream.thumbnail_url.replace("{width}", 1280).replace("{height}", 720);
    const title = stream.title.replaceAll("<", "&lt;").replaceAll(">", "&gt;");
    const viewer_count = stream.viewer_count;
    const user_name = stream.user_name;
    const user_login = stream.user_login;
    const tags = stream.tags;

    if (title.toLowerCase().includes("romhack") || title.toLowerCase().includes("rom hack") || validateTags(tags)) {
        return `
            <div class="stream-container">
                <a href="https://www.twitch.tv/${user_login}" target="_blank_"><img src="${thumbnail}"/></a>
                <h2>${title}</h2>
                <h2>${user_name} (${viewer_count} viewers)</h2>
            </div>
        `
    }



}

function validateTags(tags) {
    let flag = false;
    tags = tags.map((tag) => tag.toLowerCase());
    const whiteList = ["romhack", "rom hack", "hack", "modded"];
    whiteList.forEach(element => {
        if (tags.includes(element)) flag = true;
    });
    return flag;
}