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

// Iniciamos la variable encargada de los mensajes.
$error = "";

// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['eleccion'])) {
    
    // Le pasamos el valor de la elección a una variable
    $opcionUsuario = $_POST['eleccion'];
    
    if($opcionUsuario == "Enviar"){
        
        // Obtenemos los datos enviados por POST y los volcamos a variables
        $usuario = $_POST['usuario'];
        $password = $_POST['password']; 

        //  Si el login está vacío lo comunicamos por mensaje
        if (empty($usuario)) {
            $error = "Debes introducir un login de usuario";
        
        // Si el password se encuentra vacío los comunicamos por mensaje.
        }else if(empty($password)) {
            $error = "Debes introducir un password de usuario";
            
        // en caso de que no se den los casos anteriores se llama a la función
        // encargada de comprobar el login
        }else{
            $error = login($usuario, $password);
        }
    }else{
        header('Location: index.php');
    }  
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: Login SinObsolescencia</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='login'>
            <form action='login.php' method='post'>
                <fieldset >
                    <legend>Introduce los datos de usuario</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='usuario' >Usuario:</label><br/>
                        <input type='text' name='usuario' id='usuario' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <label for='password' >Contraseña:</label><br/>
                        <input type='password' name='password' id='password' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccion' value='Enviar' />
                        <input type='submit' name='eleccion' value='Volver' />
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

