import './rom-patcher-js/modules/BinFile';
import './rom-patcher-js/modules/HashCalculator';
import './rom-patcher-js/modules/RomPatcher.format.ips';
import './rom-patcher-js/modules/RomPatcher.format.ups';
import './rom-patcher-js/modules/RomPatcher.format.aps_n64';
import './rom-patcher-js/modules/RomPatcher.format.aps_gba';
import './rom-patcher-js/modules/RomPatcher.format.bps';
import './rom-patcher-js/modules/RomPatcher.format.rup';
import './rom-patcher-js/modules/RomPatcher.format.ppf';
import './rom-patcher-js/modules/RomPatcher.format.pmsr';
import './rom-patcher-js/modules/RomPatcher.format.vcdiff';
import './rom-patcher-js/modules/zip.js/zip.min';
import './rom-patcher-js/RomPatcher';
import './rom-patcher-js/RomPatcher.webapp';

window.addEventListener('load', function () {
    const myPatcherSettings = {
        language: 'en',
        allowDropFiles: false /* if true, it adds drag and drop support,*/
    };
    RomPatcherWeb.initialize(myPatcherSettings, 'my_patch.ips');
});