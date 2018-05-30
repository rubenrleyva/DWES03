<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

// Incluimos el archivo que dispone de las diferentes funciones
include 'funciones.inc';

//Iniciamos la sesion
session_start();

$error = "";
$usuario = "";
$password = "";
$passwordRepe = "";
$email = "";

// Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['enviar'])) {
    
        //Obtenemos los datos enviados por POST y los volcamos a variables
        $opcion = $_POST['enviar'];

        //Si es la opción ingresar
        if ($opcion == "Guardar") {
        
            //Obtenemos los datos enviados por POST y los volcamos a variables
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $passwordRepe = $_POST['passwordRepe'];
            $email = $_POST['email'];
            
            $error = comprobarDatos($usuario, $password, $passwordRepe, $email);
        
        // si es la opción de invitado
        } else if ($opcion == "Volver"){
            
            //Redireccionamos a la página que nos interesa
            header("Location: index.php");
    
        // si es la opción registrarse
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: Registro de Usuario Tablón de Anuncios</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='login'>
            <form action='registro.php' method='post'>
                <fieldset >
                    <legend>Resgistro Usuario</legend>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='usuario' >Usuario:</label><br/>
                        <input type='text' name='usuario' id='usuario' value='<?php echo $usuario; ?>' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <label for='password' >Contraseña:</label><br/>
                        <input type='password' name='password' id='password' value='<?php echo $password; ?>' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <label for='password' >Repetir Contraseña:</label><br/>
                        <input type='password' name='passwordRepe' id='passwordRepe' value='<?php echo $passwordRepe; ?>' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <label for='email' >Email:</label><br/>
                        <input type='email' name='email' id='email' value='<?php echo $email; ?>' maxlength="50" /><br/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='enviar' value='Guardar' /><input type='submit' name='enviar' value='Volver' />
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



