<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'nombre_base_de_datos';
$user = 'nombre_usuario';
$password = 'contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Obtener todos los registros
function obtenerRegistros()
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM tabla');
    return $stmt->fetchAll();
}

// Obtener un registro por su ID
function obtenerRegistro($id)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM tabla WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Agregar un nuevo registro
function agregarRegistro($datos)
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO tabla (campo1, campo2, campo3) VALUES (?, ?, ?)');
    $stmt->execute([$datos['campo1'], $datos['campo2'], $datos['campo3']]);
    return $pdo->lastInsertId();
}

// Actualizar un registro existente
function actualizarRegistro($id, $datos)
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tabla SET campo1 = ?, campo2 = ?, campo3 = ? WHERE id = ?');
    return $stmt->execute([$datos['campo1'], $datos['campo2'], $datos['campo3'], $id]);
}

// Eliminar un registro
function eliminarRegistro($id)
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tabla WHERE id = ?');
    return $stmt->execute([$id]);
}

// Ejemplo de uso
// Obtener todos los registros
$registros = obtenerRegistros();
foreach ($registros as $registro) {
    echo $registro['campo1'] . ' ' . $registro['campo2'] . ' ' . $registro['campo3'] . '<br>';
}

// Obtener un registro por su ID
$idRegistro = 1;
$registro = obtenerRegistro($idRegistro);
echo $registro['campo1'] . ' ' . $registro['campo2'] . ' ' . $registro['campo3'] . '<br>';

// Agregar un nuevo registro
$nuevoRegistro = [
    'campo1' => 'Valor campo 1',
    'campo2' => 'Valor campo 2',
    'campo3' => 'Valor campo 3'
];
$idInsertado = agregarRegistro($nuevoRegistro);
echo 'ID del nuevo registro: ' . $idInsertado . '<br>';

// Actualizar un registro existente
$idActualizar = 2;
$datosActualizar = [
    'campo1' => 'Nuevo valor campo 1',
    'campo2' => 'Nuevo valor campo 2',
    'campo3' => 'Nuevo valor campo 3'
];
actualizarRegistro($idActualizar, $datosActualizar);

// Eliminar un registro
$idEliminar = 3;
eliminarRegistro($idEliminar);
?>
