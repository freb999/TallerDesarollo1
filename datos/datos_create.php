<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=tallerd1', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}


try {

    $statement = $mbd->prepare("INSERT INTO datos (id_trabajador, direccion, barrio, fecha_ingreso, fecha_nacimiento, edad, estatura, email) 
    VALUES (:id_trabajador, :direccion, :barrio, :fecha_ingreso, :fecha_nacimiento, :edad, :estatura, :email)");

    $statement->bindParam(':id_trabajador', $id_trabajador);
    $statement->bindParam(':direccion', $direccion);
    $statement->bindParam(':barrio', $barrio);
    $statement->bindParam(':fecha_ingreso', $fecha_ingreso);
    $statement->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $statement->bindParam(':edad', $edad);
    $statement->bindParam(':estatura', $estatura);
    $statement->bindParam(':email', $email);

    $id_trabajador = $_POST['id_trabajador'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $edad = $_POST['edad'];
    $estatura = $_POST['estatura'];
    $email = $_POST['email'];

    $statement->execute();
    $_POST['id'] = $mbd->lastInsertId();

    $statement = $mbd->prepare("SELECT * FROM trabajador WHERE id = ". $_POST['id_trabajador']);
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($_POST);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
