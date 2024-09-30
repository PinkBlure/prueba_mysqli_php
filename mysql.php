<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // Establecer conexión con el servidor
        $conn = new mysqli('localhost',
                           'root',
                           '',
                           'campus');

        // Comprobar el error con el atributo connect_errno
        $error = $conn ->connect_errno;
        if ($error != null) {
            echo $error;
            die();
        }

        // Query para ver la tabla alumnado
        $resultado_query = $conn->query('select * from alumnado');

        // Recorrer la query tratándola como a un objeto
        $stock = $resultado_query->fetch_object();
        while($stock != null) {
            echo "<p>Alumno: $stock->dni -
                             $stock->nombre -
                             $stock->apellidos -
                             $stock->email</p>";
            $stock = $resultado_query->fetch_object();
        }

        // Cerramos la conexión
        $conn->close();
    ?>
</body>
</html>
