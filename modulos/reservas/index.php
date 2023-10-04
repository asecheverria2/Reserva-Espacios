<?php 
include("../../conexion.php");
$stm=$conexion->prepare("SELECT * from reservas");
$stm->execute();
$espacios = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $txtid = (isset($_GET['id'])?$_GET['id']:"");
    $stm = $conexion->prepare("DELETE FROM reservas WHERE id = :txtid");
    $stm->bindParam(":txtid",$txtid);
    $stm->execute();
    header("location:index.php");
    }
   
?>

<?php include("../../componentes/header.php"); ?>  
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createReserva">
  Nueva reserva
</button>
<br>
<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Espacio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora inicio</th>
                <th scope="col">Hora fin</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($espacios as $espacio) { ?>
            <tr class="">
            <td scope="row"><?php echo $espacio['id']; ?></td>
            <td><?php 
            $stm=$conexion->prepare("SELECT nombreEspacio from espacios Where id=:txtid");
            $stm->bindParam(":txtid",$espacio['idEspacio']);
            $stm->execute();
            $espSelecionado = $stm->fetch(PDO::FETCH_ASSOC);
            echo $espSelecionado['nombreEspacio']; ?></td>
            <td><?php echo $espacio['fecha']; ?></td>
            <td><?php echo $espacio['horaInicio']; ?></td>
            <td><?php echo $espacio['horaFinal']; ?></td>
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