document.addEventListener("DOMContentLoaded", main);

async function main() {
    const data = await getData();
    const hacks = data.hacks;
    const dataList = getDataList(hacks);
    const dataListContainer = document.querySelector("#hack_name_options")

    dataListContainer.innerHTML = dataList
}

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

function getDataList(hacks) {
    const htmlContent = hacks.map((hack) => {
        return `<option value="${hack.hack_name}">`
    }).join("")

    return htmlContent.toString();
}