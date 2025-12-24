<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Romhack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Romhack $hack, Image $image)
    {
        Storage::delete($image->filename);
        $image->delete();
        return redirect(route('hack.show', ['hack' => $image->romhack]));
    }
}
