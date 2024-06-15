<?php
session_start();
require_once "vendor/autoload.php";

use Uch\Hotel\Reservaciones;
use Uch\Hotel\Reservacion;
use Uch\Hotel\CatalogoHabitaciones;
use Uch\Hotel\Listado;

$habitaciones = CatalogoHabitaciones::getHabitacionesAssoc();
$reservaciones;

$fechaplacehold = date('Y-m-d');
if (isset($_POST["btnReservas"])) {
    header("Location: reservaciones.php");
}

if (isset($_POST["btnGuardar"])) {
    $reservacion = new Reservacion();
    $reservacion->setNombreCliente($_POST["nombreCliente"]);
    $reservacion->setTelefono($_POST["telefono"]);
    $reservacion->setCorreo($_POST["correo"]);
    $reservacion->setFechaEntrada(new \DateTime($_POST["fechaEntrada"]));
    $reservacion->setFechaSalida(new \DateTime($_POST["fechaSalida"]));
    $reservacion->setNumeroPersonas(intval($_POST["numeroPersonas"]));
    $reservacion->addHabitacion(CatalogoHabitaciones::getHabitacionPorCodigo(intval($_POST["habitacion"])));
    $reservacion->setIncluyeDesayuno(isset($_POST["incluyeDesayuno"]));
    $reservacion->setCodigo(uniqid());
    Reservaciones::guardarReservacion($reservacion);
    Listado::guardarListado($reservacion);
    $reservaciones = Listado::obtenerListado();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Hotel</title>
</head>

<body>
    <h1>Reserva de Hotel</h1>
    <form action="index.php" method="post">
        <label for="nombreCliente">Nombre del Cliente:</label>
        <input type="text" name="nombreCliente" id="nombreCliente" placeholder="Nombre Completo" required>
        <br><br>
        <label for="telefono">Telefono:</label>
        <input type="number" name="telefono" id="telefono" placeholder="Telefono" required>
        <br><br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" placeholder="E-mail" required>
        <br><br>
        <label for="fechaEntrada">Fecha de Entrada:</label>
        <input type="date" name="fechaEntrada" id="fechaEntrada" value="<?php echo $fechaplacehold ?>" required>
        <br><br>
        <label for="fechaSalida">Fecha de Salida:</label>
        <input type="date" name="fechaSalida" id="fechaSalida" value="<?php echo $fechaplacehold ?>" required>
        <br><br>
        <label for="numeroPersonas">No. Personas:</label>
        <input type="number" name="numeroPersonas" id="numeroPersonas" required>
        <br><br>
        <label for="habitacion">Tipo de Habitación:</label>
        <select name="habitacion" id="habitacion" required>
            <?php foreach ($habitaciones as $habitacion) { ?>
                <option value="<?php echo $habitacion["codigo"]; ?>">
                    <?php echo $habitacion["descripcion"] . " / $" . $habitacion["price"]; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>
        <label for="incluyeDesayuno">Desayuno:</label>
        <input type="checkbox" name="incluyeDesayuno" id="incluyeDesayuno">
        <br><br>
        <input type="submit" value="Guardar" name="btnGuardar">
    </form>
    <br>
    <form action="index.php" method="post">
        <input type="submit" value="Ver Reservas" name="btnReservas">
    </form>

    <br>
    <hr>
    <?php if (!empty($reservaciones)) { ?>
        <table border="1">
            <tr>
                <th>Código</th>
                <th>Nombre de Cliente</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha de Entrada</th>
                <th>Fecha de Salida</th>
                <th>Días</th>
                <th>No. Personas</th>
                <th>Desayuno</th>
                <th>Habitación</th>
                <th>Subtotal</th>
                <th>ISV (15%)</th>
                <th>Imp. Hotelero (18%)</th>
                <th>Total</th>
            </tr>
            <?php
            $subtotal = 0;
            $isv = 0;
            $hotelero = 0;
            $total = 0; ?>
            <?php foreach ($reservaciones as $reservacion) { ?>
                <tr>
                    <td><?php echo $reservacion->getCodigo(); ?></td>
                    <td><?php echo $reservacion->getNombreCliente(); ?></td>
                    <td><?php echo $reservacion->getTelefono(); ?></td>
                    <td><?php echo $reservacion->getCorreo(); ?></td>
                    <td><?php echo $reservacion->getFechaEntrada()->format("Y-m-d"); ?></td>
                    <td><?php echo $reservacion->getFechaSalida()->format("Y-m-d"); ?></td>
                    <td><?php echo $reservacion->getDiasReserva(); ?></td>
                    <td><?php echo $reservacion->getNumeroPersonas(); ?></td>
                    <td><?php echo $reservacion->getIncluyeDesayuno() ? "Sí" : "No"; ?></td>
                    <td>
                        <?php foreach ($reservacion->getHabitaciones() as $habitacion) { ?>
                            <?php echo $habitacion->getDescripcion() . " - " . $habitacion->getTipo(); ?>
                        <?php } ?>
                    </td>
                    <td>
                        <?php $subtotal = ($reservacion->getPrecioTotal()); ?>
                        <?php echo "$" . $subtotal; ?>
                    </td>
                    <td> <?php $isv = ($reservacion->getPrecioTotal()) * 0.15; ?>
                        <?php echo "$" . $isv; ?>
                    </td>
                    <td>
                        <?php $hotelero = ($reservacion->getPrecioTotal()) * 0.18; ?>
                        <?php echo "$" . $hotelero; ?>
                    </td>
                    <td>
                        <?php $total = $subtotal + $isv + $hotelero; ?>
                        <?php echo "$" . $total; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</body>

</html>
</body>

</html>