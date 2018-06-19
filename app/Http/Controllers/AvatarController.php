<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class AvatarController extends Controller
{
    public function index()
    {
        return redirect(route('profile.avatar.edit'));
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        return view('profile.avatar.edit')->with([
            'user' => $user,
            'min_upload_size' => Config::get('userprofile.avatar.min_upload_size')
        ]);
    }

    public function update(Request $request)
    {
        $min_upload_size = Config::get('userprofile.avatar.min_upload_size');
        $max_upload_file = Config::get('userprofile.avatar.max_upload_file');

        $request->validate([
            'avatar' => sprintf('required|image|max:%d|dimensions:min_width=%d,min_height=%d', $max_upload_file, 
                                            $min_upload_size, $min_upload_size)
        ]);

        $user = auth()->user();

        if($request->hasFile('avatar'))
        {
            $newFileName = $user->newAvatarFileName();

            $image = null;

            try
            {
                $image = Image::make($request->file('avatar'));
            }
            catch(\Intervention\Image\Exception\NotReadableException $ex)
            {
                return redirect()->back()->withErrors("The provided file cannot be used as avatar");
            }

            Storage::put('avatars_origin/'.$newFileName, (string) $image->encode('jpg'));

            $image->fit(Config::get('userprofile.avatar.size'));

            Storage::put('avatars/'.$newFileName, (string) $image->encode('jpg'));
            
            $user->avatar = $newFileName;

            $user->save();
        }
        else
        {
            return redirect()->back()->withErrors("You have to choose a file for upload");
        }

        return redirect()->route('profile.show', $user->uuid)->with("success", "Your avatar was changed!");
    }

    public function download($uuid)
    {
        $user = \App\User::withUuid($uuid)->firstOrFail();
        return Storage::download('avatars/' . $user->avatar);
    }
}
