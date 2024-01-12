document.addEventListener("DOMContentLoaded", main);

async function main() {
    const container = document.querySelector("#content");
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });
    const hack_url = params.hack_name;
    const hack_id = params.hack_id;
    container.innerHTML = await getHTMLContent(hack_url, hack_id)

}

async function getHackData(hack_name) {
    try {
        const response = hack_name == 'all' ? await fetch(`/api/hacks`) : await fetch(`/api/hacks?hack_name=${hack_name}`);
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

async function getPatchData(hack_id) {
    try {
        const response = await fetch(`/api/hacks?hack_id=${hack_id}`);
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

async function getHTMLContent(hack_name, hack_id) {
    if (hack_name != null) {
        const hackData = await getHackData(hack_name);
        const hacks = await (getHackData("all"));
        const allTags = hacks.tags;
        const patches = hackData.patches;
        const recommendVersions = patches.map((patch) => {
            const version = patch.hack_version;
            const id = patch.hack_id;
            const version_checked = patch.hack_recommend == 1 ? "checked" : "";
            return `
                <input class="col-form-input" type="checkbox" name="${id}" id="flexCheckDefault" ${version_checked}>
                <label class="col-form-label" for="flexCheckDefault">${version}</label><br/>`;
        }).join("");

        const tags = patches[0].hack_tags;

        const tagsDataList = allTags.map((tag) => {
            tag = tag.hack_tags
            return `<option value="${tag}">${tag}</option>`
        }).join("");

        const hackImages = hackData.images;
        console.log(hackImages)
        const hackImagesCheck = hackImages.map((image) => {
            return `
            <div class="col text-center"><img class=p-2 width=160 height=120 src=\"/api/images/${image}"><br/><input class="col-form-input" type="checkbox" name="hack_images_checked[]" value="${image.substring(0, image.length - 4)}" id="flexCheckDefault" checked></div>
            `
        }).join("");

        let description = patches[0].hack_description;
        description = description.replaceAll("<br/>", "\r\n");

        const megapack_checked = patches[0].hack_megapack == 1 ? `checked` : `&nbsp;`;

        return `
        <form action="#" method="post" enctype="multipart/form-data">
        <table class="table table-bordered">
        <input type="hidden" class="form-control" name="type" value="editHack">  
        <tr>
            <td class="text-right">
                <label for="hack_name" class="col-form-label text-nowrap">Hack Name:</label>
            </td>
            <td>
                <input type="hidden" class="form-control" name="hack_old_name" id="old_hack_name" value="${patches[0].hack_name}">  
                <input type="text" class="form-control" name="hack_new_name" value="${patches[0].hack_name}">  
            </td>
        </tr>
        <tr>
            <td class="text-right">
                <label for="hack_recommend" class="col-form-label text-nowrap">Recommend Versions:</label>
            </td>
            <td class="text-left">
                ${recommendVersions}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                <label for="hack_megapack" class="col-form-label text-nowrap">Megapack:</label>
            </td>
            <td class="text-left">
                <input class="col-form-input" type="checkbox" name="hack_megapack" id="flexCheckDefault" ${megapack_checked}>
                <label class="col-form-label" for="flexCheckDefault">&nbsp;</label><br/>
            </td>
        </tr>
        <tr>
            <td class="text-right">
                <label for="hack_tags" class="col-form-label text-nowrap">Hack Tags:</label>
            </td>
            <td>
            <input class="form-control" list="hack_tags_options" name="hack_tags" value="${tags}">  
                <datalist id="hack_tags_options">
                    ${tagsDataList}                       
                </datalist>
            </td>
        </tr>

        <tr>
            <td class="text-right">
                <label for="hack_images" class="col-form-label text-nowrap">Images:</label>
            </td>
            <td><input type="file" name="hack_images[]" class="form-control" multiple>
            <div class="container">
                <div class="row">
                    ${hackImagesCheck}
                </div>
            </div>
        <tr>
        <td class="text-right">
            <label for="hack_description" class="col-form-label text-nowrap">Description:</label>
            </td>
            <td colspan=3>
                <textarea name="hack_description" class="form-control" rows="10">${description}</textarea>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="text-center"><button type="submit" class="btn btn-secondary align-middle">Save Changes!</button></td>
        </tr>
        </table>
    </form>

    `
    }
    else if (hack_id != null) {

        const patchData = (await getPatchData(hack_id))[0];
        const allHacks = (await getHackData("all")).hacks;

        const dataList = allHacks.map((hack) => {
            return `<option value="${hack.hack_name}">`
        }).join("").toString()

        const hackName = patchData.hack_name;
        const hackVersion = patchData.hack_version;
        const hackAuthor = patchData.authors;
        const hackStarcount = patchData.hack_starcount;
        const hackReleaseDate = patchData.hack_release_date;

        return `
        <form action="#" method="post">
        <input type="hidden" class="form-control" name="type" id="old_hack_name" value="editPatch">  

                    <table class="table">
                    <tr>
                        <td>
                            <label for="hack_name" class="col-form-label text-nowrap">Hack Name:</label>
                        </td>
                        <td>
                            <input class="form-control" list="hack_name_options" name="hack_name" value="${hackName}" required>                            
                            <datalist id="hack_name_options">
                                ${dataList}    
                            </datalist>
                        </td>
                        <td>
                            <label for="hack_version" class="col-form-label text-nowrap">Version:</label>
                        </td>
                        <td>
                            <input type="text" name="hack_version" class="form-control" value="${hackVersion}" required>
                        </td>
                        <td>
                            <label for="hack_author" class="col-form-label text-nowrap">Author:</label>
                        </td>
                        <td>
                            <input type="text" name="hack_author" class="form-control" value="${hackAuthor}">
                            <small id="hack_author_help" class="form-text text-muted">Seperate multiple author with &quot;&lt;Name&gt;,&nbsp;&lt;Name&gt;&quot;</small>                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="hack_starcount" class="col-form-label text-nowrap">Starcount:</label>
                        </td>
                        <td>
                            <input type="number" name="hack_starcount" class="form-control" min="0" value="${hackStarcount}">
                        </td>
                        <td>
                            <label for="hack_release_date" class="col-form-label text-nowrap">Release Date:</label>
                        </td>
                        <td>
                            <input type="date" name="hack_release_date" class="form-control" value="${hackReleaseDate}">
                        </td>
                        <td>
                            <label for="hack_patchname" class="col-form-label text-nowrap">Patchname:</label>
                        </td>
                        <td>
                            <input type="file" name="hack_patchname" class="form-control" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>&nbsp;</td>
                        <td colspan=2 class="text-center"><button type="submit" class="btn btn-secondary align-middle">Save Changes!</button></td>
                        <td colspan=2>&nbsp;</td>
                    </tr>
                    </table>
                </form>
        `
    }
}