<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

    // Incluimos el archivo que dispone de las diferentes funciones
    include 'funciones.inc';
    
    // Colocamos un color por defecto para el fondo
    $color="white";
    
    // Recuperamos la información de la sesión
    session_start();
    
    // Comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        die("Error - debe <a href='login.php'>identificarse</a>.<br />");
        
    // si no hay error    
    }else{
        
        // comprobamos que es un invitado
        if($_SESSION['usuario'] == "Invitado"){
            $invitado = true;
            $usuario = $_SESSION['usuario'];
            
        // en caso contrario será otro usuario diferente a un invitado    
        }else{ 
            $invitado = false;
            $usuario = $_SESSION['usuario'];
        }
    }
    
    
    // Comprobamos si existe la cookie del color.
    if (!empty($_COOKIE['color'])) {
    
        // Recorremos la cookie
        foreach ($_COOKIE['color'] as $name => $value) {
        
            // Comprobamos que el nombre se corresponde con el del usuario.
            if($name == $_SESSION['usuario']){
            
                // Le pasamos el valor a la variable color.
                $color = $value;
            }
        }
    }
    
    // Comprobamos la elección del usuario
    if(isset($_POST['eleccionUsuario'])){
        
        // le pasamos la opción del usuario
        $opcionUsuario = $_POST['eleccionUsuario'];
        
        // si se elige desconectar
        if($opcionUsuario == "Desconectar usuario $usuario"){
            cerrarSesion($usuario);
            
        // si en caso contrario    
        }else{
            
            // si elegimos el usuaio invitado vamos a la página usuario
            if($_SESSION['usuario'] == "Invitado"){
               header('Location: invitado.php');
               
            // en caso contrario vamos a la página voluntario   
            }else{
                header('Location: voluntario.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Tarea 3: Tablón de anuncios</title>
    <link href="tablon.css" rel="stylesheet" type="text/css">
</head>
    <body style='background: <?php echo $color; ?>'>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>

        <div id="contenedor">
            <div id="encabezado"><h1>Listado de anuncios</h1></div>
                <div id="productos">
                    
                <?php
                
                    // Mostramos los anuncios
                    mostrarAnuncios($invitado);
                ?>

                </div>
            <div id="pie">
                <form action='tablon.php' method='post'>
                    <input type='submit' name='eleccionUsuario' value='Desconectar usuario <?php echo $usuario;?>'/>
                    <input type='submit' name='eleccionUsuario' value='Volver'/>
                </form>  
                
                <?php
                
                    // Mostramos si hay algún error
                    if (isset($error)) {
                        print "<p class='error'>Error $error: $mensaje</p>";
                    }
                ?>
                
            </div>
        </div>
        
        <?php
        
        // Pie de la página Web
        pie("Desarrollo de aplicaciones Web en PHP - Tarea 3");
        
        ?>
        
    </body>
</html>

