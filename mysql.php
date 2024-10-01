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

        // Vaciar recursos
        $resultado_query->free();

        // Query para ver la tabla aulasVirtuales
        $resultado_query = $conn->query('select * from aulasVirtuales');

        // Recorrer la query tratándola como a un objeto
        $stock = $resultado_query->fetch_object();
        while($stock != null) {
            echo "<p>Aula Virtual: $stock->id -
                             $stock->nombrecorto -
                             $stock->nombrelargo</p>";
            $stock = $resultado_query->fetch_object();
        }

        // Vaciar recursos
        $resultado_query->free();

        // Query para ver la tabla aulasVirtuales
        $resultado_query = $conn->query('select * from matriculas');

        // Recorrer la query tratándola como a un objeto
        $stock = $resultado_query->fetch_object();
        while($stock != null) {
            echo "<p>Matrículas: $stock->id_aula -
                             $stock->dni</p>";
            $stock = $resultado_query->fetch_object();
        }

        // Vaciar recursos
        $resultado_query->free();

        // Reinicio de la tabla
        eliminarAlumnoDni($conn, "12345678J");

        // Actividad
        insertarAlumno($conn, "32874627K", "Alberto", "Fernández");
        insertarAlumno($conn, "85437437I", "Naima", "Díaz");
        insertarAlumno($conn, "84384758J", "Oliver", "Martinez");
        insertarAlumno($conn, "38294758P", "Carlos", "Dominguez");
        insertarAlumno($conn, "48938475T", "Carol", "DelaNuez");

        matricular($conn, 1, "32874627K");
        matricular($conn, 1, "85437437I");
        matricular($conn, 1, "84384758J");
        matricular($conn, 1, "38294758P");
        matricular($conn, 1, "48938475T");

        // -- FUNCIONES --
        
        function eliminarAlumnoDni($conn, $dni) {

            // Uso la forma segura de rellenar queries con funciones
            $resultado_query =  $conn->prepare("DELETE FROM alumnado WHERE alumnado.dni = ?");
            $resultado_query->bind_param("s", $dni);

            if ($resultado_query->execute()) {
                if ($conn->affected_rows > 0) {
                    echo "<p>Se han eliminado $conn->affected_rows registros.</p>";
                } else {
                    echo "<p>No se eliminaron registros, quizás no existe el registro con el DNI especificado.</p>";
                }
            } else {
                echo "<p>Error al intentar eliminar el registro: " . $conn->error . "</p>";
            }

            // Hay que cerrar el statement
            $resultado_query->close();
        }

        function insertarAlumno($conn, $dni, $nombre, $apellidos) {
            // Crear el correo concatenando nombre y apellidos
            $email = $nombre . $apellidos . "@gmail.com";
            echo "Hola2";

            // Preparar la consulta
            $resultado_query = $conn->prepare("INSERT INTO alumnado (dni, nombre, apellidos, email) VALUES (?, ?, ?, ?)");

            echo "Hola2";

            if ($resultado_query === false) {
                echo "<p>Error en la preparación de la consulta: " . $conn->error . "</p>";
                return;
            }

            echo "Hola2";

            // Usar "ssss" ya que todos son strings
            $resultado_query->bind_param("ssss", $dni, $nombre, $apellidos, $email);

            echo "Hola2";

            // Ejecutar la consulta
            if ($resultado_query->execute()) {
                echo "<p>Se han insertado $resultado_query->affected_rows registros.</p>";
            } else {
                echo "<p>Error al intentar insertar el registro: " . $resultado_query->error . "</p>";
            }

            echo "Hola2";

            // Cerrar el statement
            $resultado_query->close();

            echo "Hola2";
        }

        function matricular($conn, $dni, $id_aula) {
            $resultado_query = $conn->prepare("INSERT INTO matricula (id_aula, dni) VALUES (?, ?)");
            $resultado_query->bind_param("is", $id_aula, $dni);

            if ($resultado_query->execute()) {
                echo "<p>Se han insertado $conn->affected_rows registros.</p>";
            } else {
                echo "<p>Error al intentar eliminar el registro: " . $conn->error . "</p>";
            }
        }

        // Cerramos la conexión
        $conn->close();
    ?>
</body>
</html>
