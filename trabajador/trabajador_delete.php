<?php

try {
    $mbd = new PDO('mysql:host=localhost;dbname=tallerd1', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("DELETE FROM trabajador WHERE id = :id");
    $statement->bindParam(':id', $id);
    $id = $_POST['id'];

    $statement->execute();
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro eliminado",
        "data " => [
            "id" => $id,
            "descripcion" => "Todos los datos de $id han sido elminados"
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
