<?php

try {
    $mbd = new PDO('mysql:host=localhost;dbname=tallerd1', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("UPDATE trabajador SET nombre = :nombre,  apellido = :apellido, telefono = :telefono WHERE id = :id");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':nombre', $nombre);
    $statement->bindParam(':apellido', $apellido);
    $statement->bindParam(':telefono', $telefono);

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    $statement->execute();
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro actualizado",
        "data" => [
            "id" => $id,
            "descripcion" => "los datos de esta persona han sido actualizados"
        ]
    ]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
