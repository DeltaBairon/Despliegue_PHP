![PHP Tests](https://github.com/DeltaBairon/Despliegue_PHP/actions/workflows/PHP%20Tests/badge.svg)


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
      - name: Checkout code
        uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'

      - name: Install PHPUnit
        run: composer global require phpunit/phpunit

      - name: Run tests
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
        // Ajustar según el framework
        $response = file_get_contents('http://localhost/');
        $this->assertStringContainsString('Welcome', $response);
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
📦 Paso 4: Preparación del Entorno (en servidor EC2)

En caso de despliegue en EC2, los pasos son los siguientes:
```
sudo apt update
sudo apt upgrade -y
sudo apt install python3-pip python3-venv
```



