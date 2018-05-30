<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

    // Incluimos el archivo que dispone de las diferentes funciones
    include 'funciones.inc';

    // Establecemos la zona horaria
    date_default_timezone_set('europe/madrid');
    
    // Recuperamos la información de la sesión
    session_start();
    
    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        die("Error - debe <a href='login.php'>identificarse</a>.<br />");
    }else{
        
        date_default_timezone_set('europe/madrid');
        $horario = $_SESSION['hora'] = date('H:i:s');
        $usuario = $_SESSION['usuario'];
    }
    
    // Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['eleccionUsuario'])) {
    
        //Obtenemos los datos enviados por POST y los volcamos a variables
        $opcionUsuario = $_POST['eleccionUsuario'];

        if ($opcionUsuario == "Acceder al tablón"){
            
            header("Location: tablon.php");
    
        } 
        
        if ($opcionUsuario == "Salir") {
            
            cerrarSesion($usuario);
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: Usuario invitado</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='invitado'>
            <form action='invitado.php' method='post'>
                <fieldset >
                    <legend>Opciones:</legend>
                    <div><span><?php echo 'Bienvenido: '.$usuario;?></span></div>
                    <div><span><?php echo 'Hora: '.$horario;?></span></div><br>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Acceder al tablón' />
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Salir' />
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