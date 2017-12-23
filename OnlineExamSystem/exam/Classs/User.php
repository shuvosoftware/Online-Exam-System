<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');



class User{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function getAdminData($data){
        $adminUser = $this->fm->validation($data['adminUser']);
        $adminPass = $this->fm->validation($data['adminPass']);
        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link, md5($adminPass));

    }



    public function userRegistration($name ,$username,$password,$email ){
        $name = $this->fm->validation($name);
        $username = $this->fm->validation($username);
        $password = $this->fm->validation($password);
        $email = $this->fm->validation($email);
        $name = mysqli_real_escape_string($this->db->link, $name);
        $username = mysqli_real_escape_string($this->db->link, $username);
        $password = mysqli_real_escape_string($this->db->link, md5($password));
        $email = mysqli_real_escape_string($this->db->link, $email);

        if ($name == "" || $username == "" || $password == "" || $email == "" ){
            echo "<span class='error'>Field must not br empty !</span>";
            exit();
        }else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            echo "<span class='error'>Invalid Email Address !</span>";
            exit();
        }else{
            $chkquery = "SELECT * FROM tbl_user WHERE email = '$email'";
            $chkresult = $this->db->select($chkquery);
            if ($chkresult != false){
                echo "<span class='error'> Email Address all ready Exit !</span>";
                exit();
            }else{
                $query = "INSERT INTO tbl_user( name,username,password,email ) 
                VALUES ('$name','$username','$password', '$email' )";
                $inserted_row = $this->db->insert($query);
                if ($inserted_row){
                    echo "<span class='success'> Registration Successfully !</span>";
                    exit();
                }else{
                    echo "<span class='error'> Error.... Not Registerd !</span>";
                    exit();
                }
            }
        }


    }


    public  function getAllUser(){
        $query = "SELECT * FROM  tbl_user ORDER BY user_id DESC ";
        $result = $this->db->select($query);
        return $result;
    }




    public function disableUser($userid){
        $query = "UPDATE tbl_user
        SET
        status ='1'
        WHERE 	user_id = '$userid'";
        $updated_row = $this->db->update($query);
        if ($updated_row){
            $msg = "<span class='success'>User Disable ! </span>";
            return $msg;
        }else{
            $msg = "<span class='success'>User not Disable ! </span>";
            return $msg;
        }

    }
    public function enableUser($userid){
        $query = "UPDATE tbl_user
        SET
        status ='0'
        WHERE 	user_id = '$userid'";
        $updated_row = $this->db->update($query);
        if ($updated_row){
            $msg = "<span class='success'>User Enable ! </span>";
            return $msg;
        }else{
            $msg = "<span class='success'>User not Enable ! </span>";
            return $msg;
        }

    }

    public function deleteUser($userid){
        $query = "DELETE FROM tbl_user WHERE 	user_id = '$userid'";
        $deldata = $this->db->delete($query);
        if ($deldata){
            $msg = "<span class='success'>User Removed ! </span>";
            return $msg;
        }else{
            $msg = "<span class='success'>User not Removed ! </span>";
            return $msg;
        }

    }
}

?>

