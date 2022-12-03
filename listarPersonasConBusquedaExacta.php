<?php
include_once "base_de_datos.php";


$consulta = "SELECT * FROM personas";

$busqueda = null;
if (isset($_GET["busqueda"])) {
    $busqueda = $_GET["busqueda"];
    $consulta = "SELECT * FROM personas WHERE nombre = ?";
}
$sentencia = $base_de_datos->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);

if ($busqueda === null) {
 
    $sentencia->execute();
} else {
    $parametros = [$busqueda];
    $sentencia->execute($parametros);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Tabla de ejemplo</title>
	<style>
	table, th, td {
	    border: 1px solid black;
	}
	</style>
</head>
<body>
    <form action="listarPersonasConBusquedaExacta.php" method="GET">
        <input type="text" placeholder="Buscar por nombre" name="busqueda">
        <br>
        <br>
        <button type="submit">Buscar</button>
        <br>
        <br>
    </form>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Género</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($persona = $sentencia->fetchObject()) {?>
			<tr>
				<td><?php echo $persona->id ?></td>
				<td><?php echo $persona->nombre ?></td>
				<td><?php echo $persona->apellidos ?></td>
				<td><?php echo $persona->sexo ?></td>
				<td><a href="<?php echo "editar.php?id=" . $persona->id ?>">Editar</a></td>
				<td><a href="<?php echo "eliminar.php?id=" . $persona->id ?>">Eliminar</a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</body>
</html>