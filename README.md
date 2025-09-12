![AWS](https://img.shields.io/badge/AWS-Ready-orange?logo=amazon-aws)
![PHP Tests](https://github.com/DeltaBairon/Despliegue_PHP/actions/workflows/php.yml/badge.svg)
![Docker](https://img.shields.io/badge/Docker-Ready-blue?logo=docker) 


📋 Descripción del Proyecto
Aplicación PHP para registrar cursos y obtener sus certificados.

✅ Persistencia local con localStorage
✅ Interfaz responsive y moderna


✅ ¿Qué se automatiza?
```
       * Tests de matemáticas básicas: Verificación de operaciones aritméticas fundamentales
       * Validación de HTML: Verificación de estructura y sintaxis del archivo principal
       * Validación de PHP: Comprobación de presencia de código PHPen el HTML
       * Test de servidor HTTP: Verificación de que Python puede servir la aplicación
```


🔄 ¿Cuándo se ejecuta la automatización?
    Push a main: Cada vez que se hace push a la rama principal
    Pull Requests: Antes de fusionar cambios al código principal
    Manualmente: Desde la pestaña Actions en GitHub

📊 Estado actual del CI/CD:
    El badge de arriba muestra el estado en tiempo real:

* 🟢 Passing: Todos los tests pasan correctamente
* 🔴 Failing: Hay errores que necesitan corrección


📋 Tests incluidos:
1. Tests de Matemáticas Básicas

```
public function testBasicFunctionality()
    {
        $this->assertEquals(2, 1 + 3);


```

🛠️ Tecnologías Utilizadas
* Frontend: HTML5, CSS3
* Backend: PHP 8 MVC PDO
* CI/CD: GitHub Actions
* Servidor: Localhost apache Server
* Cloud: AWS EC2 (Ubuntu 22.04 LTS)
* Conexión: AWS Session Manager
* Almacenamiento: localStorage (Browser)

🧪 Para Desarrolladores
```

    📁 Estructura del Proyecto
    Despliegue_PHP/
    ├── .github/
    │   └── workflows/
    │       └── php.yml      # Workflow de CI/CD documentado
    ├── src/
    │   └── index.html             # Aplicación completa (HTML + CSS + JS)
    ├── tests/
    │   └── BasicTest.php          # Tests automatizados con Jest
    ├
    ├── README.md                  # Este archivo (documentación completa)
    └── .gitignore                # Archivos a ignorar en Git
```
# 📘 Documentación del Proyecto

Este documento describe paso a paso el proceso de configuración, despliegue y 
pruebas automatizadas realizado en este proyecto.  Se incluyen también los errores  
encontrados y sus soluciones.

---

## ⚙️ Paso 1: Configuración de GitHub Actions

Se creó el archivo de workflow dentro de la 
carpeta `.github/workflows/` con el nombre `php.yml`:

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

Se agregó un archivo de prueba básico en la carpeta tests/ 
llamado BasicTest.php:

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

Durante el desarrollo se presentaron varios errores, aquí se 
documentan de forma resumida:

🛠️ Paso 3: Errores y Soluciones

Durante la configuración aparecieron errores que se resolvieron:

❌ Error 1: Invalid workflow file

    Causa: Indentación incorrecta en el YAML.

    Solución: Corregir la estructura para 
    que jobs: y steps: quedaran bien alineados.

❌ Error 2: Composer could not find a composer.json file

    Causa: No existía composer.json en el proyecto.

    Solución: Se eliminó la instalación de dependencias porque no eran 
    necesarias para correr el test básico.

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


Despliegue de Aplicación PHP con Docker

Este proyecto contiene una aplicación en PHP que se ejecuta sobre Apache y se distribuye mediante Docker.

🚀 Requisitos

Docker
 instalado y corriendo.

(Opcional) Docker Compose
 para gestionar múltiples servicios.
 ```
 ```
🚀 Requisitos

Docker
 instalado y corriendo.

(Opcional) Docker Compose
 para gestionar múltiples servicios.

📂 Estructura del proyecto
 ```
Aplicación/
│── secciones/
│── styles/
│── templates/
│── tests/
│── index.php
│── Dockerfile
│── .dockerignore

```
🐳 En en archivo docker file 
```
# Dockerfile
FROM php:8.1-apache

# Copiar aplicación al contenedor
COPY . /var/www/html/

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Exponer el puerto
EXPOSE 80


 ```
⚙️ Crear el docker-compose.yml
```
version: "3.9"

services:
  app:
    build: .
    container_name: php_app
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_PORT=5432
      - DB_NAME=pos
      - DB_USER=postgres
      - DB_PASS=root123

  db:
    image: postgres:15
    container_name: postgres_db
    restart: always
    environment:
      - POSTGRES_DB=pos
      - POSTGRES_USER=postgres
      - POSTGRES_PASSWORD=root123
    ports:
      - "5432:5432"
    volumes:
      - db_data:/var/lib/postgresql/data

volumes:
  db_data:

```
🎧Confirmar que pdo_pgsql está instalado en PHP
Debe mostrar:
```
pdo_pgsql
pgsql
```
📂 5. Copiar el backup al contenedor de Postgres
```
docker cp "C:\xampp\htdocs\pos.backup.sql" postgres_db:/pos.backup.sql

```
Verifica dentro del contenedor:
```
docker exec -it postgres_db bash
ls -l /

```
🗄️Restaurar la base de datos
🔎 Verificar tipo de archivo
```
head -n 5 /pos.backup.sql
```

▶️ Restaurar SQL plano

```
psql -U postgres -d pos -f /pos.backup.sql
```

🔍 7. Confirmar que las tablas están cargadas
```
\dn                -- Ver esquemas
\dt escuela.*      -- Listar tablas dentro del esquema escuela
```

🐳 Construcción de la imagen
Desde la raíz del proyecto, ejecutar:
 ```
docker build -t despliegue-php .
 ```
▶️ Ejecución del contenedor

Levantar la aplicación en el puerto 8080:
 ```
docker run -p 8080:80 despliegue-php
 ```
Luego acceder en el navegador a:
👉 http://localhost:8080

🛑 Detener el contenedor

Si lo ejecutaste en primer plano, simplemente usa Ctrl + C.
Si lo corres en modo detached (-d), primero lista los contenedores:
```
```
⚙️ Ignorando archivos innecesarios / archivo docker file ignore
```
El archivo .dockerignore asegura que solo se copien al contenedor
los archivos necesarios para la aplicación.
node_modules
.git
.env
*.md
```
❌ Errores presentados
Se instala Docker para poder generar el proceso de virtualización, pero indica que no la detecta
se verifica en el taskmanager de windoes que se encuentra habilitada 
```
Error: Virtualización support not deteted

Docker desktop requires virtualization support to run. Contact your IT admin to
enable virtualization or check system requirements
```
✅ Se instalan complementos necesarios wls para la virtualización desde powershell

```
wls --install

```
✅ Una vez instalado el WSL (Subsistema de Windows para Linux)
nos permite interactuar con docker.





