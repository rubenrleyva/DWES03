<?php
/**
* @modulo      Desarrollo de aplicaciones Web Entorno Sevidor
* @Tema        Desarrollo de aplicaciones Web en PHP
* @Unidad      3
* @author      Rubén Ángel Rodriguez Leyva
*/

/**
 * Función encargada de crear la conexión con la base de datos.
 * 
 * @global PDO $con La conexión
 * @return \PDO Retorna la conexión
 */
function conexionBD(){
    
    $db_host = 'localhost';  // Para el host
    $db_name = 'voluntarios3';  //  El nombre de la BD
    $db_user = 'dwes';  //  El usuario de la BD
    $user_pw = 'dwes';  //  El password del usuario.
    
    try {
        
        // Hacemos global la variable de la conexión
        global $con;
        
        // Creamos la conexión con las variables declaradas anteriormente
        $con = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $user_pw);
        
        // Establecemos utf8
        $con->exec("set names utf8");
        
    // se capturan los mensajes de error    
    } catch (PDOException $e) { 
        die("<center><b><h3>Error: " .$e->getMessage()."</h3></b></center>"); 
    }
    
    // Retornamos la conexión
    return $con;
}


/**
 * Función encargada de desconectar de la base de datos.
 */
function desconectarBD(){
    
    unset($GLOBALS['con']);

}

/**
 * Función encargada de cerrar sesiones
 */
function cerrarSesion($usuario){
 
    // Según la consola de netbeans no hace falta.
    //session_start();
    
    // Eleminamos la sesión y borramos la cookie encargada del color
    session_unset();
    session_destroy();
    setcookie("color[$usuario]", time(), time()-3600);
    
    // Volvemos al index
    header("Location: index.php");
}



/**
 * Función encagarda del login del usuario.
 * 
 * @param type $usuario El usuario 
 * @param type $password La contraseña
 * @return string El mensaje de retorno en caso de error
 */
function login($usuario, $password){
    
    // Variable encargada de los diferentes errores.
    $error = "";
    
    try{    
        
        // Conectamos a la base de datos para comenzar las comprobaciones del usuario
        $con = conexionBD();
        
        // Creamos la consulta parametrizada para comprobar el usuario
        $sql = "SELECT login, password, bloqueado FROM anunciantes WHERE login=:login";

        // Preparamos la consulta
        $resultado = $con->prepare($sql);
        
        // Parametros de la consulta
        $resultado->bindParam(":login", $usuario);
        
        // Ejecutamos la consulta
        $resultado->execute();

        // Volcamos los resultados en un array
        $fila = $resultado->fetch();
      
        // Si no es NULL
        if($fila != NULL ){
        
            // Si existe y no esta bloqueado.
            if($fila['bloqueado'] != 1){

                if(password_verify($password, $fila['password'])){
                        
                    // Creamos la variable de usuario con el nombre del usuario
                    $_SESSION['usuario'] = $usuario;
            
                    // Redireccionamos a la página voluntario
                    header("Location: voluntario.php");
                    
                }else if(!isset($_SESSION['intentoUsuario'])){
                
                    // Indicamos que la contraseña no es válida
                    $error = "Contraseña no válida!";
                
                    // Asignamos el usuario que ha intentado el acceso
                    $_SESSION['intentoUsuario'] = $usuario;
                
                    // Añadimos un contador con uno
                    $_SESSION['contador'] = 1;
                
                }else if($_SESSION['intentoUsuario'] == $usuario && isset($_SESSION['intentoUsuario'])){
                
                    // Indicamos que la contraseña no es válida
                    $error = "Contraseña no válida!";
                
                    // Añadimos uno al contador
                    $_SESSION['contador']++;
                
                    // En caso de que el contador sea igual o mayor de 3 se bloquea el usuario.
                    if($_SESSION['contador'] >= 3){
                    
                        // Ponemos el contador a cero
                        $_SESSION['contador'] = 0;
                    
                        // Retornamos a la función que se encarga de bloquear al usuario.
                        return bloquearUsuario($usuario);
                    }
                }
        
            // en caso de encontrare bloqueado.
            }else{
                $error = "El usuario se encuentra bloqueado!";
            }
            
        // en caso de que no exista el usuario.       
        } else {
            $error = "No existe el usuario introducido!";
        }
    
    // Capturamos la posible excepción    
    }catch (PDOException $e){
        die("<center><b><h3>Error: " .$e->getMessage()."</h3></b></center>"); 
    }
    
    // Retornamos el error en caso de que exista.
    return $error;   
}

/**
 * Función encargada de bloquear al usuario.
 * 
 * @param type $usuario El usuario
 * @return type Retornamos que se ha bloqueado.
 */
