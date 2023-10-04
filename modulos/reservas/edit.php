<?php 
    include("../../conexion.php");
    $stm=$conexion->prepare("SELECT * from espacios");
     $stm->execute();
     $espacios = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_GET['id'])) {
        $txtid = (isset($_GET['id'])?$_GET['id']:"");
        $stm = $conexion->prepare("SELECT * FROM reservas WHERE id = :txtid");
        $stm->bindParam(":txtid",$txtid);
        $stm->execute();
        $reserva=$stm->fetch(PDO::FETCH_LAZY);
        $fecha=$reserva['fecha'];
        $horaIni=$reserva['horaInicio'];
        $horaFin=$reserva['horaFinal'];
        $idEspacio=$reserva['idEspacio'];

    }
    if ($_POST) {
        $txtid=(isset($_POST['txtid'])?$_POST['txtid']:"");
        $fecha=(isset($_POST['fecha'])?$_POST['fecha']:"");
        $idEspacio=(isset($_POST['Espacio'])?$_POST['Espacio']:"");
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
            $stm=$conexion->prepare("UPDATE reservas SET fecha=:fecha , idEspacio=:Espacio, horaInicio=:horaIni, horaFinal=:horaFin WHERE id=:txtid");
            $stm->bindParam(":fecha",$fecha);
            $stm->bindParam(":Espacio",$idEspacio);
            $stm->bindParam(":horaIni",$horaIni);
            $stm->bindParam(":horaFin",$horaFin);
            $stm->bindParam(":txtid",$txtid);
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
    <?php include("../../componentes/header.php"); ?>    
    <form action="" method="post">
    <div class="modal-body">
        <input type="hidden" class = "form-control" name="txtid" value="<?php echo $txtid; ?>" placeholder="Ingresa un nombre">
        <label for="">Escoge el Espacio:</label>
        <select class="form-select" name="Espacio" id="Espacio">
          <?php
          foreach ($espacios as $espacio) {
          ?>
          <?php
          if ($espacio['id']==$idEspacio) {?>
            <option value="<?php echo $espacio['id']; ?>" selected><?php echo $espacio['nombreEspacio']; ?></option>
            <?php }else { ?>
                <option value="<?php echo $espacio['id']; ?>"><?php echo $espacio['nombreEspacio']; ?></option>
                <?php } ?>
          
          <?php } ?>
          
        </select>
        <label for="">Fecha</label>
        <input type="date" class = "form-control" name="fecha" value="<?php echo $fecha; ?>" placeholder="">
        <label for="">Hora inicio</label>
        <input type="time" class = "form-control" name="horaIni" value="<?php echo $horaIni; ?>" placeholder="">
        <label for="">Hora Fin</label>
        <input type="time" class = "form-control" name="horaFin" value="<?php echo $horaFin; ?>" placeholder="">
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-secondary" data-dismiss="modal">Cerrar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
      <?php include("../../componentes/footer.php"); ?>  