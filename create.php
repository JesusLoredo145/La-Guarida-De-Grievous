<?php

//Inicia sesion

session_start();

//verifica si el usuario ha iniciado sesion

if (!isset($_SESSION['usuario'])) {

    //si no hay sesion, redirige al usuario a la pagina de login

    header("Location: login.php");
    exit;
}
//Incluye el archivo de conexion a la base de datos
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);

    // Usar consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO articulos (titulo, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $titulo, $contenido);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Artículo - Wiki Star Wars</title
    <link rel="stylesheet" href="styles.css">                                    
</head>
<body>
    <div class="crearContenido">
    <h2 class="titulo" style="text-align:center;">Nuevo Artículo</h2>
    <form method="post" action="">
        <input type="text" name="titulo" placeholder="Título" required class="agregaTitulo">
        <textarea name="contenido" placeholder="Contenido" rows="10" required class="textoContenido"></textarea>
        <button type="submit">Guardar</button>
    </form>
    </div>    
</body>
</html>
