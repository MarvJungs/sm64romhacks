import RomPatcherWeb from './rom-patcher-js/RomPatcher.webapp';

export default class RomPatcher {
    
    main() {
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
                console.log(title);
            }
        };
        const version_id = new URLSearchParams(window.location.search).get('id');
        if (version_id) {
            document.getElementById('rom-patcher-input-file-patch').remove();
            fetch(`/api/v1/version/${version_id}`)
                .then((response) => response.json())
                .then((json) => {
                    RomPatcherWeb.initialize(myPatcherSettings, {
                        file: `/hacks/download/${version_id}`,
                        name: `${json.data.hack} - v.${json.data.name}`,
                        inputCrc32: 0x3ce60709,
                        outputName: `${json.data.hack} - v.${json.data.name}`
                    });
                });
        }
        else {
            document.getElementById('rom-patcher-select-patch').remove();
            RomPatcherWeb.initialize(myPatcherSettings)
        }
    }
}