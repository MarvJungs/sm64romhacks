/*
	Cache Service Worker template by mrc 2019
	mostly based in:
	https://github.com/GoogleChrome/samples/blob/gh-pages/service-worker/basic/service-worker.js
	https://github.com/chriscoyier/Simple-Offline-Site/blob/master/js/service-worker.js
	https://gist.github.com/kosamari/7c5d1e8449b2fbc97d372675f16b566e	
	
	Note for GitHub Pages:
	there can be an unexpected behaviour (cache not updating) when site is accessed from
	https://user.github.io/repo/ (without index.html) in some browsers (Firefox)
	use absolute paths if hosted in GitHub Pages in order to avoid it
	also invoke sw with an absolute path:
	navigator.serviceWorker.register('/repo/_cache_service_worker.js', {scope: '/repo/'})
*/

var PRECACHE_ID='rom-patcher-js';
var PRECACHE_VERSION='v281';
var PRECACHE_URLS=[
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/manifest.json',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/style/RomPatcher.css',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/style/icon_github.svg',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/style/icon_heart.svg',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/_assets/_js/RomPatcher.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/locale.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/worker_apply.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/worker_create.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/worker_crc.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/MarcFile.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/crc.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/zip.js/zip.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/zip.js/z-worker.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/zip.js/inflate.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/formats/bps.js',
	'https://test.sm64romhacks.com/_assets/_js/RomPatcher.js/js/formats/zip.js'
];



// install event (fired when sw is first installed): opens a new cache
self.addEventListener('install', evt => {
	evt.waitUntil(
		caches.open('precache-'+PRECACHE_ID+'-'+PRECACHE_VERSION)
			.then(cache => cache.addAll(PRECACHE_URLS))
			.then(self.skipWaiting())
	);
});


// activate event (fired when sw is has been successfully installed): cleans up old outdated caches
self.addEventListener('activate', evt => {
	evt.waitUntil(
		caches.keys().then(cacheNames => {
			return cacheNames.filter(cacheName => (cacheName.startsWith('precache-'+PRECACHE_ID+'-') && !cacheName.endsWith('-'+PRECACHE_VERSION)));
		}).then(cachesToDelete => {
			return Promise.all(cachesToDelete.map(cacheToDelete => {
				console.log('delete '+cacheToDelete);
				return caches.delete(cacheToDelete);
			}));
		}).then(() => self.clients.claim())
	);
});


// fetch event (fired when requesting a resource): returns cached resource when possible
self.addEventListener('fetch', evt => {
	if(evt.request.url.startsWith(self.location.origin)){ //skip cross-origin requests
		evt.respondWith(
			caches.match(evt.request).then(cachedResource => {
				if (cachedResource) {
					return cachedResource;
				}else{
					return fetch(evt.request);
				}
			})
		);
	}
});