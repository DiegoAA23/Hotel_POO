<?php
session_start();
require_once 'vendor/autoload.php';

use Uch\Hotel\Reservaciones;
use Uch\Hotel\Listado;

$reservaciones = Reservaciones::obtenerReservaciones();
Listado::limpiarListado();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones</title>
</head>

<body>
    <h1>Reservaciones Guardadas</h1>
    <a href="index.php">Regresar al Menu</a>
    <hr>
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

</body>

</html>