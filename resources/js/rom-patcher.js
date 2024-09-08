import RomPatcherWeb from './rom-patcher-js/RomPatcher.webapp';

document.addEventListener('DOMContentLoaded', function () {
    const romPatcherContainer = document.getElementById('rom-patcher-container');
    if (!romPatcherContainer) return;

    const myPatcherSettings = {
        language: 'en',
        requireValidation: false,
        allowDropFiles: false,
        onpatch: function (romFile) {
            const uint8Array = romFile._u8array;
            const titleArray = uint8Array.slice(0x20, 0x20 + 20);

            let title = '';
            for (let i = 0; i < titleArray.length; i++) {
                const char = String.fromCharCode(titleArray[i]);
                if (char !== '\0') {
                    title += char;
                }
            }
            const stardisplay_url = "https://raw.githubusercontent.com/StarDisplayLayouts/layouts/master/";
            const url = encodeURI(stardisplay_url + title.trim() + '.jsml');
            console.log(url);
            // const a = document.createElement('a');
            // a.href = url;
            // document.body.appendChild(a);
            // a.click();
            // document.body.removeChild(a);
        }
    };
    const version_id = new URLSearchParams(window.location.search).get('id');
    if (version_id) {
        document.getElementById('rom-patcher-input-file-patch').remove();
        fetch(`/api/v1/version/${version_id}`)
            .then((response) => response.json())
            .then((data) => {
                RomPatcherWeb.initialize(myPatcherSettings, {
                    file: `/hacks/download/${version_id}`,
                    name: `${data.hack.name} - v.${data.name}`,
                    inputCrc32: 0x3ce60709,
                    outputName: `${data.hack.name} - v.${data.name}`
                });
            });
    }
    else {
        document.getElementById('rom-patcher-select-patch').remove();
        RomPatcherWeb.initialize(myPatcherSettings)
    }
});