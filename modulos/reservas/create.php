
<?php
     $stm=$conexion->prepare("SELECT * from espacios");
     $stm->execute();
     $espacios = $stm->fetchAll(PDO::FETCH_ASSOC);
    if ($_POST) {
        $idEspacio=(isset($_POST['Espacio'])?$_POST['Espacio']:"");
        $fecha=(isset($_POST['fecha'])?$_POST['fecha']:"");
        $horaIni=(isset($_POST['horaIni'])?$_POST['horaIni']:"");
        $horaFin=(isset($_POST['horaFin'])?$_POST['horaFin']:"");
        $stm=$conexion->prepare("SELECT COUNT(fecha) as num FROM reservas WHERE fecha=:fecha and idEspacio=:idEspacio and ((horaInicio<=:horaIni and horaFinal>=:horaIni) or (horaInicio<=:horaFin and horaFinal>=:horaFin))");
        $stm->bindParam(":fecha",$fecha);
        $stm->bindParam(":idEspacio",$idEspacio);
        $stm->bindParam(":horaIni",$horaIni);
        $stm->bindParam(":horaFin",$horaFin);
        $stm->execute();
        $validacion=$stm->fetch(PDO::FETCH_LAZY);
        $numero=$validacion['num'];
        if ($numero==0) {
          $stm=$conexion->prepare("INSERT INTO reservas(id,fecha,idEspacio,horaInicio,horaFinal)
          VALUES(null,:fecha,:idEspacio,:horaIni,:horaFin)");
          
          $stm->bindParam(":fecha",$fecha);
          $stm->bindParam(":idEspacio",$idEspacio);
          $stm->bindParam(":horaIni",$horaIni);
          $stm->bindParam(":horaFin",$horaFin);
          $stm->execute();
          
          header("location:index.php");
        }else {
          echo'<script type="text/javascript">
              alert("Ya existe una reserva a esa hora");
              window.location.href="index.php";
              </script>';
        }
       
    }
?>


<div class="modal fade" id="createReserva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Reserva</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
      <div class="modal-body">
        <label for="cars">Escoge el Espacio:</label>
        <select class="form-select" name="Espacio" id="Espacio">
          <?php
          foreach ($espacios as $espacio) {
          ?>
          <option value="<?php echo $espacio['id']; ?>"><?php echo $espacio['nombreEspacio']; ?></option>
          <?php } ?>
          
        </select>
        <label for="">Fecha</label>
        <input type="date" class = "form-control" name="fecha" value="" placeholder="">
        <label for="">Hora inicio</label>
        <input type="time" class = "form-control" name="horaIni" value="" placeholder="">
        <label for="">Hora Fin</label>
        <input type="time" class = "form-control" name="horaFin" value="" placeholder="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>