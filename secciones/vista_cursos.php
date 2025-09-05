<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/cursos.php') ?>
<link rel="stylesheet" href="../styles/vista_cursos.css">

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <br/><br/>
        <div class="card">
            <form action="" method="post">
            <div class="card-header">Cursos </div>
            <div class="card-body">
            
            <div class="mb-3">
              <label for="id" class="form-label">ID</label>
              <input type="text"
                class="form-control" 
                value="<?php echo $id;?>" 
                name="id" id="id" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text"
                class="form-control" 
                value="<?php echo $nombre;?>" 
                name="nombre" id="nombre" aria-describedby="helpId" 
                placeholder="Nombre del curso">
            </div>

            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" value="editar" class="btn btn-warning">Editar</button>
                <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
            </div>  

            </div>
            </form>
        </div>

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
                    <?php foreach($listaCursos as $curso): ?>
                    <tr>
                        <td><?php  echo $curso["id"]; ?></td>
                        <td><?php  echo $curso["nombre_curso"]; ?></td>
                        <td>

                    <form action="" method="post">
                    <input type="hidden" name="id" id="accion" value="<?php echo $curso["id"];?>">
                    <input class="btn btn-info" type="submit" name="accion" value="seleccionar" />
                    </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            
        </div>
        
    </div>
</div>


<?php include('../templates/pie.php'); ?>