<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PlaylistController extends Controller
{
    public function show()
    {
        $playlist = json_decode(File::get(database_path('playlist.json')));

        return view('playlist', ['playlist' => $playlist]);
    }
}
