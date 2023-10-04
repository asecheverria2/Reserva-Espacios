
<?php
    if ($_POST) {
        $nombre=(isset($_POST['nombre'])?$_POST['nombre']:"");
        $stm=$conexion->prepare("INSERT INTO espacios(id,nombreEspacio)
        VALUES(null,:nombre)");
        $stm->bindParam(":nombre",$nombre);
        $stm->execute();
        header("location:index.php");
    }
?>


<div class="modal fade" id="createEspacio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Espacio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
      <div class="modal-body">
        <label for="">Nombre</label>
        <input type="text" class = "form-control" name="nombre" value="" placeholder="Ingresa un nombre">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>