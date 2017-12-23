<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classs/Exam.php');
$exam = new Exam();

?>

<?php
if (isset($_GET['delque'])){
    $quesNo = (int)$_GET['delque'];
    $delQue = $exam->delQuestion($quesNo);

}




?>



    <div class="main">
        <h1>Admin Panel - Question Lst </h1>

        <div class="manageuser">
            <table class="tblone">
                <tr>
                    <th width="20%">No</th>
                    <th width="60%">Question</th>
                    <th width="40%">Action</th>
                </tr>
                <?php

                $getData = $exam->getQueByOrder();
                if ($getData){
                    $i = 0;
                    while ($result = $getData->fetch_assoc()){
                        $i++;


                        ?>
                        <tr>

                            <td><?php echo $i?></td>
                            <td><?php echo $result['ques'];?></td>

                            <td>

                                <a onclick ="return confirm('Are yoy sure to Remove')" href="?delque=<?php echo $result['quesno'];?>">Remove</a>
                            </td>
                        </tr>
                    <?php }}?>
            </table>

        </div>




    </div>
<?php include 'inc/footer.php'; ?>