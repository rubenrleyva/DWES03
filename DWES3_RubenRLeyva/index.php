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

// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['eleccion'])) {
    
    // Obtenemos los datos enviados por POST y los volcamos a variables
    $opcion = $_POST['eleccion'];

    //Si es la opción ingresar usuario
    if ($opcion == "Ingresar Usuario") {
        
        //Redireccionamos a la página que nos interesa
        header("Location: login.php"); 
        
    // si es la opción de ingresar invitado
    } else if ($opcion == "Ingresar Invitado"){
            
        $_SESSION['usuario'] = 'Invitado';
            
        //Redireccionamos a la página que nos interesa
        header("Location: invitado.php");
    
    // si es la opción de registrar usuario
    } else if ($opcion == "Registrar Usuario") {
            
        //Redireccionamos a la página que nos interesa
        header("Location: registro.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: SinObsolescencia</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='index'>
            <form action='index.php' method='post'>
                <fieldset >
                    <legend>SinObsolescencia</legend>
                    <div class='campo'>
                        <input type='submit' name='eleccion' value='Ingresar Usuario'/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccion' value='Ingresar Invitado' />
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccion' value='Registrar Usuario' />
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

