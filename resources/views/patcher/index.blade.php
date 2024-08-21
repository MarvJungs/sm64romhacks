<x-layout>
    <h1 class="text-center">Online Patcher</h1>
    {{-- <iframe id="patcher" src="https://www.marcrobledo.com/RomPatcher.js/"></iframe> --}}
    <div id="rom-patcher-container">
        <div class="rom-patcher-row margin-bottom" id="rom-patcher-row-file-rom">
            <div class="text-end"><label for="rom-patcher-input-file-rom" data-localize="yes">ROM file:</label></div>
            <div class="rom-patcher-container-input">
                <input type="file" id="rom-patcher-input-file-rom" class="empty form-control" disabled />
            </div>
        </div>
        <div class="margin-bottom text-selectable text-mono text-muted" id="rom-patcher-rom-info">
            <div class="rom-patcher-row">
                <div class="text-end">CRC32:</div>
                <div class="text-truncate"><span id="rom-patcher-span-crc32"></span></div>
            </div>
            <div class="rom-patcher-row">
                <div class="text-end">MD5:</div>
                <div class="text-truncate"><span id="rom-patcher-span-md5"></span></div>
            </div>
            <div class="rom-patcher-row">
                <div class="text-end">SHA-1:</div>
                <div class="text-truncate"><span id="rom-patcher-span-sha1"></span></div>
            </div>
            <div class="rom-patcher-row" id="rom-patcher-row-info-rom">
                <div class="text-end">ROM:</div>
                <div class="text-truncate"><span id="rom-patcher-span-rom-info"></span></div>
            </div>
        </div>

        <div class="rom-patcher-row margin-bottom" id="rom-patcher-row-file-patch">
            <div class="text-end"><label for="rom-patcher-input-file-patch" data-localize="yes">Patch file:</label>
            </div>
            <div class="rom-patcher-container-input">
                <select class="form-select" id="rom-patcher-select-patch"></select>
                <input type="file" id="rom-patcher-input-file-patch" class="form-control empty" accept=".ips,.ups,.bps,.aps,.rup,.ppf,.mod,.xdelta,.vcdiff,.zip" disabled />
            </div>
        </div>
        <div class="rom-patcher-row margin-bottom" id="rom-patcher-row-patch-description">
            <div class="text-end text-mono text-muted" data-localize="yes">Description:</div>
            <div class="text-truncate" id="rom-patcher-patch-description"></div>
        </div>
        <div class="rom-patcher-row margin-bottom text-selectable text-mono text-muted"
            id="rom-patcher-row-patch-requirements">
            <div class="text-end text-mono" id="rom-patcher-patch-requirements-type">ROM requirements:</div>
            <div class="text-truncate" id="rom-patcher-patch-requirements-value"></div>
        </div>

        <div class="text-center" id="rom-patcher-row-apply">
            <div id="rom-patcher-row-error-message" class="margin-bottom"><span id="rom-patcher-error-message"></span>
            </div>
            <button id="rom-patcher-button-apply" data-localize="yes" disabled>Apply patch</button>
        </div>
    </div>

	<div id="rom-patcher-powered" class="text-center">
		<a href="https://github.com/marcrobledo/RomPatcher.js" target="_blank"><img
				src="{{asset('images/powered_by_rom_patcher_js.png')}}" loading="lazy" />Powered by Rom Patcher JS</a>
	</div>
</x-layout>
