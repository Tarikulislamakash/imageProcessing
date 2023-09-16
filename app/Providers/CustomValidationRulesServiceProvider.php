<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationRulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('image_mime_and_extension', function ($attribute, $value, $parameters, $validator) {
            $allowedMimes = ['jpeg', 'png'];
            $allowedExtensions = ['image/jpeg', 'image/png'];
            
            $mime = $value->getMimeType();
            $extension = $value->getClientOriginalExtension();

            return in_array($mime, $allowedExtensions) && in_array($extension, $allowedMimes);
        });
    }

    public function register()
    {
        //
    }
}
