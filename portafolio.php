<?php include "cabecera.php"; ?>

<?php include "conexion.php"; ?>
<br />


<?php
//Cargar Datos
if ($_POST) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $fecha = new DateTime();
    $img=$fecha->getTimestamp()."_". $_FILES['archivo']['name'];
    $img_tmp=$_FILES['archivo']['tmp_name'];
    move_uploaded_file( $img_tmp,"imgs/".$img);
    $objConexion = new conexion();
    $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `img`, `descripcion`) VALUES (NULL, '$nombre', '$img', '$descripcion');";
    $objConexion->ejecutar($sql);
}

if ($_GET) {

    $id = $_GET['id'];
    $objConexion = new conexion();


    $img=$objConexion->consultar("select img from proyectos where id=".$id);
    unlink("imgs/".$img[0]['img']);

    $sql = "DELETE FROM `proyectos` WHERE `proyectos`.`id` =" . $id;
    $objConexion->ejecutar($sql);


    
}
//Consultar Datos
$objConexion = new conexion();
$proyectos = $objConexion->consultar("select * From proyectos;");


?>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Datos del Proyecto
                </div>
                <div class="card-body">
                    <form action="portafolio.php" method="post" enctype="multipart/form-data">

                        Nombre del Proyecto : <input require type="text" name="nombre" id="" class="form-control">
                        <br />
                        Imgen del Proyecto : <input  type="file" name="archivo" id="" class="form-control">
                        <br />

                        Descripcion :
                        <div class="mb-3">
                            <textarea require class="form-control" name="descripcion" id="" rows="3"></textarea>
                        </div>
                        <br />

                        <input type="submit" value="Enviar Proyecto" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre Proyecto</th>
                            
                            <th scope="col">Imagen</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>


                    <tbody class="table-group-divider">
                        <?php
                        foreach ($proyectos as $proyecto) { ?>
                            <tr>
                                <td scope="row"><?php echo $proyecto['id']; ?></td>
                                <td scope="row"><?php echo $proyecto['nombre']; ?></td>
                                <td scope="row"><?php echo $proyecto['img']; ?></td>
                                <td scope="row"><?php echo $proyecto['descripcion']; ?></td>
                                <th> <a class="btn btn-danger" href="?id=<?php echo $proyecto['id']; ?>">Eliminar</a></th>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
















<?php
include("pie de pagina.php");
?>