<?php
session_start(); // Iniciar la sesión

if (isset($_POST["email"])) {
    include("conexiondlb.php");
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Preparar y ejecutar la consulta para obtener el hash de la contraseña almacenada y el idusuario
    $sql = "SELECT id, password FROM usuarios WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        // Guardar el email y idusuario del usuario en la sesión
        $_SESSION['email'] = $email;
        $_SESSION['idusuario'] = $result['id'];

        // Redirigir a la página de inicio o dashboard
        header("Location: main.php");
        exit(); // Terminar el script para evitar que el resto del código se ejecute
    } else {
        $error = "Email o contraseña incorrectos";
    }

    // Cerrar la conexión
    $conexion = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web2 - Login</title>
    <link rel="stylesheet" href="CSS/login.css">
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
        <form action="" method="post" id="formulario">
            <label for="usuario">Usuario</label>
            <input type="email" name="email" id="usuario" placeholder="Introduce tu email">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <button type="submit">Login</button>
            <p>¿No tienes usuario? <a href="registro.php">Entrar aquí</a></p>
            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
        </form>
    </div>

<!--<script src="js/login.js"></script>-->
</body>
<footer>
    <p>FORMACOM &copy; 2024</p>
</footer>
</html>
