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
        // Usa variable de entorno APP_URL si existe, de lo contrario localhost:8000
        $url = getenv('APP_URL') ?: 'http://localhost:8000/';
        $html = file_get_contents($url);

        // Puedes ajustar el texto esperado según tu página
        $this->assertStringContainsString('Inicio se sesión', $html);
    }
}
