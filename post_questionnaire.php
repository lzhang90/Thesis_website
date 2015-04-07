<?php

$con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");
    //$con=mysqli_connect("localhost:3306", "root","qbasic","question");
session_start();
    $username=$_SESSION['user'];
    $grammar=$_POST['grammar'];
    $criteria=$_POST['criteria'];
    
    $sql="UPDATE user SET grammar_prefer=".$grammar.", criteria='".$criteria."' WHERE username='".$username."'";
    
    $update= mysqli_query($con, $sql);
    mysqli_close($con);
    echo $sql;
    if($update==1)
        header("Location:index.php?page_id=0");
    else 
        echo $update;
?>
