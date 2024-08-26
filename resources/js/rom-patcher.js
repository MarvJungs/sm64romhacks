import RomPatcherWeb from './rom-patcher-js/RomPatcher.webapp';

document.addEventListener('DOMContentLoaded', function () {
    const romPatcherContainer = document.getElementById('rom-patcher-container');
    if(!romPatcherContainer) return;
    
    const myPatcherSettings = {
        language: 'en',
        requireValidation: false, /* if true, user won't be able to apply patch if the provided ROM is not valid*/
        allowDropFiles: false /* if true, it adds basic drag and drop support */
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