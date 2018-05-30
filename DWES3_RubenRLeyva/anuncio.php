<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

    // Incluimos el archivo que dispone de las diferentes funciones
    include 'funciones.inc';

    // Iniciamos algunas variables.
    $color = "white";
    
    
    
    //Iniciamos la sesion
    session_start();

    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        die("Error - debe <a href='login.php'>identificarse</a>.<br />");
    }else{
        
        date_default_timezone_set('europe/madrid');
        $horario = $_SESSION['hora'] = date('H:i:s');
        $usuario = $_SESSION['usuario'];
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

    // Iniciamos la variable encargada de mostrar los errores.
    $error = "";

    // Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['eleccionUsuario'])) {
    
        // Comprobamos la opción escogida por el usuario
        $opcionUsuario = $_POST['eleccionUsuario'];
    
        // Si la opción es cancelar 
        if($opcionUsuario == "Cancelar"){
        
            // nos vamos a la página del voluntario.
            header('Location: voluntario.php');
        
        // en caso contrario 
        }else{
        
            //Obtenemos los datos enviados por POST y los volcamos a variables
            $usuario = $_POST['usuario']; // Para el usuario
            $mensaje = $_POST['mensaje']; // Para el mensaje
            
            // Comprobamos si se ha pulsado el checkbox
            if (isset($_POST['privado'])){
                $privado = 1; // Para privado
                
            // en caso contrario le asignamos     
            }else{
                $privado = 0;
            }

            // Obtenemos la fecha del momento.
            $fecha = date('Y-m-d'); 

            //Si el login o el password esta vacío, mandamos un mensaje
            if (empty($mensaje)) {
                $error = "Debes introducir un mensaje";
        
            // en caso contrario    
            }else{
                
                // Introducimos el anuncio.
                $error = introducirAnuncio($usuario, $fecha, $mensaje, $privado);
            }    
        } 
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: Crear Anuncio</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>

    <body style='background: <?php echo $color; ?>'>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='login'>
            <form action='anuncio.php' method='post'>
                <fieldset>
                    <div><span>Crear Anuncio</span></div>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='usuario' >Usuario:</label><br/>
                        <input type='text' readonly name='usuario' id='usuario' value='<?php echo $_SESSION['usuario'] ?>' /><br/>
                    </div>
                    <div class='campo'>
                        <label for='fecha' >Fecha:</label><br/>
                        <input type='data' readonly name='fecha' id='fecha' value='<?php echo $_SESSION['fecha'] = date('d-m-Y')?>' /><br/>
                    </div>
                    <div class='campo'>
                        <label for='mensaje' >Mensaje:</label><br/>
                        <textarea type='text' name='mensaje' id='mensaje' maxlength="499" /></textarea><br/>
                    </div>
                    <div class='campo'>
                        <label for='privado' >¿Privado?</label><br/>
                        <input type='checkbox' name='privado' id='privado'  /><br/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='eleccionUsuario' value='Enviar' />
                        <input type='submit' name='eleccionUsuario' value='Cancelar' />
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

