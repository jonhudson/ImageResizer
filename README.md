ImageResizer
=============

Easily resize images using PHP's GD library.

Install via Composer:

    {
        "require": {
            "jonhudson/imageresizer": "dev-master"
        }
    }


Usage
-----

    use JonHudson\ImageResizer\ImageResizer;

    $imageResizer = new ImageResizer();

    $imageResizer->prepare('path/to/image');


#### Give required width, height, destination and optional optimization percentage (only works for jpegs) ####
    
    $imageResizer->resize(600, 400, 'path/to/required/destination', 70);
