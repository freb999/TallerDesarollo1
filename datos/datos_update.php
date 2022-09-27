<?php

try {
    $mbd = new PDO('mysql:host=localhost;dbname=tallerd1', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {

    $statement = $mbd->prepare("UPDATE datos SET id_trabajador = :id_trabajador, direccion = :direccion, barrio = :barrio, fecha_ingreso = :fecha_ingreso, fecha_nacimiento = :fecha_nacimiento, edad = :edad, estatura = :estatura, email = :email WHERE id = :id");

    $statement->bindParam(':id', $id);
    $statement->bindParam(':id_trabajador', $id_trabajador);
    $statement->bindParam(':direccion', $direccion);
    $statement->bindParam(':barrio', $barrio);
    $statement->bindParam(':fecha_ingreso', $fecha_ingreso);
    $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $statement->bindParam(':edad', $edad);
    $statement->bindParam(':estatura', $estatura);
    $statement->bindParam(':email', $email);

    $id = $_POST['id'];
    $id_trabajador = $_POST['id_trabajador'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $edad = $_POST['edad'];
    $estatura = $_POST['estatura'];
    $email = $_POST['email'];

    $statement->execute();

    $statement = $mbd->prepare("SELECT * FROM datos WHERE id = ". $_POST['id']);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);
  
    $statement = $mbd->prepare("SELECT * FROM trabajador WHERE id = ". $post['id_trabajador']);
    $statement->execute();
    $persona = $statement->fetch(PDO::FETCH_ASSOC);  

    $post['data_fk'] = $persona;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro actualizado",
        "data" => $post
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
