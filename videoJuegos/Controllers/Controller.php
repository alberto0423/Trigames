<?php


class MvcController
{

    # Este metodo registra a los usuarios
    public function registroUserController()
    {

        if (isset($_POST["nameUser"])) {
            $datos = array(
                "nombre" => $_POST["nameUser"],
                "apellidoP" => $_POST["ap_paterno"],
                "apellidoM" => $_POST["ap_materno"],
                "nacimiento" => $_POST["fechaNac"],
                "email" => $_POST["email"],
                "pass" => $_POST["password"],
                "nacion" => $_POST["nacionalidad"],
                "nivelUser"=>$_POST["nivelUser"]);
         //   var_dump($datos);
            $respuesta = Crud::registroUserModel($datos,"usuario");
            echo $respuesta;

        }
    }

    public function updateProfile($arregloInfo)
    {
        if (isset($_POST['numUserProfile'])) {
            $datosController = array(
                "idUser" => $_POST['numUserProfile'],
                "mailUser" => $_POST['emailProfile'],
                "newPass" => $_POST['newPass'],
                "confirmPass" => $_POST['confirmPass'],
                "curpUserProfile" => $_POST["curpUserProfile"]);
            $respuesta = Crud::updateProfile($datosController, "APSISISTEMAS.dbo.empleados");
            #  var_dump($datosController["actualPass"]);
            # $dataUser = Crud::consultaUsuario($datosController, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
            if ($datosController["idUser"] === $arregloInfo[0] and $datosController["curpUserProfile"] === $arregloInfo[5]) {
                if ($respuesta == "success") {
                    header("location: principal.php");
                } else {
                    echo "error";
                }

                echo 'Bien hecho';
            } else {
                echo 'Error';
            }

        }

    }

    /*
    public function changaPassProfile()
    {
        if (isset($_POST['numUserProfile'])) {
            $datosController = array(
                "idUser" => $_POST['numUserProfile'],
                "mailUser" => $_POST['emailProfile'],
                "newPass" => $_POST['newPass'],
                "confirmPass" => $_POST['confirmPass'],
                "curpUserProfile" => $_POST["curpUserProfile"]);
            $respuesta = Crud::updateProfile($datosController, "APSISISTEMAS.dbo.empleados");
            #  var_dump($datosController["actualPass"]);
            #$dataUser = Crud::consultaUsuario($datosController, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
            if ($datosController["newPass"] === $datosController['confirmPass']) {
                var_dump($datosController["newPass"]);

                #echo 'Bien hecho';
            } else {
                #echo 'Error';
            }

        }
    }

    */

    /*
        public function actualizar($dataUser)
        {
            $dataUser = Crud::editarUsuario($dataUser, "APSISISTEMAS.dbo.empleados");
            $arregloData = array(
                1 => $dataUser[0],
                2 => $dataUser[1],
                3 => $dataUser[2],

            );

            return $arregloData;
        }
    */

