<?php 
    include("../../conexion.php");
    $stm=$conexion->prepare("SELECT * from espacios");
    $stm->execute();
    $espacios = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['id'])) {
        $txtid = (isset($_GET['id'])?$_GET['id']:"");
        $stm=$conexion->prepare("SELECT COUNT(idEspacio) as num FROM reservas WHERE idEspacio=:txtid ");
        $stm->bindParam(":txtid",$txtid);
        $stm->execute();
        $validacion=$stm->fetch(PDO::FETCH_LAZY);
        $numero=$validacion['num'];
        if ($numero==0) {
            $stm = $conexion->prepare("DELETE FROM espacios WHERE id = :txtid");
            $stm->bindParam(":txtid",$txtid);
            $stm->execute();
            header("location:index.php");
        }else {
            echo'<script type="text/javascript">
              alert("No se puede eliminar ya que este espacio cuenta con reservas.");
              window.location.href="index.php";
              </script>';
        }
        
    }
?>  


<?php include("../../componentes/header.php"); ?>  
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createEspacio">
  Nuevo Espacio
</button>
<br>
<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($espacios as $espacio) { ?>
            <tr class="">
                <td scope="row"><?php echo $espacio['id']; ?></td>
                <td><?php echo $espacio['nombreEspacio']; ?></td>
                <td>
                <a href="edit.php?id=<?php echo $espacio['id']; ?>" class="btn btn-warning">Editar</a>
                <a href="index.php?id=<?php echo $espacio['id']; ?>" class="btn btn-danger">Eliminar</a>

                </td>
            </tr>
        </tbody>
        <?php }?>
    </table>
</div>

<?php include("create.php") ?>
<?php include("../../componentes/footer.php"); ?>  