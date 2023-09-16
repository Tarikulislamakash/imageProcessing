<?php

namespace App\Http\Controllers;

use App\Models\ImageProcess;
use Illuminate\Http\Request;
use App\Jobs\ProcessImageThumbnailsJob;
use Illuminate\Support\Facades\Validator;

class ImageProcessingController extends Controller
{
    
    public function processImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|image_mime_and_extension',
        ], [
            'image.image_mime_and_extension' => 'Upload only jpeg and png images.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imageName = time() . '.' . $request->image->extension();

        $image = ImageProcess::create([
            'orginal_image' => $imageName,
            'user_id' => auth()->user()->id,
        ]);

        $request->image->storeAs('images/' . auth()->user()->id, $imageName);

        dispatch(new ProcessImageThumbnailsJob($image))->delay(now()->addSeconds(2));

        return redirect()->back()->with('uploadImage', 'Image Uploaded Successfully.');

    }

}
