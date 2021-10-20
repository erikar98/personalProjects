<?php

    
    //Validamos lo que llega por el metodo post desde el lateral.php
    if(isset($_POST['submit'])){

        //Conexion a la bd
        require_once 'includes/conexion.php';

        //Iniciar sesion
        if (!isset($_SESSION)) {
            session_start();
        }

        //Validacion de llenados de campos por POST
        $nombres = isset($_POST['nombres']) ? mysqli_real_escape_string($mysqli,$_POST['nombres']) : false;
        $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($mysqli,$_POST['apellidos']) : false;
        $email = isset($_POST['email']) ? mysqli_real_escape_string($mysqli,trim($_POST['email'])) : false;
        $password = isset($_POST['password']) ? mysqli_real_escape_string($mysqli,$_POST['password']) : false;
        //var_dump($_POST);

        //Arreglo de posibles errores
        $errores = array();

        //Validacion de que el campo nombres tenga los datos correctos
        if(!empty($nombres) && !is_numeric($nombres) && !preg_match("/[0-9]/", $nombres)){
            $nombres_validados = true;
        }else{
            $nombres_validados = false;
            $errores['nombres'] = "Nombres no válidos";
        }

        //Validacion de que el campo apellidos tenga los datos correctos
        if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
            $apellidos_validados = true;
        }else{
            $apellidos_validados = false;
            $errores['apellidos'] = "Apellidos no válidos";
        }

        //Validacion de que el campo email tenga los datos correctos
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_validados = true;
        }else{
            $email_validados = false;
            $errores['email'] = "Email no válido";
        }

        //Validacion de que el campo password tenga los datos correctos
        if(!empty($password)){
            $password_validados = true;
        }else{
            $nombres_validados = false;
            $errores['password'] = "Contraseña vacía";
        }

        //Guardar datos registrados 
        $guardar_usuario = false;

        //Validacion de existencia de errores para permitir o no guardar los datos
        if(count($errores)==0){

            $guardar_usuario = true;

            //cifrar la password
            $password_segura = password_hash($password, PASSWORD_BCRYPT, ['!cost' =>4]);

            //insertar usuario
            $strSQLinsert_t = "INSERT INTO usuarios VALUES(null,'" .$nombres ."','" .$apellidos. "','" .$email. "','".$password_segura."',curdate())";
            $streResultSQL_t = $mysqli->query($strSQLinsert_t);

            if($streResultSQL_t){
                $_SESSION['sqlResultados'] = "El registro se ha completado con exito";
            }else{
                $_SESSION['errores']['sql'] = mysqli_error($mysqli); 
            }
        }else {

            $_SESSION['errores'] = $errores;
        }

    }
    
    header('Location: index.php');