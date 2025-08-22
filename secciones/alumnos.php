<?php 
include_once("../configuracion/bd.php");
$conexionBD=BD::crearInstancia();

$id=isset($_POST["id"])?$_POST["id"]:"";
$nombre=isset($_POST["nombre"])?$_POST["nombre"]:"";
$apellidos=isset($_POST["apellidos"])?$_POST["apellidos"]:"";
$cursos=isset($_POST["cursos"])?$_POST["cursos"]:"";
$accion=isset($_POST["accion"])?$_POST["accion"]:"";




if(isset($_POST['accion'])){

switch($accion){

    case "seleccionar":
        $sql="SELECT * FROM alumnos WHERE id=:id";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(":id",$id);
        $consulta->execute();
        $alumno=$consulta->fetch(PDO::FETCH_ASSOC);
        $nombre=$alumno["nombre"];
        $apellidos=$alumno["apellidos"];

        $sql="SELECT cursos.id FROM alumno_curso ";
        $sql.="INNER JOIN cursos ON cursos.id=alumno_curso.id ";
        $sql.="WHERE alumno_curso.idalumno=:id";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(":id",$id);
        $consulta->execute();
        $cursosAlumno=$consulta->fetchAll(PDO::FETCH_ASSOC);
       
        foreach($cursosAlumno as $curso){
            $arregloCursos[]=$curso["id"];
        }
         
        
        break;
    case "agregar":
        $sql="INSERT INTO alumnos (nombre,apellidos) VALUES (:nombre,:apellidos)";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(":nombre",$nombre);
        $consulta->bindParam(":apellidos",$apellidos);
        $consulta->execute();
        
        $id=$conexionBD->lastInsertId();
        print_r($id);
        $cursos=$_POST["cursos"];
        foreach($cursos as $curso){
            $sql="INSERT INTO alumno_curso (idalumno,idcurso) VALUES (:id_alumno,:id_curso)";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(":id_alumno",$id);
            $consulta->bindParam(":id_curso",$curso);
            $consulta->execute();
        }
        $arregloCursos=$cursos;

        break;
    case "borrar":

        $sql="DELETE FROM alumnos WHERE id=:id";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(":id",$id);
        $consulta->execute();

    break;
    case "editar":
        $sql="UPDATE alumnos SET nombre=:nombre,apellidos=:apellidos WHERE id=:id";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(":nombre",$nombre);
        $consulta->bindParam(":apellidos",$apellidos);
        $consulta->bindParam(":id",$id);
        $consulta->execute();
        /*print_r($_POST);
        print_r($cursos);*/

        if(isset($cursos)){
            $sql="DELETE FROM alumno_curso WHERE idalumno=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(":id",$id);
            $consulta->execute();

            foreach($cursos as $curso){
                $sql = "INSERT INTO alumno_curso (idalumno, idcurso) VALUES (?, ?)";
                $ejecutarSentencia= $conexionBD->prepare($sql);
                $ejecutarSentencia->execute([$id,$curso]);
            }
            $arregloCursos=$cursos;
        }
        

        break;

    


}


}

$sqlCursos= $conexionBD->query("SELECT * FROM cursos");
$listaCursos=($sqlCursos->fetchAll());  

$sql="SELECT * FROM alumnos";
$listaAlumnos=$conexionBD->query($sql);
$alumnos=$listaAlumnos->fetchAll();

foreach($alumnos as $clave =>$alumno)
{
    $sql="SELECT * FROM cursos WHERE id IN (SELECT idcurso FROM alumno_curso WHERE idalumno=:id)";
    $consulta=$conexionBD->prepare($sql);
    $consulta->bindParam(":id",$alumno["id"]);
    $consulta->execute();
    $listaCursosAlumno=$consulta->fetchAll();
    $alumnos[$clave]["cursos"]=$listaCursosAlumno;

}


?>