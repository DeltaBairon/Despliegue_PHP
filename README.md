![PHP Tests](https://github.com/DeltaBairon/Despliegue_PHP/actions/workflows/php.yml/badge.svg)



# 📘 Documentación del Proyecto

Este documento describe paso a paso el proceso de configuración, despliegue y pruebas automatizadas realizado en este proyecto.  
Se incluyen también los errores encontrados y sus soluciones.

---

## ⚙️ Paso 1: Configuración de GitHub Actions

Se creó el archivo de workflow dentro de la carpeta `.github/workflows/` con el nombre `php.yml`:

```yaml
name: PHP Tests

on:
  push:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v2

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '7.4'

      - name: Install PHPUnit
        run: |
          wget https://phar.phpunit.de/phpunit-9.6.phar -O phpunit
          chmod +x phpunit
          sudo mv phpunit /usr/local/bin/phpunit

      - name: Start PHP built-in server
        run: php -S localhost:8000 -t . &
        # 👆 Usa '.' si tu index.php está en la raíz
        #    Si está en /public pon "-t public/"

      - name: Run PHPUnit tests
        run: phpunit --testdox tests/


```
🧪 Paso 2: Creación de Pruebas con PHPUnit

Se agregó un archivo de prueba básico en la carpeta tests/ llamado BasicTest.php:

```php
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

```
🛠️ Paso 3: Errores Comunes y Soluciones

Durante el desarrollo se presentaron varios errores, aquí se documentan de forma resumida:

🛠️ Paso 3: Errores y Soluciones

Durante la configuración aparecieron errores que se resolvieron:

❌ Error 1: Invalid workflow file

Causa: Indentación incorrecta en el YAML.

Solución: Corregir la estructura para que jobs: y steps: quedaran bien alineados.

❌ Error 2: Composer could not find a composer.json file

Causa: No existía composer.json en el proyecto.

Solución: Se eliminó la instalación de dependencias porque no eran necesarias para correr el test básico.

❌ Error 3: Cannot open file "test/".

Causa: El workflow buscaba la carpeta test/ en singular.

Solución: Se cambió a tests/, que es el nombre correcto de la carpeta.
```
- name: Run tests
  run: phpunit --testdox tests/
```
✅ Resultado Final

Después de aplicar los cambios:

El workflow corre en cada push a la rama main.

PHPUnit ejecuta las pruebas dentro de la carpeta tests/.

El test básico funciona correctamente.



