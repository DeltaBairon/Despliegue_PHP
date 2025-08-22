<?php 
class BD {

    public static $instancia = null;

    public static function crearInstancia() {

        if (!isset(self::$instancia)) {

            $opcionesPDO[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

            // Conexión a PostgreSQL con base de datos "pos"
            self::$instancia = new PDO(
                'pgsql:host=localhost;port=5432;dbname=pos',
                'postgres',             // Cambia por tu usuario si es distinto
                'root123',        // Reemplaza por tu contraseña real
                $opcionesPDO
            );

            // Establecer el esquema por defecto a "escuela"
            self::$instancia->exec("SET search_path TO escuela");
        }

        return self::$instancia;
    }
}
?>