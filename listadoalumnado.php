<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    <table border=1>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Aula</th>
        </tr>
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
            $resultado_query = $conn->query('select alumnado.dni, alumnado.nombre, alumnado.apellidos, alumnado.email, aulasVirtuales.nombrelargo from alumnado, matriculas, aulasVirtuales where alumnado.dni = matriculas.dni and matriculas.id_aula = aulasVirtuales.id;');

            // Recorrer la query tratándola como a un objeto
            $stock = $resultado_query->fetch_object();
            while($stock != null) {
                echo   "<tr>
                            <td>{$stock->dni}</td>
                            <td>{$stock->nombre}</td>
                            <td>{$stock->apellidos}</td>
                            <td>{$stock->email}</td>
                            <td>{$stock->nombrelargo}</td>
                        </tr>";
                $stock = $resultado_query->fetch_object();
            }

            // Vaciar recursos
            $resultado_query->free();

            // Cerramos la conexión
            $conn->close();
        ?>
    </table>
</body>
</html>
