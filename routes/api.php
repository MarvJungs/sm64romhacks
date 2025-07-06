<?php

use App\Http\Resources\RomhackResource;
use App\Http\Resources\VersionResource;
use App\Models\Romhack;
use App\Models\Version;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(
    function () {
        Route::get(
            'hacks', function () {
                return Romhack::with(['versions.authors', 'romhacktags'])->orderBy('name')->get()->toResourceCollection();
            }
        );

        Route::get(
            'version/{version}', function (Version $version) {
                return new VersionResource($version);
            }
        );
    }
);