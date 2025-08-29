# 🧰 Guía de configuración de servidor y base de datos

## 🔑 1. Acceso por SSH

```bash
ssh -i "mi-proyecto-aws.pem" ubuntu@18.222.152.103
Errores y advertencias vistos:

Warning: Identity file mi-proyecto-aws.pem not accessible: No such file or directory

Permission denied (publickey)

Soluciones aplicadas:
# Dar permisos correctos a la llave
chmod 400 mi-proyecto-aws.pem

# En Windows (PowerShell) usar ruta absoluta
ssh -i "C:\Users\Bayron\Downloads\mi-proyecto.pem" ubuntu@18.222.152.103
Hoy
🔑 1. Acceso por SSH ssh -i "mi-proyecto-aws.pem" ubuntu@18.222.152.103 Errores y advertencias vistos: Warning: Identity file mi-proyecto-aws.pem not accessible: No such file or directory Permission denied (publickey). Soluciones aplicadas: ## Dar permisos correctos a la llave chmod 400 mi-proyecto-aws.pem # En Windows (PowerShell) usar ruta absoluta ssh -i "C:\Users\Bayron\Downloads\mi-proyecto.pem" ubuntu@18.222.152.103 🌐 2. Apache (instalación y configuración) # Ver ubicación de Apache which apache2 # Ver archivo de configuración principal apache2ctl -V | grep SERVER_CONFIG_FILE # Cambiar permisos de la carpeta web sudo chown -R www-data:www-data /var/www/html 🐘 3. PostgreSQL (instalación y administración) # Actualizar paquetes sudo apt Update # Instalar PostgreSQL y extras sudo apt install postgresql postgresql-contrib -y # Iniciar PostgreSQL sudo systemctl start postgresql # Habilitar inicio automático sudo systemctl enable postgresql # Ver estado sudo systemctl status postgresql # Entrar como usuario postgres sudo -i -u postgres psql \l -- Listar bases de datos \du -- Listar roles/usuarios \q -- Salir 🐘 4. Exportar/Importar base de datos # Exportar pg_dump -U postgres -h localhost -d mi_app_db > db.sql # Importar psql -U postgres -h localhost -d mi_app_db < db.sql Error: pg_dump: error: no se pudo abrir el archivo de salida ... 👉 Solución: dar ruta válida en Windows con comillas, ej: pg_dump -U postgres -h 127.0.0.1 -d pos -F c -f "C:\Users\Bayron\Desktop\pos_backup.dump" 🐘 5. Configuración de PHP y conexión a PostgreSQL # Instalar PHP y módulos de PostgreSQL sudo apt install php libapache2-mod-php php-pgsql -y # Ver versión PHP php -v # Reiniciar Apache para aplicar cambios sudo systemctl restart apache2 Ejemplo de conexión PHP a PostgreSQL: <?php $conn = pg_connect("host=localhost dbname=mi_app_db user=postgres password=tu_clave"); if ($conn) { echo "✅ Conectado a PostgreSQL"; } else { echo "❌ Error de conexión"; } ?> 🔗 6. Git (gestión del proyecto) # Instalar git sudo apt install git -y # Ubicarse en la carpeta de Apache cd /var/www/html # Clonar repositorio sudo git clone https://github.com/tuusuario/tu-repo.git 🛠️ 7. Otros comandos y auxiliares # Actualizar sistema completo sudo apt update && sudo apt upgrade -y # Confirmar conexión SSH y agregar host ssh -i "mi-proyecto-aws.pem" ubuntu@18.222.152.103 🚨 8. Errores comunes que aparecieron 1. Clave no encontrada (No such file or directory) → Ruta incorrecta al .pem. 2. Permission denied (publickey) → La instancia no tiene la llave asociada. 3. Unit file postgresql.service does not exist → No estaba instalado PostgreSQL. 4. pg_dump: no se pudo abrir archivo → Ruta incorrecta al exportar en Windows. Sin modificar el texto, organízalo de tal manera que quede con una fuente decente y organizada para copiar en el readme de github ya que se ve muy grande
Claro, Bayron. Aquí tienes tu contenido reorganizado en formato Markdown limpio y legible, ideal para un README en GitHub. Usé encabezados, listas y bloques de código para que se vea profesional y fácil de navegar:

markdown
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
# Ver ubicación de Apache
which apache2

# Ver archivo de configuración principal
apache2ctl -V | grep SERVER_CONFIG_FILE

# Cambiar permisos de la carpeta web
sudo chown -R www-data:www-data /var/www/html