    # Este metodo permite ingresar a los usuarios previamente registrados
    public function ingresoUserController()
    {

        if (isset($_POST['emailUser'])) {
            #preg_match =   realiza una comparacion con una expresion regular
            if (preg_match('/^[0-9]*$/', $_POST['emailUser']) && preg_match('/^[A-Z0-9]*$/', $_POST['passwordAccess'])) {
                $datosController = array('numUser' => $_POST['numUser'], 'password' => $_POST['passwordAccess']);
                $respuesta = Crud::ingresoUsuario($datosController, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');


                $infoUser = array(
                    1 => $respuesta['nombre'],
                    2 => $respuesta['ap_paterno'],
                    3 => $respuesta['ap_materno'],
                    4 => $respuesta['emEmp'],
                    5 => $respuesta['NumEmp'],
                    6 => $respuesta['curp'],
                    7 => $respuesta['rfcalfa'] . $respuesta['rfcnum'],
                    8 => intval($respuesta['dias_ant']),
                    9 => $respuesta['sexo'],
                    10 => $respuesta['password_empleado'],
                    11 => $respuesta['mail'],
                    12 => $respuesta['nombre_empresa'],
                    13 => $respuesta['AltaUser'],
                    14 => $respuesta['disfrute'],
                    15 => $respuesta['vence'],
                    16 => $respuesta['pagada'],
                    17 => $respuesta['dias_disfr'],
                    18 => $respuesta['activo'],
                    19 => $respuesta['credencial']);
                # print_r(json_encode($respuesta));
                $_SESSION['user'] = $infoUser[5];
                $_SESSION['tipo_usuario'] = $infoUser[19];
                /*
                if ($datosController['numUser'] === $infoUser[5]){
                    echo 'El usuario es correcto';
                }else{
                    echo 'El usuario es incorrecto';
                }
                echo "<br>";
                if ($datosController['password'] === $infoUser[7]){
                    echo 'La contraseña es correcta';
                }else{
                    echo 'La contraseña es incorrecta';
                }
                */
                #   var_dump($infoUser[5]);
                if ($infoUser[5] === $datosController['numUser'] && $infoUser[7] === $datosController['password'] && $infoUser[18] === 'S') {
                    header('Location: principal.php');
                } else {
                    return 1;
                }


            } else {

            }


        }


    }


    public function validacionDashBoard($dataUser)
    {
        $dataUser = Crud::consultaUsuario($dataUser, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
        $arregloData = array(
            0 => $dataUser['NumEmp'],
            1 => $dataUser['nombre'],
            2 => $dataUser['ap_paterno'],
            3 => $dataUser['ap_materno'],
            4 => $dataUser['emEmp'],
            5 => $dataUser['curp'],
            6 => $dataUser['AltaUser'],
            7 => $dataUser['rfcalfa'],
            8 => $dataUser['rfcnum'],
            9 => $dataUser['sexo'],
            10 => $dataUser['password_empleado'],
            11 => $dataUser['mail'],
            12 => $dataUser['nombre_empresa'],
            13 => $dataUser['activo'],
            14 => $dataUser['credencial']
        );
        #var_dump($arregloData);
        return $arregloData;
    }


    public function infoPerfilUser($infoUser)
    {
        $infoUser = Crud::infoUser($infoUser, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
        $arregloInfo = array(
            0 => $infoUser['NumEmp'],
            1 => $infoUser['nombre'],
            2 => $infoUser['ap_paterno'],
            3 => $infoUser['ap_materno'],
            4 => $infoUser['emEmp'],
            5 => $infoUser['curp'],
            6 => $infoUser['AltaUser'],
            7 => $infoUser['rfcalfa'] . $infoUser['rfcnum'],
            8 => $infoUser['rfcnum'],
            9 => $infoUser['sexo'],
            10 => $infoUser['password_empleado'],
            11 => $infoUser['mail'],
            12 => $infoUser['nombre_empresa'],
            13 => $infoUser['activo'],
            14 => $infoUser['credencial']
        );

        return $arregloInfo;
    }

    public function infoUserVacations($infoUserVac)
    {
        $infoUserVac = Crud::infoUserVacations($infoUserVac, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
        $arrInfoVacations = array(
            0 => $infoUserVac['NumEmp'],
            1 => $infoUserVac['nombre'],
            2 => $infoUserVac['ap_paterno'],
            3 => $infoUserVac['ap_materno'],
            4 => $infoUserVac['emEmp'],
            5 => $infoUserVac['curp'],
            6 => $infoUserVac['AltaUser'],
            7 => $infoUserVac['rfcalfa'] . $infoUserVac['rfcnum'],
            8 => $infoUserVac['rfcnum'],
            9 => $infoUserVac['sexo'],
            10 => $infoUserVac['password_empleado'],
            11 => $infoUserVac['mail'],
            12 => $infoUserVac['nombre_empresa'],
            13 => $infoUserVac['activo'],
            14 => $infoUserVac['credencial'],
            15 => intval($infoUserVac['dias_ant'])
        );
        return $arrInfoVacations;
    }

    /*
    public function infoUser($validateInfoUser)
    {
        // $datosController    =   array('numeroEmpleado'=>$_POST['numeroEmpleado']);
        $dataController = $validateInfoUser;
        $respuesta = Crud::infoUser($dataController, 'APSISISTEMAS.dbo.empleados');
        foreach ($respuesta as $row => $item) {
            echo '<tr>
                        <td>' . $item['codigo'] . '</td>
                        <td>' . $item['nombre'] . '</td>
                        <td>' . $item['ap_paterno'] . '</td>
                        <td>' . $item['ap_materno'] . '</td>
                        <td>' . $item['fchalta'] . '</td>
                        <td>' . $item['curp'] . '</td>

                     </tr>';
        }
    }
    */

    public function changePass()
    {
        $email = new PHPMailer\PHPMailer\PHPMailer();
        $dataUser = NAN;
        if (isset($_POST['recoverEmail'])) {
            $datosController = array('recoverNumEmp' => $_POST['recoverNumEmp'], 'recoverEmail' => $_POST['recoverEmail']);
            $request = Crud::infoUserRecoverPass($datosController, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
            # var_dump($datosController);
            # var_dump( $request);
            $body = "Hemos recibido una notifiación para poder restaurar tu contraseña";

            //Configuración básica para uso y salida de correos.


            $dataUser = array(
                1 => $request['NumEmp'],
                2 => $request['nombre'],
                3 => $request['ap_paterno'],
                4 => $request['ap_materno'],
                5 => $request['emEmp'],
                6 => $request['curp'],
                7 => $request['AltaUser'],
                8 => $request['rfcalfa'],
                9 => $request['rfcnum'],
                10 => $request['mail'],
                11 => $request['password_empleado'],
                12 => $request['activo']);

            if ($datosController['recoverNumEmp'] === $dataUser[1] && $dataUser[12] === 'S') {
                if ($datosController['recoverEmail'] === $dataUser[10]) {
                    #var_dump($dataUser[12]);
                    $emailService = 'jorge_alberto.lucio@lactalis.com.mx';
                    $email->isSMTP();
                    $email->SMTPDebug = 0;
                    $email->SMTPAuth = true;
                    $email->SMTPSecure = 'ssl';
                    $email->SMTPAutoTLS = true;

                    $email->Host = "imap.gmail.com";
                    $email->Port = 465;
                    $email->Username = 'jorge_alberto.lucio@lactalis.com.mx';
                    $email->Password = 'LACTALIS.123';
                    $email->Timeout = 30;
                    $email->Subject = "Restauración de contraseña";
                    $email->setFrom('jorge_alberto.lucio@lactalis.com.mx', 'IT Services');
                    $email->addReplyTo($emailService, $dataUser[2]);
                    $email->addAddress($datosController['recoverEmail'], 'IT Services');
                    $email->addAddress($emailService);
                    $email->Body = "Hola " . $dataUser['2'] . " hemos detectado que deseas reestablecer tu contraseña,a continuación te adjuntamos tu contraseña: " . $dataUser[8] . $dataUser[9];
                    $email->AltBody = 'Hola';
                    $email->CharSet = 'UTF-8';
                    $email->Timeout = 800;
                    $email->WordWrap = 80;
                    $email->isHTML(true);
                    try {

                        if ($email->send()) {
                            echo 'Hemos enviado un correo con tu contraseña';
                        } else {
                            echo 'Error al tratar de recuperar tu contraseña:' . $email->ErrorInfo;
                        }
                    } catch (\PHPMailer\PHPMailer\Exception $e) {
                        $e->errorMessage();
                    }
                } else {
                    echo 'El correo ingresado no coincide con el que está registrado';

                }

                #  echo 'El número de empleado coincide' . ' ' . $dataUser[2];
            } else {
                echo 'Su número de empleado no coincide o está inactivo';
            }


        }
        return $dataUser;
    }


    /*
     * Este metodo suma los DIAS ingresados por el usuario.
     * Se los suma a la fecha que sólo el usuario escoge
     */
    /*
    public function addDays()
    {
        $datosController = array('numeroEmpleado' => $_POST['numeroEmpelado'], 'Desde' => $_POST['Desde'], 'sol' => $_POST['sol'], 'Hasta' => $_POST['Hasta']);
        $fechaDesde = $datosController['Desde'];
        $diasSolicitados = $datosController['sol'];
        $desde = new DateTime($fechaDesde);
        $desde->add(new DateInterval('P' . $diasSolicitados . 'D'));
        $newDate = $desde->format('d/m/Y');
        return $newDate;
    }
*/
    public function giveRequest($datosUserVac)
    {
        if (isset($_POST['numeroEmpelado'])) {
            $datosControllerVac = array(
                'numeroEmpleado' => $_POST['numeroEmpelado'],
                'hasta' => $_POST['Hasta'],
                'Desde' => $_POST['Desde'],
                'sol' => $_POST['sol']);

            if ($datosUserVac[0] === $datosControllerVac['numeroEmpleado']) {
                $desde = new DateTime($datosControllerVac["Desde"]);
                $hasta = new DateTime($datosControllerVac["hasta"]);
                var_dump($datosControllerVac['sol']);

                $desde->add(new DateInterval('P' . intval($datosControllerVac['sol']) . 'D'));
                $interval = $desde->diff($hasta);
                var_dump($interval['y']);
                echo 'tú numero de usuario es correcto';
            } else {
                echo 'Tu número de usuaro es incorrecto';
            }
        }
    }

    public function validateVacationsController($request)
    {
    }


    public function solicitud($dataUser)
    {
        if (isset($_POST['numeroEmpelado'])) {
            $datosControllerVac = array(
                'numeroEmpleado' => $_POST['numeroEmpelado'],
                'hasta' => $_POST['Hasta'],
                'Desde' => $_POST['Desde'],
                'sol' => $_POST['sol']);
            $respuestaVac = Crud::validarPeriodos($datosControllerVac, 'APSISISTEMAS.dbo.empleados', 'APSISISTEMAS.dbo.empresas', 'APSISISTEMAS.dbo.vacaciones');
            //Estas varibales almacenan lo coentenido en el Array $datosController();
            $numEmpL = $datosControllerVac['numeroEmpleado'];
            $fechaDesde = $datosControllerVac['Desde'];
            $fechaHasta = $datosControllerVac['hasta'];
            $diasSolicitados = $datosControllerVac['sol'];

            //Aquí se calculan la diferencias de años,meses o días que le usuario solicita
            $desde = new DateTime($fechaDesde);  //Fecha 1, esta fecha la elige el usuario en el formulario
            $hasta = new DateTime($fechaHasta);


            $newDate = new DateTime();
            # $hasta =    new DateTime($fechaHasta);
            $desde->add(new DateInterval('P' . $diasSolicitados . 'D'));

            # $hasta = $desde->format('Y-m-d');   // Nueva fecha generado con los días ingresados por el usuario.
            # var_dump($hasta);
            #$dateFormat =   new DateTime($hasta);
            # var_dump($dateFormat);
            #$newDateFormat  =   date_diff($desde,$dateFormat);

            $interval = $desde->diff($hasta);
            # var_dump($newDateFormat);


            $woweekends = 0;
            for ($i = 0; $i < $interval->d; $i++) {
                $modif = $desde->modify('+1 day');
                $weekday = $desde->format('w');
                if ($weekday != 0 && $weekday != 6) {
                    $woweekends++;
                }
            }
            echo $woweekends . 'dias por disfrutar';


            /*
        $hasta =    new DateTime($fechaHasta);
        $interval   =   $desde->diff($hasta);
        $Year       =   intval($interval->format('%y'));
        $Months     =   intval($interval->format('%m'));
        $Days       =   intval($interval->format('%d'));
*/

#            $fecha  =   date('Y-m-j');
            #           $nuevaFecha =   strtotime('+'.intval($_SESSION['user'][20]).'day', strtotime($fecha));
            #           $nuevaFecha =date('Y-m-j', $nuevaFecha);
            #    print_r($nuevaFecha);
            /*
                                    //Este if valida el año actual y el else valida la diferencia de años,meses y dias
                                    if($Year    !=  0){
                                        $ago    =   $Year. 'Años atrás';
                                    }else{
                                        $ago        =   ($Months    ==  0 ? $Days.' días atrás ': $Months. ' Meses atrás');
                                        $convert    =   (int)$Days;
                                    }
                                    echo 'Usted a seleccionado '. $Days . ' por disfrutar';
                                    $newDay =   $diasPendientesBD-$Days;
                                    echo '</br>';
                                    echo  'Su nuevo valance es de '.$newDay. ' pendientes' ;
                        $Days       =   $interval->format('%d');
            */
            //Este if valida el año actual y el else valida la diferencia de años,meses y dias
            /*
            if($Year    !=  0){
                $ago    =   $Year. 'Años atrás';
            }else{
                $ago        =   ($Months    ==  0 ? $Days.' días atrás ': $Months. ' Meses atrás');
                $convert    =   (int)$Days;
            }
            */
            $infoSolicitud = array(
                1 => $respuestaVac['nombre'],
                2 => $respuestaVac['ap_paterno'],
                3 => $respuestaVac['ap_materno'],
                4 => $respuestaVac['NumEmp'],
                5 => $respuestaVac['nombre_empresa'],
                6 => $respuestaVac['curp'],
                7 => $respuestaVac['rfcalfa'] . $respuestaVac['rfcnum'],
                8 => intval($respuestaVac['dias_ant']),
                9 => $respuestaVac['sexo'],
                10 => $respuestaVac['password_empleado'],
                11 => $respuestaVac['mail'],
                12 => $respuestaVac['nombre_empresa'],
                13 => $respuestaVac['AltaUser'],
                14 => $respuestaVac['disfrute'],
                15 => $respuestaVac['vence'],
                16 => $respuestaVac['pagada'],
                17 => $respuestaVac['dias_disfr'],
                18 => $datosControllerVac['sol'],
                19 => $datosControllerVac['Desde'],
                20 => $datosControllerVac['hasta']);
            $_SESSION['user'] = $infoSolicitud;

            /*
            $infoUser   =   array(1=>$respuesta['nombre'],
                2=>$respuesta['ap_paterno'],
                3=>$respuesta['ap_materno'],
                4=>$respuesta['NumEmp'],
                5=>$respuesta['emEmp'],
                6=>$respuesta['curp'],
                7=>$respuesta['AltaUser'],
                8=>$respuesta['rfcalfa'].$respuesta['rfcnum'],
                9=>$respuesta['sexo'],
                10=>$respuesta['password_empleado'],
                11=>$respuesta['mail'],
                12=>$respuesta['nombre_empresa'],
                13=>$respuesta['dias_ant']);
            */
            // Este if verifica si coincide el númerpo de empleado
            if ($dataUser[0] != $numEmpL) {
                // header('Location: principal.php');
                echo 'Su numero no coincide';
                echo '<br>';
                echo "<script type='text/javascript'> window.location.href    =   'misVacaciones.php' </script>";

            } else {
                // Este if verifica si tiene el usuario tiene dias pendientes
                if ($infoSolicitud[8] != 0) {
                    //$this->verificarDias();
                    if (intval($datosControllerVac['sol']) > intval($infoSolicitud[8])) {
                        echo 'Lo sentimos, no puedes tomar más días de los permitidos';
                    } else {
                        #     var_dump(intval($infoSolicitud[21]));
                        #echo "<script type='text/javascript'> window.location.href    =   'Controllers/pruebaPDF.php' </script>";
                    }
                    #echo "<script type='text/javascript'> window.location.href    =   'Controllers/pruebaPDF.php' </script>";
                } else {
                    echo 'Usted no tiene días pendientes y no puede hacer ninguna solicitud';
                }
            }
        }
    }


    public function validarUser($validateUser)
    {
        $datosController = $validateUser;
        $respuesta = Crud::validarUser($datosController['User'], "APSISISTEMAS.dbo.empleados");
        # var_dump($respuesta['codigo']);

        $request = array(
            1 => $respuesta['codigo'],
            2 => $respuesta['empresa'],
            3 => $respuesta['nombre'],
            4 => $respuesta['ap_paterno'],
            5 => $respuesta['ap_materno'],
            6 => $respuesta['curp'],
            7 => $respuesta['fchalta'],
            8 => $respuesta['rfcalfa'] . $respuesta['rfcnum'],
            9 => $respuesta['rfcnum'],
            10 => $respuesta['rfchomo'],
            11 => $respuesta['activo'],
            12 => $respuesta['password_empleado'],
            13 => $respuesta['mail'],
            14 => $respuesta['credencial']);


        if ($request[1] === $datosController['User'] and $request[8] === $datosController['pass']) {
            echo 0;
        } else {
            echo 1;
        }


    }

    public function validarVacations($validarLogin)
    {
        $datosController = $validarLogin;
        $respuesta = Crud::validateVacations($datosController['User'], "APSISISTEMAS.dbo.vacaciones");
        /*
        var_dump($respuesta['codigo']);
        var_dump($respuesta['rfcalfa']);
        var_dump($respuesta['rfcnum']);
        */
        // var_dump($datosController['User']);
        if ($datosController['User'] === $respuesta['codigo']) {
            if ($respuesta['dias_ant'] != 0) {
                if ($datosController['Dias'] < $respuesta['dias_ant']) {
                    echo 0;
                } else {
                }
            } else {
            }

        } else {
            echo 1;
        }


    }

    public function valdiatePass($validateData)
    {
        $datosController = $validateData;
        $respuesta = Crud::validatePass();
    }


    public function loadList()
    {
        #$datosController = $item;
        $respuesta = Crud::cargarSolicitudes("APSISISTEMAS.dbo.solicitud_vacaciones");

        foreach ($respuesta as $row => $item) {
            echo '
<br>
<table class="table table-hover table-light">
    <tbody>
<tr>
    <td>' . $item['Empresa'] . '</td>
    <td>' . $item['Codigo'] . '</td>
    <td>' . $item['Disfrute'] . '</td>
    <td>' . $item['Fin_Disfrute'] . '</td>
    <td>' . $item['Dias_Autoriza'] . '</td>
    <td>' . $item['Estatus'] . '</td>
    <td>' . $item['Motivo'] . '</td>
    <td>' . $item['Fecha_Real'] . '</td>
    <td>' . $item['Cerrada'] . '</td>
    <td>' . $item['CausaVacaciones'] . '</td>
    <td><a href="partials/registerUser.php"><button class="btn-warning">Editar</button></a></td>
    <td><a href="misSolicitudes.php"><button class="btn-danger">Borrar</button></a></td>
    <td><a href="principal.php"><button class="btn-dark">Regresar</button></a></td>
</tr>
   </tbody>
      </table>';
        }

    }

    #var_dump($respuesta);

    /*
        public function verificarDias()
        {
            $datosControllerVac = array('numeroEmpleado' => $_POST['numeroEmpelado'], 'Desde' => $_POST['Desde'], 'Hasta' => $_POST['Hasta'], 'sol' => $_POST['sol']);
            $respuestaVac = Crud::validarPeriodos($datosControllerVac, 'APSISISTEMAS.dbo.vacaciones');
            $infoUserVac = array(1 => $datosControllerVac['Desde'],
                2 => $datosControllerVac['Hasta'],
                3 => $datosControllerVac['sol'], 4 => $respuestaVac['dias_ant']);

            $desde = new DateTime($infoUserVac[1]);
            $hasta = new DateTime($infoUserVac[2]);
            $interval = $desde->diff($hasta);
            $Year = $interval->format('%y');
            $Months = $interval->format('%m');
            $Days = $interval->format('%d');
            // return $Days;
            if ($infoUserVac[2] < $infoUserVac[1]) {
                echo 'La fecha de salida no debe ser menor que la fecha de entrada';
            } else {
                $result = $infoUserVac[4] - $Days;
                echo $result;
            }

        }
    */

    /*
        public function peticion()
        {
            if (!empty($_POST['diasSol'])) {
                $datosController = array('nombreEmpleado' => $_POST['nombreEmpleado'], 'apellidos' => $_POST['apellidos'],
                    'diasSol' => $_POST['diasSol'], 'fechaDesde' => $_POST['fechaDesde'], 'fechaHasta' => $_POST['fechaHasta'],
                    'volver' => $_POST['volver']);
                $respuesta = Crud::procesoVac($datosController, 'APSISISTEMAS.dbo.solicitud_vacaciones');
                //Asignacion se variables desde el array $datosCOntroller();
                $nameUSer = $datosController['nombreEmpleado'];
                $lastName = $datosController['apellidos'];
                $daySol = $datosController['diasSol'];
                $dateFro = $datosController['fechaDesde'];
                $dateTo = $datosController['fechaHasta'];
                $back = $datosController['volver'];

                echo $nameUSer;
                echo '</br>';
                echo $lastName;
                echo '</br>';
                echo $daySol;
                echo '</br>';
                echo $dateFro;
                $yaer = null;

            }
        }
    */


    /*
    public function validarNumUser($validarNumUser)
    {
        $datosController = $validarNumUser;
        $respuesta = Crud::validarNumUser($datosController, 'APSISISTEMAS.dbo.vacaciones');
        if (count($respuesta['codigo']) > 0) {
            echo 'Usted tien datos';
            return 0;

        } else {
            echo 'Usted no tiene datos';
            return 1;
        }
    }
    */

    /*
    public function sendMail()
    {
        if (!empty($_POST['correo'])) {
            $fieldUser = array(1 => $_POST['correo']);
            $sendMail = new sendMail();
            $sendMail->enviarMail();
            echo $fieldUser[1];
        } else {
            #echo 'Error, el campo no debe estar vacio';
        }

    }
    */


    public function loadPhoto()
    {
        //Datos recibidos de la imagen
        $name_img = $_FILES['imagen']['name'];
        $type = $_FILES['imagen']['type'];
        $size = $_FILES['imagen']['size'];
        $format_img = array(
            1 => "image/gif",
            2 => "image/jpeg",
            3 => "image/jpg",
            4 => "image/png",);
        if (($name_img == !NULL) && ($size <= 2000000)) {
            if ($type === $format_img[1] || $type === $format_img[2] || $type === $format_img[3] || $type === $format_img[4]) {

                $dir = $_SERVER['DOCUMENT_ROOT'] . '/intranet/uploads/';
                move_uploaded_file($_FILES['imagen']['tmp_name'], $dir . $name_img);

            } else {
                echo 'No se puede subir una imagen con este formato';
            }
        } else {

        }

    }

    public function editUser()
    {
        $respuesta = Crud::User("APSISISTEMAS.dbo.empleados");

        foreach ($respuesta as $row => $item) {
            echo '
<br>
<table class="table table-hover table-light">
    <tbody>
<tr>
    <td>' . $item['Empresa'] . '</td>
    <td>' . $item['Codigo'] . '</td>
    <td>' . $item['nombre'] . '</td>
    <td>' . $item['ap_paterno'] . '</td>
    <td>' . $item['ap_materno'] . '</td>
    <td>' . $item['Estatus'] . '</td>
    <td>' . $item['Motivo'] . '</td>
    <td>' . $item['Fecha_Real'] . '</td>
    <td>' . $item['Cerrada'] . '</td>
    <td>' . $item['CausaVacaciones'] . '</td>
    <td><a href="partials/registerUser.php"><button class="btn-warning">Editar</button></a></td>
    <td><a href="misSolicitudes.php"><button class="btn-danger">Borrar</button></a></td>
    <td><a href="principal.php"><button class="btn-dark">Regresar</button></a></td>
</tr>
   </tbody>
      </table>';
        }
    }

}