<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

    // Incluimos el archivo que dispone de las diferentes funciones
    include 'funciones.inc';

    // Recuperamos la información de la sesión
    session_start();

    // Color del fondo por defecto
    $color = "white";

    // Comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        die("Error - debe <a href='login.php'>identificarse</a>.<br />");

    }else{
        
        date_default_timezone_set('europe/madrid');
        $fecha = $_SESSION['hora'] = date('H:i:s');
        $usuario = $_SESSION['usuario'];
    }

    

    // Comprobamos si existe la cookie con el corlor  
    if (!empty($_COOKIE['color'])) {

        // Vamos pasando el array para comprobar los valores que tiene
        foreach ($_COOKIE['color'] as $name => $value) {

            // Comprobamos si el array tiene un color asociado al usuario
            // que esta en este momento en sesión
            if($name == $_SESSION['usuario']){

                // Le pasamos el valor a la variable color
                $color = $value;
            }
        }
    }

    // Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['eleccionUsuario'])) {

        // Obtenemos los datos enviados por POST y los volcamos a variables
        $opcionUsuario = $_POST['eleccionUsuario'];

        // Si es la opción crear anuncio
        if($opcionUsuario == "Crear Anuncio") {

            // Vamos a la página correspondiente
            header("Location: anuncio.php"); 
        }

        // Si es la opción de acceder al tablón
        if($opcionUsuario == "Acceder al tablón"){

            // Vamos a la página correspondiente
            header("Location: tablon.php");

        } 

        // Si la opción es ir a preferencias
        if($opcionUsuario == "Preferencias") {

            // Vamos a la página correspondiente
            header("Location: preferencias.php");
        }

        // Si la opción es desconexión
        if($opcionUsuario == "Desconexión") {

            cerrarSesion($name);
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
        
        <div id='voluntario'>
            <form action='voluntario.php' method='post'>
                <fieldset>
                    <div><span>Bienvenido<?php echo ' '.$usuario;?></span></div>
                    <div><span><?php echo 'Fecha: '.$fecha ;?></span></div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Crear Anuncio'/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Acceder al tablón' />
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Preferencias' />
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Desconexión' />
                    </div>
                </fieldset>
            </form>
        </div>
                    
         <?php
        
        // Pie de la página Web
        pie("Desarrollo de aplicaciones Web en PHP - Tarea 3");
        
        ?>           
                                  
    </body>
</html>

