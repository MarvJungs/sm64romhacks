/* Rom Patcher JS v20200502 - Marc Robledo 2016-2020 - http://www.marcrobledo.com/license */

self.importScripts(
	'./MarcFile.js',
	'./crc.js',
	'./formats/bps.js',
);


	
self.onmessage = event => { // listen for messages from the main thread
	var sourceFile=new MarcFile(event.data.sourceFileU8Array);
	var modifiedFile=new MarcFile(event.data.modifiedFileU8Array);
	var mode=event.data.patchMode;

	sourceFile.seek(0);
	modifiedFile.seek(0);

	var patch;
	if(mode==='bps'){
		//use delta mode (slower, but smaller patch size) only with <4mb files
		patch=createBPSFromFiles(sourceFile, modifiedFile, (sourceFile.fileSize<=4194304));
	}else{
		throw new Error('error_invalid_patch');
	}

	var newPatchFile=patch.export('file');
	
	//console.log('postMessage');
	self.postMessage(
		{
			//sourceFileU8Array:event.data.sourceFileU8Array,
			//modifiedFileU8Array:event.data.modifiedFileU8Array,
			patchFileU8Array:newPatchFile._u8array
		},
		[
			//event.data.sourceFileU8Array.buffer,
			//event.data.modifiedFileU8Array.buffer,
			newPatchFile._u8array.buffer
		]
	);
};