function bloquearUsuario($usuario){
    
    try {
        
        // Conectamos con la base de datos
        $con = conexionBD();
    
        // Creamos la consulta parametrizada para comprobar actualizar el usuario
        $sql = "UPDATE anunciantes SET bloqueado = 1 WHERE login=:login";
    
        // Preparamos la consulta
        $resultado = $con->prepare($sql);
        
        // Parametro de la consulta
        $resultado->bindParam(":login", $usuario);
        
        // Ejecutamos la consulta
        $resultado->execute();
            
        // Retornamos un mensaje avisando de que se ha bloqueado al usuario.
        return $error = "Se ha bloqueado el usuario: $usuario!";
     
    // Capturamos la posible excepción     
    } catch (PDOException $ex) {
        die("<center><b><h3>Error: " .$ex->getMessage()."</h3></b></center>"); 
    }
}

/**
 * Función encargada de introducir los anuncios en la base de datos.
 * 
 * @param type $usuario
 * @param type $fecha
 * @param type $mensaje
 * @param type $privado
 * @return type
 */
function introducirAnuncio($usuario, $fecha, $mensaje, $privado){
      
    try{
        
        // Conectamos con la base de datos
        $con = conexionBD();

        // Creamos la consulta parametrizada para comprobar actualizar el usuario
        $sql = 'INSERT INTO anuncios (autor, contenido, fecha, privado) '
            . 'VALUES (:login, :mensaje, :fecha, :privado)';
    
        // Preparamos la consulta
        $resultado = $con->prepare($sql);
        
        // Parametro de la consulta
        $resultado->bindParam(":login", $usuario);
        $resultado->bindParam(":mensaje", $mensaje);
        $resultado->bindParam(":fecha", $fecha);
        $resultado->bindParam(":privado", $privado);
        
        // Ejecutamos la consulta
        $resultado->execute();
    
        // Retornamos hacia la página que deseamos.  
        return header('Location: tablon.php');
        
    } catch (PDOException $ex) {
        die("<center><b><h3>Error: " .$ex->getMessage()."</h3></b></center>"); 
    }    
}

/**
 * Función encargada de mostrar los anuncios.
 * 
 * @param type $invitado Le pasamos una variable booleana para saber si es un invitado.
 */
function mostrarAnuncios($invitado){
    
    try{
        // Contador de mensajes
        $numeroMensajes = 0;
    
        // Conectamos con la base de datos
        $con = conexionBD();
    
        // Creamos la consulta
        $sql = "SELECT autor, contenido, fecha, privado FROM anuncios";
    
        // Preparamos la consulta
        $resultado = $con->query($sql);
    
        // Si ha resultado
        if($resultado) {
        
            // Creamos un formulario por cada anuncio obtenido
            $row = $resultado->fetch();
            
            // Mientras row no sea null
            while ($row != null) {
                
                // Cambiamos el formato de la fecha.
                $fechaNormal = date("d-m-Y",strtotime($row['fecha']));
                
                // Si no es invitado
                if(!$invitado){
                    
                    // Mostramos los mensaje privados
                    if($row['privado'] == 1){
                        echo "<p ><form style='border: red 5px solid'>";
                        echo "Mensaje de: ${row['autor']}";
                        echo ", fecha: $fechaNormal<br>";
                        echo "Contenido: ${row['contenido']}<br> ";
                        echo "</form>";
                        echo "</p>";
                    }
                }
                
                // Mostramos los mensajes públicos
                if($row['privado'] == 0){                   
                    echo "<p ><form style='border: blue 5px solid'>";
                    echo "Mensaje de: ${row['autor']}";
                    echo ", fecha: $fechaNormal<br>";
                    echo "Contenido: ${row['contenido']}<br> ";
                    echo "</form>";
                    echo "</p>";
                }
                
                
                $row = $resultado->fetch();
                
                // Aumentamos la variable de número de mensajes.
                $numeroMensajes++;
            }  
        }
    
        // En caso de que la variable numeroMensajes sea menor de uno avisamos .    
        if($numeroMensajes < 1){
            echo "<center><b><h2>Tablón vacío, no existen mensajes!</h2></b></center>";   
        }
        
    // Capturamos las posibles excepciones    
    } catch (PDOException $ex) {
        die("<center><b><h3>Error: " .$ex->getMessage()."</h3></b></center>"); 
    }
    
}

/**
 * Función encargada de crear el nuevo usuario.
 * 
 * @param type $usuario El usuario.
 * @param type $password El password del usuario.
 * @param type $email El email del usuario.
 * @return type El retorno hacia la página de voluntario.
 */
