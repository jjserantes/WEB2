<?php
session_start(); // Iniciar la sesión

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no hay sesión activa, redirigir a la página de login
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include("conexiondlb.php");

// Verificar la conexión a la base de datos
try {
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa<br>";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

// Verificar la variable de sesión idusuario
if (!isset($_SESSION['idusuario'])) {
    echo "La variable de sesión 'idusuario' no está definida.";
    exit();
}

// Procesar el formulario de añadir incidencia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha']) && isset($_POST['descripcion'])) {
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $idusuario = $_SESSION['idusuario']; // Asegúrate de que esta variable está definida en tu sesión

    // Mostrar datos para depuración
    echo "Datos recibidos: Fecha - $fecha, Descripción - $descripcion, IdUsuario - $idusuario<br>";

    // Preparar y ejecutar la consulta para insertar una nueva incidencia
    $sql = "INSERT INTO incidencias (fecha, descripcion, idusuario) VALUES (:fecha, :descripcion, :idusuario)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':idusuario', $idusuario);

    if ($stmt->execute()) {
        echo "Incidencia añadida correctamente.";
    } else {
        echo "Error al añadir incidencia.";
        print_r($stmt->errorInfo()); // Mostrar información de error
    }
}

// Preparar y ejecutar la consulta para obtener las incidencias
$sql = "SELECT id, fecha, descripcion, idusuario FROM incidencias";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerrar la conexión
$conexion = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <img src="Imagenes/images.jfif" alt="logoweb">
        <div class="user-menu">
            <img id="imgUser" class="imgUser" src="Imagenes/3736502.png" alt="usuario">
            <ul id="userMenu">
                <li><a href="#">Datos de usuario</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </header>   
    <main>
        <aside>
            <ul>
                <li><i class="fa-solid fa-cart-shopping"></i>Pedidos</li>
                <li><i class="fa-solid fa-file-invoice"></i>Facturas</li>
                <li><i class="fa-solid fa-circle-exclamation"></i>Incidencias</li>
                <li><i class="fa-solid fa-calendar"></i>Calendario</li>
                <li><i class="fa-solid fa-newspaper"></i>Presupuestos</li>
            </ul>
        </aside>
        <div class="asidemovil">
            <i class="fa-solid fa-bars"></i>
            <ul>
                <li><i class="fa-solid fa-cart-shopping"></i>Pedidos</li>
                <li><i class="fa-solid fa-file-invoice"></i>Facturas</li>
                <li><i class="fa-solid fa-circle-exclamation"></i>Incidencias</li>
                <li><i class="fa-solid fa-calendar"></i>Calendario</li>
                <li><i class="fa-solid fa-newspaper"></i>Presupuestos</li>
            </ul>
        </div>
        <section class="contenedorPrincipal">
            <h3>Listado Incidencias</h3>
                <div class="incidencias">
                    <form action="" method="post">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" required>
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" required>
                        <button type="submit">Añadir</button>
                    </form>
                </div>
                <div class="lista">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>IdUsuario</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($incidencias as $incidencia) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($incidencia['id']); ?></td>
                                    <td><?php echo htmlspecialchars($incidencia['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($incidencia['descripcion']); ?></td>
                                    <td><?php echo htmlspecialchars($incidencia['idusuario']); ?></td>
                                    <td>
                                        <i class="fa-solid fa-trash"></i>
                                        <i class="fa-solid fa-edit"></i>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </section>
    </main>   
    <script src="js/main.js"></script>
    <footer>
        <p>FORMACOM &copy; 2024</p>
    </footer> 
</body>
</html>

