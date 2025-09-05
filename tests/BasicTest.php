<?php
 // tests/BasicTest.php
 use PHPUnit\Framework\TestCase; 
class BasicTest extends TestCase
 { 
public function testBasicFunctionality() 
{ 
$this->assertEquals(2, 1 + 1); 
    } 
public function testHomePage() 
{ 
// Ajusta según tu framework 
        $response = file_get_contents('http://localhost/'); 
$this->assertStringContains('Welcome', $response); 
    } 

    $url = getenv('APP_URL') ?: 'http://localhost';
    $html = file_get_contents($url);
    $this->assertStringContainsString('Bienvenido', $html);
}

