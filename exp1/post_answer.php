<?php
    include 'QuestionSelection.php';

    session_start();
    $username=$_SESSION['user'];
    $qid=$_POST['question_id'];
    $answer=$_POST['input_ans'];
    $answer=str_replace("'", "\'", $answer);
    $con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");
    //$con=mysqli_connect("localhost:3306", "root","qbasic","question");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con,"SELECT version FROM user_ans where user_id='".$username."' and question_id='".$qid."' order by version desc");
        
    $row = mysqli_fetch_array($result);
    
    $relevance=$_POST["relevance"];
    $fluency=$_POST["fluency"];
    $ambiguity=$_POST["ambiguity"];
    $like_human=$_POST["like_human"];
    $pedagogy=$_POST["pedagogy"];
    $depth=$_POST["depth"];
    
    $question['id']=$qid;
    $_SESSION['askedQuestions'][]=$question;   
    checkAnswer($qid, $answer);
    /*
    if($row==null){
        $sql="INSERT INTO user_ans(user_id, question_id,version,answer_text,relevance, fluency, ambiguity, like_human, pedagogy,depth) 
            values ('".$username."',".$qid.",1,'".$answer."',".$relevance.",".$fluency.",".$ambiguity.",".$like_human.",".$pedagogy.",".$depth.");";
        echo $sql;
        $insert= mysqli_query($con, $sql);
        mysqli_close($con);
        if($insert==1)
            header("Location:index.php?page_id=0");
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
