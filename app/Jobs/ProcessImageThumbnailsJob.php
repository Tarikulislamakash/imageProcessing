<?php

namespace App\Jobs;

use Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImageThumbnailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    /**
     * Create a new job instance.
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image = $this->image;

        $originalImage = Image::make(storage_path('app/public/images/' . $image->user_id . '/' . $image->orginal_image));

        // Create a 60x60 WebP image
        $smallImage = clone $originalImage;
        $smallImage->fit(60, 60);
        $smallImageName = 'small_' . pathinfo($image->orginal_image, PATHINFO_FILENAME) . '.webp'; // Add a prefix and change the extension
        $smallImage->encode('webp')->save(storage_path('app/public/images/' . $image->user_id . '/' . $smallImageName));

        // Create a 200x200 WebP image
        $largeImage = clone $originalImage;
        $largeImage->fit(200, 200);
        $largeImageName = 'large_' . pathinfo($image->orginal_image, PATHINFO_FILENAME) . '.webp'; // Add a prefix and change the extension
        $largeImage->encode('webp')->save(storage_path('app/public/images/' . $image->user_id . '/' . $largeImageName));

        $image->update([
            'small_image' => $smallImageName,
            'large_image' => $largeImageName,
        ]);


    }
}
