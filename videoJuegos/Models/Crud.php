<?php
require "Conexion.php";


class Crud extends Conexion
{

    public function registroUserModel($datosModel, $tabla)
    {
        $stmt = Conexion::connection()->prepare("INSERT INTO usuario(nombre, apellido_paterno, 
        apellido_materno, fecha_nacimiento, correo, contraseña_cuenta, nacionalidad,nivel_usuario) 
        VALUE (:nombreUser,:paterno,:materno,:fechaNac,:email,:pass,:nacion,:nivelUser)");
        // $stmt->bindParam(':id', $_POST['numUser'], PDO::PARAM_INT);
        $stmt->bindParam(':nombreUser', $datosModel["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(':paterno', $datosModel["apellidoP"], PDO::PARAM_STR);
        $stmt->bindParam(':materno', $datosModel["apellidoM"], PDO::PARAM_STR);
        $stmt->bindParam(':fechaNac', $datosModel["nacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(':email', $datosModel["email"], PDO::PARAM_STR);
        $stmt->bindParam(':pass', $datosModel["pass"], PDO::PARAM_STR);
        $stmt->bindParam(':nacion', $datosModel["nacion"], PDO::PARAM_STR);
        $stmt->bindParam(':nivelUser', $datosModel["nivelUser"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            // $message = 'Usuario creado satisfactoriamente';
            return "success";
        } else {
            //$message = 'Error en el registro, intente de neuvo';
            return "error";
        }
    }


    public function login($tabla, $datosModel)
    {
        $stmt = Conexion::connection()->prepare("Select idUsuario,correo,contraseña_cuenta,nivel_usuario FROM usuario where idUsuario=:idUSer");
        $stmt->bindParam(':idUser', $datosModel, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Metodo para actualizar perfil del Usuario
    public function actualizar($tabla, $datosModel)
    {
        $stmt = Conexion::connection()->prepare("UPDATE $tabla SET apellido_paterno=:paterno,apellido_materno=:materno,correo=:email,contraseña_cuenta=:pass where idUsuario=:idUser");
        $stmt->bindParam(":paterno", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":materno", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":pass", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":idUser", $datosModel[''], PDO::PARAM_STR);
        if ($stmt->execute()) {
            #  return  $stmt->fetchAll(PDO::FETCH_ASSOC);
            # var_dump($stmt->fetchAl(PDO::PARAM_STR));
            return "success";
        } else {
            return "error";
        }

        $stmt->close();
    }

    public function updateVideojuegos($tabla, $datosModel)
    {
        $stmt = Conexion::connection()->prepare("UPDATE videojuego SET nombreVideojuego=:nombrV,clasificacion=:clasV,fechaLanzamiento=:fechaL,genero=:Genere,
 precio=:price
where idUsuario=:idUser");
        $stmt->bindParam(":nombrV", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":clasV", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":fechaL", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":Genere", $datosModel[''], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datosModel[''], PDO::PARAM_STR);
        if ($stmt->execute()) {
            #  return  $stmt->fetchAll(PDO::FETCH_ASSOC);
            # var_dump($stmt->fetchAl(PDO::PARAM_STR));
            return "success";
        } else {
            return "error";
        }
    }

}