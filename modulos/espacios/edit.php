<?php 
    include("../../conexion.php");
    if (isset($_GET['id'])) {
        $txtid = (isset($_GET['id'])?$_GET['id']:"");
        $stm = $conexion->prepare("SELECT *  FROM espacios WHERE id = :txtid");
        $stm->bindParam(":txtid",$txtid);
        $stm->execute();
        $espacio=$stm->fetch(PDO::FETCH_LAZY);
        $nombre=$espacio['nombreEspacio'];

    }
    if ($_POST) {
        $txtid=(isset($_POST['txtid'])?$_POST['txtid']:"");
        $nombre=(isset($_POST['nombre'])?$_POST['nombre']:"");
        $stm=$conexion->prepare("UPDATE espacios SET nombreEspacio=:nombre WHERE id=:txtid");
        $stm->bindParam(":nombre",$nombre);
        $stm->bindParam(":txtid",$txtid);
        $stm->execute();
        header("location:index.php");
    }

    
?>     
    <?php include("../../componentes/header.php"); ?>    
    <form action="" method="post">
      <div class="modal-body">
        <input type="hidden" class = "form-control" name="txtid" value="<?php echo $txtid; ?>" placeholder="Ingresa un nombre">
        <label for="">Nombre</label>
        <input type="text" class = "form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Ingresa un nombre">
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
      </form>
      <?php include("../../componentes/footer.php"); ?>  