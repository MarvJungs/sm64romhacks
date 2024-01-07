var CUSTOM_PATCHER = [];


function getHackID() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    return urlParams.get('id');
}

async function getPatchData(hack_id) {
    try {
        const response = hack_id != null ? await fetch(`/api/patches?hack_id=${hack_id}`) : await fetch(`/api/patches`)
        if (!response.ok) {
            throw new Error(`${response.status} ${response.statusText}`);
        }
        const r = await response.json();
        return r;
      } 
      catch (error) {
          console.log(error);
      }    
}

function setUpCustomPatcher() {
    var CUSTOM_PATCHER = [];
    const patches = getPatches();
    patches.then(
        function(value) {    
            Array.from(value).forEach(element => {
                CUSTOM_PATCHER.push({file: `/patch/${element.hack_patchname}.zip`, name: element.hack_patchname});
            });
        },
        function(error) {console.log(error)}
    )
    return CUSTOM_PATCHER;
}

async function getPatches() {
    const hack_id = getHackID();
    const patches = await getPatchData(hack_id);
    return patches;

}