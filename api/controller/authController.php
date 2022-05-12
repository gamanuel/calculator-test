<?php

require_once 'controller.php';
require_once 'model/userModel.php';


class AuthController extends Controller {

    public function __construct(){
        //Invoca al constructor de la clase padre Controller
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function authenticate(){

        $user = $_POST['user'];
        $password = $_POST['password'];

        $dbUser = $this->userModel->userAuth($user);

        if($dbUser){
            if(password_verify($password,$dbUser->password)){
                //En este caso generamos un token aleatorio, pero en un caso de un mejor login se usaria JWT
                $token = md5(uniqid(rand(), true));
                $this->userModel->saveToken($token,$dbUser->id);
                $this->response->status = 'success';
                $this->response->token = $token;
                $this->returnData($this->response,200);
            }
        }

        $this->response->status = 'error';
        $this->response->message = 'Credenciales invalidas';
        $this->returnData($this->response,400);
    }


}