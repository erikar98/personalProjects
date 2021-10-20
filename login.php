<?php

// iniciar la sesion y conexion a la bd
require_once 'includes/conexion.php';

// Recoger datos del formulario
if (isset($_POST)) {

    // se borra el error antiguopara que no afecte la interfaz
    if (isset($_SESSION['error_login'])) {
        $borrado = session_unset();
    }

    // se reciben datos del formulario
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Consulta pra comprobar las credenciales
    $strSQLCredendiales = "SELECT * FROM usuarios WHERE email ='" .$email . "'";
    $streResultSQL_t = $mysqli->query($strSQLCredendiales);

    if ($streResultSQL_t && $streResultSQL_t->num_rows == 1) {

        $usuario = $streResultSQL_t->fetch_object();
        
        // Convertimos el objeto en un array.
        $datos = array();
        $datos['id'] = $usuario->id;
        $datos['nombre'] = $usuario->nombre;
        $datos['apellidos'] = $usuario->apellidos;
        $datos['email'] = $usuario->email;
        $datos['password'] = $usuario->password;
        $datos['fecha'] = $usuario->fecha;

        //var_dump($datos['password']);
        //die();
        
        // Comprobar la contraseña / cifrar
        $verificacion = password_verify($password, $datos['password']);
        
        if ($verificacion) {
            
            // Utilizar una sesion para guardar los datos del usuario logueado
            $_SESSION['usuario'] = $datos;
            //var_dump($_SESSION['usuario']['nombre']);
            //die();
            
        }else{
            
            // Si algo falla enviar una sesion con el fallo
            $_SESSION['error_login'] = "Usuario y/o contraseña inválida";
        }
        
    }else{
        // mensaje error
        $_SESSION['error_login'] = "Usuario y/o contraseña inválida";
    }

    

}
// Redirigir al index.php
header('Location: index.php');