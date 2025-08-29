# 🧰 Guía de configuración de servidor y base de datos

## 🔑 1. Acceso por SSH

```bash
ssh -i "mi-proyecto-aws.pem" ubuntu@18.222.152.103

Errores y advertencias vistos:

Warning: Identity file mi-proyecto-aws.pem not accessible: No such file or directory

Permission denied (publickey)

Soluciones aplicadas:

bash
# Dar permisos correctos a la llave
chmod 400 mi-proyecto-aws.pem

# En Windows (PowerShell) usar ruta absoluta
ssh -i "C:\Users\Bayron\Downloads\mi-proyecto.pem" ubuntu@18.222.152.103
🌐 2. Apache (instalación y configuración)
bash
# Ver ubicación de Apache
which apache2

# Ver archivo de configuración principal
apache2ctl -V | grep SERVER_CONFIG_FILE

# Cambiar permisos de la carpeta web
sudo chown -R www-data:www-data /var/www/html
🐘 3. PostgreSQL (instalación y administración)
bash
# Actualizar paquetes
sudo apt update

# Instalar PostgreSQL y extras
sudo apt install postgresql postgresql-contrib -y

# Iniciar PostgreSQL
sudo systemctl start postgresql

# Habilitar inicio automático
sudo systemctl enable postgresql

# Ver estado
sudo systemctl status postgresql

# Entrar como usuario postgres
sudo -i -u postgres psql
Comandos dentro de psql:

sql
\l     -- Listar bases de datos
\du    -- Listar roles/usuarios
\q     -- Salir
🐘 4. Exportar/Importar base de datos
bash
# Exportar
pg_dump -U postgres -h localhost -d mi_app_db > db.sql

# Importar
psql -U postgres -h localhost -d mi_app_db < db.sql
Error común:

text
pg_dump: error: no se pudo abrir el archivo de salida ...
👉 Solución:

bash
pg_dump -U postgres -h 127.0.0.1 -d pos -F c -f "C:\Users\Bayron\Desktop\pos_backup.dump"
🐘 5. Configuración de PHP y conexión a PostgreSQL
bash
# Instalar PHP y módulos de PostgreSQL
sudo apt install php libapache2-mod-php php-pgsql -y

# Ver versión PHP
php -v

# Reiniciar Apache para aplicar cambios
sudo systemctl restart apache2
Ejemplo de conexión PHP a PostgreSQL:

php
<?php
$conn = pg_connect("host=localhost dbname=mi_app_db user=postgres password=tu_clave");
if ($conn) {
    echo "✅ Conectado a PostgreSQL";
} else {
    echo "❌ Error de conexión";
}
?>
🔗 6. Git (gestión del proyecto)
bash
# Instalar git
sudo apt install git -y

# Ubicarse en la carpeta de Apache
cd /var/www/html

# Clonar repositorio
sudo git clone https://github.com/tuusuario/tu-repo.git
🛠️ 7. Otros comandos y auxiliares
bash
# Actualizar sistema completo
sudo apt update && sudo apt upgrade -y

# Confirmar conexión SSH y agregar host
ssh -i "mi-proyecto-aws.pem" ubuntu@18.222.152.103
🚨 8. Errores comunes que aparecieron
Clave no encontrada (No such file or directory) → Ruta incorrecta al .pem.

Permission denied (publickey) → La instancia no tiene la llave asociada.

Unit file postgresql.service does not exist → No estaba instalado PostgreSQL.

pg_dump: no se pudo abrir archivo → Ruta incorrecta al exportar en Windows.

Código

¿Quieres que lo convierta en una plantilla para múltiples proyectos o que lo traduzca al inglés también?
co copio y lo pego así sin más y se ve bien?
¡Sí, puedes copiar y pegar ese bloque tal cual en tu README.md y se verá muy bien! Está formateado en Markdown estándar, que GitHub interpreta perfectamente. Aquí te dejo unos tips rápidos para asegurarte de que se vea impecable:

✅ Recomendaciones para que se vea bien en GitHub
Encabezados (#): Ya están bien usados para secciones. GitHub los convierte en títulos grandes.

Bloques de código (```bash, ```php): Se verán con resaltado de sintaxis y fondo gris.

Listas (-, 1.): Se renderizan como viñetas o numeradas automáticamente.

Separadores (---): Se convierten en líneas horizontales para dividir secciones.

📌 ¿Dónde pegarlo?
Si estás creando el README desde cero, simplemente abre tu archivo README.md y pega el contenido.

Si ya tienes un README, puedes insertar este bloque en la sección que corresponda (por ejemplo, debajo de "Instalación" o "Configuración del servidor").

