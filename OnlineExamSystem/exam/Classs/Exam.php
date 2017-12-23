<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');



class Exam{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function addQuestions($data)
    {


        $quesNo = mysqli_real_escape_string($this->db->link, $data['quesno']);
        $ques = mysqli_real_escape_string($this->db->link, $data['ques']);
        $ans = array();
        $ans[1] = $data['ans1'];
        $ans[2] = $data['ans2'];
        $ans[3] = $data['ans3'];
        $ans[4] = $data['ans4'];
        $rightAns = $data ['rightans'];

        $query = "INSERT INTO tbl_ques( quesno,ques ) 
                VALUES ('$quesNo','$ques' )";
        $insert_row = $this->db->insert($query);
        if ($insert_row) {

            foreach ($ans as $key => $ansName) {
                if ($ansName != '') {
                    if ($rightAns == $key) {
                        $rquery = "INSERT INTO tbl_ans(quesno,	rightans,ans)
                        VALUES ('$quesNo','1','$ansName')";
                    } else {
                        $rquery = "INSERT INTO tbl_ans(quesno,	rightans,ans)
                        VALUES ('$quesNo','0','$ansName')";
                    }
                    $insertrow = $this->db->insert($query);
                    if ($insertrow) {
                        continue;

                    } else {
                        die('Error...');
                    }

                }

            }
            $msg = "<span class='success'>Question Add Successfully !</span>";
            return $msg;
        }
    }

    public  function getQueByOrder(){
        $query  = " SELECT * FROM  tbl_ques ORDER BY 	quesno ASC ";
        $result  = $this->db->select($query);
        return $result;

    }

    public function delQuestion($quesNo){
        $tables = array("tbl_ques"," tbl_ans");
        foreach ($tables as $tabl ){
            $delquery = "DELETE FROM $tabl WHERE quesno = '$quesNo'";
            $deldata = $this->db->delete($delquery);

        }
        if ($deldata){
            $msg = "<span class='success'>Deleted Successfully !  </span>";
            return $msg;
        }else{
            $msg = "<span class='success'>Deleted not Successfully ! </span>";
            return $msg;
        }

    }

    public  function  getTotalRows(){
        $query     = "SELECT * FROM tbl_ques";
        $getResult = $this->db->select($query);
        $total     = $getResult->num_rows;
        return $total;
    }

}
?>