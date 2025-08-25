📝 Manual Completo de Despliegue de Aplicación PHP con PostgreSQL en EC2
________________________________________
Introducción
Este manual detalla paso a paso cómo desplegar una aplicación PHP en un servidor EC2 de AWS, configurar Apache y PostgreSQL, restaurar un backup de base de datos, conectar la aplicación y solucionar errores comunes que pueden surgir durante el proceso. Está diseñado para usuarios que tengan conocimientos básicos de Linux y Windows.
Objetivos
•	Configurar un servidor EC2 con PHP, Apache y PostgreSQL.
•	Restaurar un backup de base de datos en PostgreSQL.
•	Conectar la aplicación PHP con la base de datos.
•	Documentar los errores comunes y su resolución.
•	Generar un glosario de comandos y siglas utilizadas.
________________________________________
1. Conexión al servidor EC2 desde Windows
Desde tu PC con Windows, abre PowerShell o CMD y ejecuta:
ssh -i "C:\cursos\FULL\Computación_en la nube\mi_clave.pem" ubuntu@18.218.213.26
Explicación: - ssh = Secure Shell, permite conexión remota segura. - -i = indica la ruta de la llave privada (.pem). - ubuntu@18.218.213.26 = usuario e IP del servidor EC2.
Error común: problemas con rutas que contienen espacios o acentos. Solución: mover el .pem a una carpeta sin espacios o usar rutas cortas 8.3.
________________________________________
2. Instalación de Apache y PHP
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-pgsql -y
sudo systemctl start apache2
sudo systemctl enable apache2
Explicación: - apt = Advanced Package Tool, gestor de paquetes. - sudo = Super User Do, permite ejecutar comandos con privilegios de administrador. - systemctl = gestiona servicios en Linux.
Errores y soluciones: - Si apt update falla, revisar conexión a internet o repositorios. - Problema: PHP no tiene extensión pgsql. Solución: instalar php-pgsql y reiniciar Apache.
________________________________________
3. Subida del backup al servidor EC2
Desde PowerShell en Windows:
scp -i "C:\cursos\FULL\Computación_en la nube\mi_clave.pem" "C:\Users\bairo\pos.backup" ubuntu@18.218.213.26:/home/ubuntu/
Explicación: - scp = Secure Copy, copia archivos de forma segura entre hosts.
Errores comunes: 1. Permission denied → el archivo o usuario no tiene permisos. Solución: mover a /tmp y ajustar permisos. 2. Rutas con acentos → mover archivos a carpeta sin espacios o usar rutas cortas.
________________________________________
4. Restauración de la base de datos PostgreSQL
4.1 Cambiar a usuario postgres
sudo -u postgres -i
4.2 Crear base de datos y usuario
createdb miappdb
createuser miusuario -P
psql -c "GRANT ALL PRIVILEGES ON DATABASE miappdb TO miusuario;"
4.3 Mover backup a ruta accesible y ajustar permisos
exit
sudo mv /home/ubuntu/pos.backup /tmp/
sudo chmod 644 /tmp/pos.backup
sudo -u postgres -i
4.4 Restaurar backup
pg_restore -U miusuario -d miappdb /tmp/pos.backup
Errores y soluciones: - unsupported version (1.16) in file header → backup de PostgreSQL 17 en servidor 16. Solución: actualizar PostgreSQL o generar dump en SQL plano.
________________________________________
5. Configuración de la aplicación PHP
Archivo config.php:
<?php
$host = "localhost";
$port = "5432";
$dbname = "miappdb";
$user = "miusuario";
$password = "TU_CONTRASEÑA";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error al conectar a la base de datos.");
}
?>
Reiniciar Apache:
sudo systemctl restart apache2
Acceder en navegador:
http://<TU_IP_PUBLICA>/Despliegue_PHP
________________________________________
6. Instalación de PostgreSQL 17 (si se desea usar .backup de v17)
sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list'
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
sudo apt update
sudo apt install -y postgresql-17
pg_lsclusters
Opcional: migrar puerto 17 a 5432 y detener 16 para la app:
sudo pg_dropcluster 17 main --stop
sudo pg_createcluster 17 main --start --port=5432
________________________________________
7. Errores comunes y soluciones documentadas
Error	Causa	Solución
Permission denied al restaurar	Archivo no legible por postgres	Mover backup a /tmp y chmod 644
unsupported version (1.16)	Backup generado en Postgres 17	Instalar PostgreSQL 17 o generar SQL plano
scp: No such file	Ruta con acentos/espacios	Mover archivo a ruta simple sin acentos
PHP sin pgsql	Falta extensión	sudo apt install php-pgsql y reiniciar Apache
________________________________________
8. Glosario de comandos y siglas
•	sudo = Super User Do: ejecutar comandos con privilegios de administrador.
•	apt = Advanced Package Tool: gestor de paquetes de Ubuntu.
•	ssh = Secure Shell: conexión remota segura.
•	scp = Secure Copy: copia segura de archivos entre hosts.
•	psql = PostgreSQL interactive terminal: permite ejecutar consultas SQL.
•	pg_restore = Herramienta para restaurar backups en formato custom de PostgreSQL.
•	chmod = Change Mode: cambiar permisos de archivos.
•	mv = Move: mover o renombrar archivos.
•	createdb = Crear una base de datos PostgreSQL.
•	createuser = Crear un usuario PostgreSQL.
•	systemctl = Controlar servicios en Linux.
•	pg_lsclusters = Listar clusters de PostgreSQL.
•	exit = Salir de la sesión actual.
________________________________________
Conclusión
Este manual ofrece un flujo completo para instalar, configurar y desplegar aplicaciones PHP con PostgreSQL en EC2, incluyendo resolución de errores comunes y glosario de comandos para referencia rápida. Con él, cualquier usuario puede replicar el despliegue de manera segura y ordenada.


#Manual de uso de la aplicación.
*La apliación tiene una funcionalidad muy sencialla la cual es el registro y generación de certificados de un determinado curso a un determinado estudiante /alumno, su uso es muy básico y se especifica a continuación.

1. Una vez desplegada accederás a través de la URL http://18.217.17.141/Despliegue_PHP, el cual te llevará al index principal.
2. User = "admin", password "admin".
3. En el nav bar podrás identificar las secciones del proyecto en el que podrás registrar, actualizar y/o eliminar estudiantes/alumnos y cursos.
4. Tener en cuenta que un alumno solo puede registrar los cursos que existan en la tabla cursos, si se desea registra un alumno con un curso primero el curso debe ser creado en su respectiva tabla.
5. Al registra un alumno en un curso se habilita un link de descarga para poder generar los respectivos certificados.
6. El certificado contiene el nombre del estudiante y el título del curso seleccionado.

