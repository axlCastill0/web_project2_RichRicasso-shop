<?php

class UsersController extends Users {
    private $uid;
    private $email;
    private $pwd;

    public function __construct($uid, $email, $pwd) {
        $this->uid = $uid;
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function registerUser() {
        if($this->emptyInput() == false) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if($this->invalidUid() == false) {
            header("location: ../index.php?error=invaliduid");
            exit();
        }
        if($this->invalidEmail() == false) {
            header("location: ../index.php?error=invalidemail");
            exit();
        }
        if($this->existingUser() == false) {
            header("location: ../index.php?error=existinguser");
            exit();
        }

        $this->setUser($this->uid, $this->email, $this->pwd);
    }

    private function emptyInput() {
        $result = true;
        if(empty($this->uid) || empty($this->email) || empty($this->pwd)) {
            $result = false;
        }
        return $result;
    }

    private function invalidUid() {
        $result = true;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail() {
        $result = true;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        return $result;
    }

    private function existingUser() {
        $result = true;
        if (!$this->checkUser($this->uid, $this->email)) {
            $result = false;
        }
        return $result;
    }
}