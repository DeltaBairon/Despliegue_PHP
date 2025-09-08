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

