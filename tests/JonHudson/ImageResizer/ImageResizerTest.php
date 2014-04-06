<?php

namespace JonHudson\ImageResizer; 

use JonHudson\ImageResizer\ImageResizer;

class ImageResizerTest extends \PHPUnit_Framework_TestCase 
{
    private $imageResizer;
    
    public function setUp() 
    {
        $this->imageResizer = new ImageResizer;
    }
    
    public function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
    
    public function testGetFilenameReturnsFilenameInCorrectFormat()
    {
        $imageLocation = 'path/to/image.jpg';        
        $actual = $this->invokeMethod($this->imageResizer, 'getFileName', array($imageLocation));
        
        $this->assertEquals('image', $actual);
    }
    
    /**
     * @expectedException Exception
     */
    public function testCreateImageFromSourceThrowsExceptionIfImageTypeNotValid()
    {
        $imageLocation = 'path/to/image.jpg';    
        $imageType = 4;
        $this->invokeMethod($this->imageResizer, 'createImageFromSource', array($imageLocation, $imageType));
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfLandscapeAndOrigImageBigger()
    {
        $origHeight = 100;
        $origWidth = 200;
        $requiredHeight = 70;
        $requiredWidth = 100;
        $returnedHeight = 50;
        $returnedWidth = 100;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
}
