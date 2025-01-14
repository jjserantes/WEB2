
<?php
if(isset($_POST["nombre"])){
    include("conexiondlb.php");
    try {
        // Preparar y ejecutar la consulta SQL
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, fecha, password) 
                VALUES (:nombre, :apellidos, :email, :fecha, :password)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $_POST["nombre"]);
        $stmt->bindParam(':apellidos', $_POST["apellidos"]);
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->bindParam(':fecha', $_POST["fecha"]);
        // Encriptar la contraseña antes de guardarla
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        //$stmt->bindParam(':password', $_POST["password"]);
        $stmt->execute();
    
        echo "Registro insertado exitosamente";
    
        // Redirigir a la página de login   
        header("Location: login.php");
    } catch (PDOException $e) {
        echo "Conexión fallida: " . $e->getMessage();
    }
 }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/registro.css">
</head>
<body>    
    <header>
        <img src="Imagenes/images.jfif" alt="logoweb">
        <h1>Google Classroom</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="registro.php">Registro</a></li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul> 
    </nav>    
    <div id="hola">
        <img src="Imagenes/images2.jfif" alt="logoweb">
        <form class="register" action="" method="post">
            <label for="Nombre">Nombre</label>
            <input required type="text" name="nombre" id="Nombre">
            <label for="Apellidos">Apellidos</label>
            <input required type="text" name="apellidos" id="Apellidos">
            <label for="Email">Correo electrónico</label>
            <input required type="email" name="email" id="Email">           
            <label for="fecha">Fecha de Nacimiento</label>
            <input required type="date" name="fecha" id="Fecha de Nacimiento">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password">
            <label for="repassword">Introduce de nuevo la contraseña</label>
            <input type="password" name="repassword" id="repassword">
            <span id="msg">*Las Contraseñas deben de ser iguales</span>
            <button id="btnCrear"disabled>Crear usuario</button>
        </form>
        <p>*Si ya dispones de usuario <a href="login.php">Entrar aquí</a></p>
    </div>
    <script src="js/registro.js"></script>
    <footer>
        <p>FORMACOM &copy; 2024</p>
    </footer>
</body>
</html>
