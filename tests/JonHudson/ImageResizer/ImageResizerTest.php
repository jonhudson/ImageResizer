<?php

namespace JonHudson\ImageResizer; 

use JonHudson\ImageResizer\ImageResizer;

class ImageResizerTest extends \PHPUnit_Framework_TestCase 
{
    public function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
    
    public function testGetFilenameReturnsFilenameInCorrectFormat()
    {
        $imageResizer = new ImageResizer;
        $imageLocation = 'path/to/image.jpg';        
        $actual = $this->invokeMethod($imageResizer, 'getFileName', array($imageLocation));
        
        $this->assertEquals('image', $actual);
    }
}