function nuevoUsuario($usuario, $password, $email){
    
    // Usamos la función crypt para convertir el password
    $hash = crypt($password);
    
    // Conectamos con la base de datos
    $con = conexionBD();
    
    // Creamos la consulta parametrizada para comprobar actualizar el usuario
    $sql = 'INSERT INTO anunciantes (login, password, email, bloqueado) '
            . 'VALUES (:login, :password, :email, 1)';
    
    // Preparamos la consulta
    $resultado = $con->prepare($sql);
        
    // Parametro de la consulta
    $resultado->bindParam(":login", $usuario);
    $resultado->bindParam(":password", $hash);
    $resultado->bindParam(":email", $email);
        
    // Ejecutamos la consulta
    $resultado->execute();
    
    // Recuperamos la información de la sesión
    //session_start();
    
    // Le pasamos a la sesión el usuario.
    $_SESSION['usuario'] = $usuario;
    
    // Retornamos hacia la página que deseamos.  
    return header('Location: voluntario.php');
      
}

/**
 * Función que comprueba los datos para el registro de usuario.
 * 
 * @param type $usuario El login del usuario
 * @param type $password El password del usuario
 * @param type $passwordRepe El password de verificación
 * @param type $email El email del usuario
 * @return string El retorno en caso de error.
 */
function comprobarDatos($usuario, $password, $passwordRepe, $email){
    
    $error = "";
    
   // si el login mandamos un mensaje
    if (empty($usuario)) {
        $error .="Debes introducir un login para el usuario!<br>";
        
    // si el password está vacío mandamos un mensaje    
    }else if(empty($password)){
        $error .="Debes introducir un password para el usuario!<br>";
        
    // si la repetición del password está vacía.    
    }else if(empty($passwordRepe)){
        $error .="Debes introducir de nuevo el password para el usuario!<br>";
        
    // si la repetición del password no se encuentra vacía
    }else if(!empty($passwordRepe)){
        
        // comprobamos si no son iguales.
        if($password != $passwordRepe){
            $error .="Ambos password deben ser iguales!<br>";
            
        // en caso de que lo sean comprobamos si el email se encuentra vacío.   
        }else if(empty($email)){
            $error .="Debes introducir un email para el usuario!<br>";
            
        // en caso contrasio    
        }else{

            // Comprobamos que no existe el usuario en la base de datos mediante
            // consulta.
            try{    
        
                // Conectamos a la base de datos para comenzar las comprobaciones del usuario
                $con = conexionBD();
        
                // Creamos la consulta parametrizada para comprobar el usuario
                $sql = "SELECT login FROM anunciantes WHERE login=:login";

                // Preparamos la consulta
                $resultado = $con->prepare($sql);
        
                // Parametros de la consulta
                $resultado->bindParam(":login", $usuario);
        
                // Ejecutamos la consulta
                $resultado->execute();

                // Volcamos los resultados en un array
                $fila = $resultado->fetch();
      
                // Si no es NULL
                if($fila != NULL ){
                    
                    // avisamos de que el usuario ya existe.
                    $error .="El login de usuario ya existe!<br>";        
                
                // en caso contrario llamamos a la función pasándole los 
                // argumentos necesarios.    
                }else{
                    nuevoUsuario($usuario, $password, $email);
                }
                
            // capturamos las excepciones en caso de que se produzcan.    
            }catch (PDOException $e){
                die("<center><b><h3>Error: " .$e->getMessage()."</h3></b></center>"); 
            }
        } 
    }
    // Retornamos el error si lo hay.       
    return $error;
}

/**
 * Función encargada de la cookie
 * 
 * @param type $colorFondo El color de fondo para la cookie
 * @param type $usuario El usuario
 */
function usoCookie($colorFondo, $usuario){
    
    // Variable encargada del error
    $error = "";
    
    // Si el 
    if($colorFondo != NULL){
        setcookie("color[$usuario]", $colorFondo, time() + 365 * 24 * 60 * 60);
        $error .= "Se ha cambiado el color del fondo pulsa volver para comprobar "
                . "los cambios!";
    }else{
        setcookie("color[$usuario]", time(), time()-3600);
        $error .= "Se ha borrado ha restablecido el color borrando la cookie"
                . " ,pulsa volver para comprobar!";
    }
    
    return $error;
}

/**
 * Función creada para la cabecera de la web.
 * 
 * @param type $titulo le pasamos el texto que deseamos que aparezca.
 */
function cabecera($titulo){
    echo "<center><b><h2>$titulo</h2></b></center>"; // Muestra el mensaje de cabecera.
}

/**
 * Función creada para el pie de la página web.
 * 
 * @param type $nombreTarea le pasamos el nombre de la tarea.
 */
function pie($nombreTarea){
        
    //Muestra el mensaje del pie
    echo "<br/>";
    echo "<center><small>Rubén Ángel Rodriguez Leyva</br> 
          <center><small>$nombreTarea</br>
          </body>
          </html>";
    exit; 
}