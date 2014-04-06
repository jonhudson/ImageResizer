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
    
    public function testGetRequiredDimensionsReturnsCorrectIfPortraitAndOrigImageBigger()
    {
        $origHeight = 200;
        $origWidth = 100;
        $requiredHeight = 100;
        $requiredWidth = 70;
        $returnedHeight = 100;
        $returnedWidth = 50;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfSquareAndOrigImageBigger()
    {
        $origHeight = 200;
        $origWidth = 200;
        $requiredHeight = 100;
        $requiredWidth = 100;
        $returnedHeight = 100;
        $returnedWidth = 100;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfLandscapeAndOrigImageSmaller()
    {
        $origHeight = 200;
        $origWidth = 400;
        $requiredHeight = 300;
        $requiredWidth = 500;
        $returnedHeight = 200;
        $returnedWidth = 400;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfPortraitAndOrigImageSmaller()
    {
        $origHeight = 400;
        $origWidth = 200;
        $requiredHeight = 600;
        $requiredWidth = 400;
        $returnedHeight = 400;
        $returnedWidth = 200;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfSquareAndOrigImageSmaller()
    {
        $origHeight = 200;
        $origWidth = 200;
        $requiredHeight = 500;
        $requiredWidth = 500;
        $returnedHeight = 200;
        $returnedWidth = 200;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfLandscapeAndPortraitOrientationRequired()
    {
        $origHeight = 200;
        $origWidth = 400;
        $requiredHeight = 400;
        $requiredWidth = 200;
        $returnedHeight = 100;
        $returnedWidth = 200;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfPortraitAndLandscapeOrientationRequired()
    {
        $origHeight = 400;
        $origWidth = 200;
        $requiredHeight = 200;
        $requiredWidth = 400;
        $returnedHeight = 200;
        $returnedWidth = 100;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
    
    public function testGetRequiredDimensionsReturnsCorrectIfSquareAndLandscapeOrientationRequired()
    {
        $origHeight = 500;
        $origWidth = 500;
        $requiredHeight = 400;
        $requiredWidth = 600;
        $returnedHeight = 500;
        $returnedWidth = 500;
        
        $this->imageResizer->setOrigImageHeight($origHeight);
        $this->imageResizer->setOrigImageWidth($origWidth);
        $actual = $this->invokeMethod($this->imageResizer, 'getRequiredDimensions', array($requiredWidth, $requiredHeight));
        
        $this->assertEquals($returnedHeight, $actual['requiredHeight']);
        $this->assertEquals($returnedWidth, $actual['requiredWidth']);
       
    }
}
