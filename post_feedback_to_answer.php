<?php

    session_start();
    $username=$_SESSION['user'];
    $qid=$_POST['question_id'];
    $comment=$_POST['comment'];
    
    $con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql='UPDATE user_ans SET comment="'.$comment.'" WHERE user_id="'.$username.'" and question_id='.$qid;
    $insert= mysqli_query($con, $sql);
    mysqli_close($con);
    if($insert==1)
        header("Location:index.php?page_id=2");
    else 
        echo $sql;   
    
    
    

    
/*
    $result = mysqli_query($con,"SELECT version FROM user_ans where user_id='".$username."' and question_id='".$qid."' order by version desc");
        
    $row = mysqli_fetch_array($result);
    
    $question['id']=$qid;
    $_SESSION['askedQuestions'][]=$question;   
    echo $qid;
    $feedback=checkAnswer($qid, $answer);
    $answerKey=getAnswerText($qid);
    echo $answerKey;
    $_SESSION['answerKey']=$answerKey;
    $_SESSION['feedback']=$feedback;
    
    
    if($row==null){
        $sql="INSERT INTO user_ans(user_id, question_id,version,answer_text) 
            values ('".$username."',".$qid.",1,'".$answer."');";
        echo $sql;
        $insert= mysqli_query($con, $sql);
        mysqli_close($con);
        if($insert==1)
            header("index.php?page_id=2");
        else 
            echo $insert;
    }
    else{
         echo "SELECT version FROM user_ans where user_id='".$username."' and question_id='".$qid."' order by version desc";
         mysqli_close($con);
         header("Location:index.php");
        //$version=$row['version']+1;
        //$sql="INSERT INTO user_ans(user_id, question_id,version,answer_text,relevance, fluency, ambiguity, like_human, pedagogy,depth) 
         //   values ('".$username."',".$qid.",".$version.",'".$answer."',".$relevance.",".$fluency.",".$ambiguity.",".$like_human.",".$pedagogy.",".$depth.");";
    }
*/
?>
