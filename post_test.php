<?php
    include 'QuestionSelection.php';

    session_start();
    $username=$_SESSION['user'];
    $qid=$_POST['question_id'];
    $answer=$_POST['test'];
    $type=$_POST['type'];

    $con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");;
    
    $sql="INSERT INTO ".$type."_ans(user_id, question_id,answer) 
            values ('".$username."',".$qid.",".$answer.");";
    //echo $sql;
    $insert= mysqli_query($con, $sql);
    
   
    $sql="select qm.kcid kcid,g.grade grade from test_q_kc qm,gradesheet g where qid=".$qid." and qm.kcid=g.kc_id and g.username='".$username."'";
    echo $sql;
    $result= mysqli_query($con,$sql);
    $ks=array();
    if($result->num_rows>0){
        while($row=$result->fetch_array()){
            echo $row['grade'];
            $ks[$row['kcid']]=$row['grade'];
        }
    }
    var_dump($ks);
    if($answer==1){ //corect
        foreach($ks as $kcid=>$grade){
            echo updateKcGrade($kcid,k_correct($grade,$ks));
        }
    }
    else
        foreach($ks as $kcid=>$grade){
            echo updateKcGrade($kcid,k_incorrect($grade,$ks));
        }
        
    mysqli_close($con);
    if($insert==1)
        header("Location:index.php?page_id=5&type=".$type);
    else 
        echo $sql;
?>


