ImageResizer
=============

A PHP class to resize images.
Requires PHP GD library to be installed.

Usage
-----

$imageResizer->prepare('path/to/image');

#### Give required width, height, destination and optional optimization percentage (only works for jpegs) ####
$imageResizer->resize(600, 400, 'path/to/required/destination', 70);
