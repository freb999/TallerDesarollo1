<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=tallerd1', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

try {


    $statement = $mbd->prepare("SELECT * FROM datos WHERE id = ". $_POST['id']);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);
  
    $statement = $mbd->prepare("SELECT * FROM trabajador WHERE id = ". $post['id_trabajador']);
    $statement->execute();
    $persona = $statement->fetch(PDO::FETCH_ASSOC);  

    $post['data_fk'] = $persona;

    $statement = $mbd->prepare("DELETE FROM datos WHERE id = :id");
    $statement->bindParam(':id', $id);    
    $id = $_POST['id'];
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        "mensaje" => "Registro eliminado ",
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
