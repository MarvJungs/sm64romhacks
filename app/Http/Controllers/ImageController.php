<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        Gate::authorize('forceDelete', $image);

        Storage::delete($image->filename);
        $image->delete();

        return back()->with('success', 'image was successfully deleted');
    }
}
