<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classs/User.php');
$usr = new User();
?>

<?php
 if(isset($_GET['dis'] )){
     $dblid = (int)$_GET['dis'];
     $dblUser = $usr->disableUser($dblid);
 }
if(isset($_GET['ena'] )){
    $enbid = (int)$_GET['ena'];
    $enbUser = $usr->enableUser($enbid);
}
if(isset($_GET['del'] )){
    $delid = (int)$_GET['del'];
    $delUser = $usr->deleteUser($delid);
}
?>

    <div class="main">
        <h1>Admin Panel - Manage User </h1>
        <?php
        if (isset($dblUser)){
            echo $dblUser;

        }
        if (isset($enbUser)){
            echo $enbUser;

        }
        if (isset($delUser)){
            echo $delUser;

        }


        ?>
        <div class="manageuser">
            <table class="tblone">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php

                $userData = $usr->getAllUser();
                if ($userData){
                    $i = 0;
                    while ($result = $userData->fetch_assoc()){
                      $i++;


                ?>
                <tr>
                        <?php if ($result['status']== '0'){
                            echo "<span class = 'error'>".$i."</span>";
                        }else{
                            echo $i;
                        }
                        ?>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['name'];?></td>
                    <td><?php echo $result['username'];?></td>
                    <td><?php echo $result['email'];?></td>
                    <td>
                        <?php if ($result['status']== '0'){ ?>
                        <a onclick ="return confirm('Are yoy sure to Disable')" href="?dis=<?php echo $result['user_id'];?>">Disable</a>
                        <?php } else {?>
                        <a onclick ="return confirm('Are yoy sure to Enable')" href="?ena=<?php echo $result['user_id'];?>">Enable</a>
                            <?php } ?>
                        <a onclick ="return confirm('Are yoy sure to Remove')" href="?del=<?php echo $result['user_id'];?>">Remove</a>
                    </td>
                </tr>
                        <?php }}?>
            </table>

        </div>




    </div>
<?php include 'inc/footer.php'; ?>