<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/alumnos.php') ?>

<link rel="stylesheet" href="../styles/vista_alumnos.css">
<div class="container">
    <div class="row">
        <div class="col-md-5">
        <br/><br/>
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                  Alumnos
                </div>
                <div class="card-body">
                
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text"
                        class="form-control" name="id" value="<?php echo $id;?>"  id="id" aria-describedby="helpId" placeholder="ID">
                </div>        
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre:</label>
                  <input type="text"
                    class="form-control" value="<?php echo $nombre;?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="nombre">
                </div>

                <div class="mb-3">
                  <label for="apellidos" class="form-label">Apellidos</label>
                  <input type="text"
                    class="form-control" value="<?php echo $apellidos;?>" name="apellidos" id="apellidos" aria-describedby="helpId" placeholder="Apellidos">
                  
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Curso del alumno:</label>
                  <select multiple class="form-control" name="cursos[]" id="ListaCursos">

                    <?php foreach($listaCursos as $curso):?>
                        
                        <option
                            
                            <?php if(!empty($arregloCursos)):
                                    if(in_array($curso["id"],$arregloCursos)): ?>
                                selected
                            <?php   endif;endif; ?>

                        value="<?php echo $curso["id"];?>"><?php echo $curso["nombre_curso"];?></option>
                    <?php endforeach;?>
                    

                  </select>
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button value="agregar" name="accion" type="submit" class="btn btn-success">Agregar</button>
                    <button value="editar" name="accion" type="submit" class="btn btn-warning">Editar</button>
                    <button value="borrar" name="accion" type="submit" class="btn btn-danger">Borrar</button>
                </div>
                

                </div>
                
            </div>

        </form>    
        </div>
        <div class="col-md-7">
            <br/><br/>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($alumnos as $alumno){ ?>    
                <tr>
                    <td ><?php echo $alumno["id"]; ?></td>
                    <td>
                        
                    <?php echo $alumno["nombre"]; ?> <?php echo $alumno["apellidos"]; ?>
                    <br/> 
                    <?php 
                        foreach($alumno["cursos"] as $curso){ ?>
                         
                        - <a href="certificado.php?idcurso=<?php echo $curso["id"]; ?>&idalumno=<?php echo $alumno["id"]; ?>">
                         <?php echo $curso["nombre_curso"]; ?></a><br/>

                        <?php  }    ?>
                </td>
                    <td> 
                        <form action="" method="post">
                            <input type="text" name="id" id="id"
                             value="<?php echo $alumno["id"]; ?>">

                            <input type="submit" value="seleccionar" 
                            name="accion" />
                            <input type="submit" value="borrar" 
                            name="accion" />

                        </form>    
                    </td>
                    </tr>
                   <?php } ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.2/dist/js/tom-select.complete.min.js"></script>
<script>

new TomSelect('#ListaCursos');
</script>

<?php include('../templates/pie.php'); ?>
       
     