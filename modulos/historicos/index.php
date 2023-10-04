<?php 
    include("../../conexion.php");
    $stm=$conexion->prepare("SELECT * from reservas");
    $stm->execute();
    $reservas = $stm->fetchAll(PDO::FETCH_ASSOC);
    $stm=$conexion->prepare("SELECT * from espacios");
     $stm->execute();
     $espacios = $stm->fetchAll(PDO::FETCH_ASSOC);
     if ($_POST) {
        $idEspacio=(isset($_POST['Espacio'])?$_POST['Espacio']:"");
        $fecha=(isset($_POST['fecha'])?$_POST['fecha']:"");
        $stm=$conexion->prepare("SELECT * from reservas WHERE fecha = :fecha and idEspacio=:idEspacio");
        $stm->bindParam(":fecha",$fecha);
        $stm->bindParam(":idEspacio",$idEspacio);
        $stm->execute();
        $reservas=$stm->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<?php include("../../componentes/header.php"); ?>  
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
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Buscar</button>
      </div>
      </form>
<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Espacio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora inicio</th>
                <th scope="col">Hora fin</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reservas as $reserva) { ?>
            <tr class="">
            <td scope="row"><?php echo $reserva['id']; ?></td>
            <td><?php 
            $stm=$conexion->prepare("SELECT nombreEspacio from espacios Where id=:txtid");
            $stm->bindParam(":txtid",$reserva['idEspacio']);
            $stm->execute();
            $espSelecionado = $stm->fetch(PDO::FETCH_ASSOC);
            echo $espSelecionado['nombreEspacio']; ?></td>
            <td><?php echo $reserva['fecha']; ?></td>
            <td><?php echo $reserva['horaInicio']; ?></td>
            <td><?php echo $reserva['horaFinal']; ?></td>
            </tr>
        </tbody>
        <?php }?>
    </table>
</div>
<?php include("../../componentes/footer.php"); ?>  