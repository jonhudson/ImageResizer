<?php

namespace JonHudson\ImageResizer;

/**
 * Resize png, jpeg or gif files.
 *
 *
 * @author Jon Hudson <jonathanhudson82@gmail.com>
 *
 */

class ImageResizer
{
    
    private $origImageLocation;
    private $imageFileName;
    private $origImageHeight;
    private $origImageWidth;
    private $image;
    private $details;

       
    /**
     * 
     * @param string $imageLocation path to image
     * @throws Exception
     * @return void
     */
    public function prepare($imageLocation)
    {
        $this->origImageLocation = $imageLocation;
        $this->imageFileName = $this->getFilename($imageLocation);
        $this->details = getimagesize($this->origImageLocation);

        if ($this->details === false) {
            throw new Exception('Not a valid image');
        }

        $this->setOrigImageHeight($this->details[1]);
        $this->setOrigImageWidth($this->details[0]);
        $this->createImageFromSrc($this->origImageLocation, $this->details[2]);
    }
    
    /**
     * creates image from the source image
     * 
     * @param string $origImageLocation
     * @param int $imageType
     * @throws Exception if image not in valid format
     * @return void 
     */
    private function createImageFromSrc($origImageLocation, $imageType)
    {
        switch ($imageType) {
            case 1:
                $this->image = imagecreatefromgif($origImageLocation);
                break;
            case 2:
                $this->image = imagecreatefromjpeg($origImageLocation);
                break;
            case 3:
                $this->image = imagecreatefrompng($origImageLocation);
                break;
            default:
                throw new Exception('Image not a valid format');
        }
    }

    /**
     * 
     * @param string $imageLocation
     * @return string $filename
     */
    private function getFilename($imageLocation)
    {
        $filename = basename($imageLocation);
        if ($pos = strpos($filename, '.')) {
            $filename = substr($filename, 0, $pos);
        }

        return $filename;
    }
    
    
    /**
     * 
     * @param int $width
     * @param int $height
     * @param string $destination
     * @param int $imageQuality   
     * @return void
     */
    public function resize($width, $height, $destination, $imageQuality = 100)
    {
        $requiredDimensions = $this->getRequiredDimensions($width, $height);
        $imageDestination = imagecreatetruecolor($requiredDimensions['requiredWidth'], $requiredDimensions['requiredHeight']);
        imagecopyresampled($imageDestination, $this->image, 0, 0, 0, 0, $requiredDimensions['requiredWidth'], $requiredDimensions['requiredHeight'], $this->origImageWidth, $this->origImageHeight);
		
		switch ($this->details[2]) {
            case 1:
                imagegif($imageDestination, $destination . $this->imageFileName . '.gif');
                break;
            case 2:
                imagejpeg($imageDestination, $destination . $this->imageFileName . '.jpeg', $imageQuality);
                break;
            case 3:
                imagepng($imageDestination, $destination . $this->imageFileName . '.png');
                break;
        }
        
        imagedestroy($imageDestination);
    }


    /**
     * 
     * @param int $width
     * @param int $height 
     * @return array the actual required width and height to be used
     */
    private function getRequiredDimensions($width, $height)
    {
        // get width and height that final image needs to be
        $requiredWidth = $width;
        $requiredHeight = $height;
        // Get the current width and height
        $origWidth = $this->origImageWidth;
        $origHeight = $this->origImageHeight;
        $layout = '';
        // If width is greater than height image is landscape
        if ($origWidth > $origHeight) {
            $proportionRatio = $origWidth / $origHeight;
            $layout = 'landscape';
            // If height is greater than width image is portrait
        } elseif ($origHeight > $origWidth) {
            $proportionRatio = $origHeight / $origWidth;
            $layout = 'portrait';
            // else it is square
        } else {
            $proportionRatio = 1;
            $layout = 'square';
        }
        // If image is square, if current width greater than required,
        // then use required width and set required height to same (as square)
        if ($layout === 'square') {
            if ($origWidth > $requiredWidth) {
                $requiredHeight = $requiredWidth;
            } else {
                // otherwise if current dimensions already smaller than required,
                // keep them as is.
                $requiredWidth = $origWidth;
                $requiredHeight = $origHeight;
            }
        }
        // if landscape, if width greater than required, keep using required width
        // and set required height according to ratio
        else if ($layout === 'landscape') {
            if ($origWidth > $requiredWidth) {
                $requiredHeight = $requiredWidth / $proportionRatio;
            } else {
                // otherwise if already smaller than required, keep current dimensions.
                $requiredWidth = $origWidth;
                $requiredHeight = $origHeight;
            }
        }
        // finally, if portrait, follow same process swapping width and height.
        else if ($layout === 'portrait') {
            if ($origHeight > $requiredHeight) {
                $requiredWidth = $requiredHeight / $proportionRatio;
            } else {
                $requiredWidth = $origWidth;
                $requiredHeight = $origHeight;
            }
        }

        return $dimensions = array('requiredWidth' => $requiredWidth, 'requiredHeight' => $requiredHeight);
    }
    
      
    public function setOrigImageWidth($width)
    {
        return $this->origImageWidth = $width;
    }
    
    public function setOrigImageHeight($height)
    {
        return $this->origImageHeight = $height;
    }
}
