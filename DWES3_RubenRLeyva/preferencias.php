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

    // Color por defecto
    $color="white";

    $error = "";

    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario'])) {
        die("Error - debe <a href='login.php'>identificarse</a>.<br />");
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


    // Comprobamos si ya se ha enviado el formulario
    if (isset($_POST['enviar'])) {
    
        //Obtenemos los datos enviados por POST y los volcamos a variables
        $opcion = $_POST['enviar'];

        //Si es la opción ingresar
        if ($opcion == "Guardar") {
        
            //Obtenemos los datos enviados por POST y los volcamos a variables
            $colorFondo = $_POST['color'];
            
            $error = usoCookie($colorFondo, $_SESSION['usuario']);
        
        // si es la opción de invitado
        }else if ($opcion == "Eliminar"){
            
            $colorFondo = "";
            
            $error = usoCookie($colorFondo, $_SESSION['usuario']);
    
        // si es la opción registrarse
        }else if ($opcion == "Volver"){
            
            header('Location: voluntario.php');
    
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 3: Preferencias usuario</title>
        <link href="tablon.css" rel="stylesheet" type="text/css">
    </head>

    <body style='background: <?php echo $color; ?>'>
        
        <?php
        
        // Función que contiene la cabecera web (espero mejorarla con el tiempo).
        cabecera("Unidad 3 - Desarrollo de aplicaciones Web en PHP");
        
        ?>
        
        <div id='preferencias'>
            <form action='preferencias.php' method='post'>
                <fieldset >
                    <div><span>Preferencias de color para el usuario <?php echo $_SESSION['usuario'] ?></span></div><br>
                    <div><span class='error'><?php echo $error; ?></span></div>
                    <div class='campo'>
                        <label for='color' >Color: </label>
                        <input type='color' name='color' id='color'  value='<?php echo $color; ?>' /><br/>
                    </div>
                    <div class='campo'>
                        <input type='submit' name='enviar' value='Guardar' />
                        <input type='submit' name='enviar' value='Eliminar' />
                        <input type='submit' name='enviar' value='Volver' />
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





