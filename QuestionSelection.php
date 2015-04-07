<?php
$s=0.05; $g=0.2; $learn=0.3;
$adaptive=TRUE;
function getAQuestion(){
    if(isset($_SESSION['user'])){
        $user=$_SESSION['user'];
    }
    else {
        return;
    }
    //select a question that has not been answered yet 
    global $con;
    $result=  mysqli_query($con, "select * from question q where q.id not in (select question_id from user_ans where user_id='".$user."');");
    $hasnoanswer=0;
    if($result->num_rows==0){ //no row is returned, and every question has at least one answer
        //get the question with lowest number of answers
        $result=mysqli_query($con,"select question_id, count(user_id) as num from user_ans group by question_id having question_id not in (select question_id from user_ans where user_id='".$user."') order by num asc;");
        $row=mysqli_fetch_array($result);
        if($row==FALSE)
            $question=FALSE;
        else{
            $result=mysqli_query($con,"select question_id, count(user_id) as num from user_ans group by question_id having num=".$row['num']." order by num asc;");
            //$result=mysqli_query($con,"select * from question where id=".$row['question_id'].";");
            //$question=$row['question_text'];
        }
    }
    else
        $hasnoanswer=1;
    if($result->num_rows>0){
        $rand = rand(1,$result->num_rows);
        for($i=0;$i<$rand;$i++){
            $row=mysqli_fetch_array($result);
        }
        if($hasnoanswer==0){
            $result=mysqli_query($con,"select * from question where id=".$row['question_id'].";");
            $question=mysqli_fetch_array($result);
        }
        else
            $question=$row;
    }
    return $question;
}

    function getAdaptiveQuestion(){
        
        if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
        }
        else {
            return;
        }
        
        if(isset($_SESSION['askedQuestions'])){
            $askedQuestions=$_SESSION['askedQuestions'];
        }
        else {
            $askedQuestions=array();
        }
        
        global $con;
        //$result=  mysqli_query($con, "select * from question q where q.id not in (select question_id from user_ans where user_id='".$user."');");
        $result=  mysqli_query($con,"SELECT q.id qid,grade.grade grade FROM question q,q_kc_matrix qkc,gradesheet grade where grade.username='".$user."' and q.id=qkc.qid and grade.kc_id=qkc.kcid order by q.id");
        $ks=array();
        
        $qid_current=-1;
        if($result->num_rows>0){
            $questions=array();
            while($row=$result->fetch_array()){
                //error_log(print_r($row, TRUE)); 
                if($qid_current==-1)
                    $qid_current=$row['qid'];
                elseif($qid_current!=$row['qid']) //a new question
                {
                   //check whether the question has been asked before 
                    $asked=FALSE;   
                    foreach ($askedQuestions as $askedQuestion){
                        if($askedQuestion['id']==$qid_current){
                            $asked=TRUE;
                            break;
                        }
                    }
                    if(!$asked){
                        //calculate the utility of the previous question
                        $euq=0;                   
                        foreach($ks as $k){
                            $euq+=kj_gain($k,$ks);
                        }
                        $euq=$euq/count($ks);
                        $questions[$qid_current]=$euq;
                    }   
                    //record the new question id
                    $qid_current=$row['qid'];
                    $ks=array();
                }
                $ks[]=$row['grade'];
            }
            global $adaptive;
            if($adaptive)
                arsort($questions);
            else
                asort($questions);
            //error_log(print_r($questions, TRUE)); 
            $threshold=0;
            $candidates=array();
            $i=1;
            foreach($questions as $key=>$val){
                if($threshold==0)
                    $threshold=$val;
                elseif($val<$threshold)
                    break;
                $candidates[$i++]=$key; 
            }
            if(count($candidates)>=1){
                $rand=  rand(1, count($candidates));
                $final=mysqli_query($con,"select id, question_text from question where id=".$candidates[$rand]);
                if($final->num_rows>0)
                {
                    $question=$final->fetch_array();
                    return $question;
                }
            }
        }  
             
    }
    
    function updateKcGrade($kcid,$grade){
        if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
        }
        else {
            return;
        }
        
        global $con;
        $result= mysqli_query($con,"select grade from gradesheet WHERE username='".$user."' and kc_id=".$kcid);
        if($result->num_rows==0)
            return;
        $row=$result->fetch_array();
        mysqli_query($con,"UPDATE gradesheet SET grade=".$grade." WHERE username='".$user."' and kc_id=".$kcid);
        $result_sec= mysqli_query($con,"SELECT kc2id,relation,grade FROM kc_relation r,gradesheet g where kc1id=".$kcid." and g.kc_id=r.kc2id and username='".$user."'");
        if($result_sec->num_rows>0){
            while($row=$result_sec->fetch_array())
                mysqli_query($con,"UPDATE gradesheet SET grade=".($row['grade']+$grade*$row['relation'])/(1+$row['relation'])." WHERE username='".$user."' and kc_id=".$row['kc2id']);
        }
        
    }
    
    function checkAnswer($qid, $stuAns){
        if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
        }
        else {
            return;
        }
        
        global $con;
        $sql="select qm.kcid kcid,qm.answer answer,g.grade grade,qm.answer_text text from q_kc_matrix qm,gradesheet g where qid=".$qid." and qm.kcid=g.kc_id and g.username='".$user."'";
        echo $sql;
//error_log(print_r($sql, TRUE)); 
        $result= mysqli_query($con,$sql);
        
        $totalKc=0;
        $correctKc=0;
        $feedbackArray=array();
        if($result->num_rows>0){
            while($row=$result->fetch_array()){
                $totalKc++;
                $k=$row['grade'];
               // error_log(print_r($k, TRUE)); 
                echo $row['answer'];
                echo checkKc($stuAns, $row['answer']);
                if(checkKc($stuAns, $row['answer'])){ //answer is correct in terms of the kc
                    updateKcGrade($row['kcid'],k_correct($k));
                    $correctKc++;
                    $feedbackArray[$row['text']]="correct";
                  //  error_log(print_r("correct:".k_correct($k), TRUE)); 
                }
                else{
                    updateKcGrade($row['kcid'],k_incorrect($k));
                    $feedbackArray[$row['text']]="incorrect";
                  //  error_log(print_r("incorrect".k_incorrect($k), TRUE)); 
                }
            }
        }
        
        $correctText="";
        $incorrectText="";
        foreach($feedbackArray as $text=>$correctness){
            if($correctness=="correct")
                $correctText.=$text."<br>";
            else
                $incorrectText.=$text."<br>";
        }
        
        echo "correct:  ".$correctText."<br>";
        echo $incorrectText;
     
        if($correctText!="" && $incorrectText!="")
            return "You mentioned that<br>".$correctText."<br>But you missed the following points:<br>".$incorrectText;
        else if($correctText=="" && $incorrectText!="")
            return "You missed the following key points:<br>".$incorrectText;
        else
            return "Great! You mentioned that<br>".$correctText."<br>You hit all the key points!";
        /*
        if($correctKc/$totalKc==1.0)
            return "Great, your answer is completely correct!";
        else if($correctKc/$totalKc>0.7) 
            return "Good, your answer is almost correct.";
        else {
            return "There is someting wrong with your answer. Plase check the answer key carefully.";
        }*/
    }
    
    function getAnswerText($qid){
        global $con;
        $sql="select kcid,answer_text from q_kc_matrix where qid=".$qid;
        
        $result= mysqli_query($con,$sql);
        $answer="";
        if($result->num_rows>0){
            while($row=$result->fetch_array()){
                $answer=$answer.$row['answer_text']."<br>";
            }
        }
        return str_replace("_", " ", $answer);
    }
    
    function check_user_defined_syns($stuAns,$key){
        $syns = array(
            "light reaction" => array("light dependent reaction"),
            "calvin cycle" => array("light independent reaction", "dark reaction"),
            "water molecule" => array("water"),
            "oxygen molecule" => array("oxygen"),
            "sunlight"=>array("light"),
            "ribulose bisphosphate"=>array("RuBP","Ribulose-1,5-bisphosphate"),
            "nadp plus"=>array("nadp+"),
            "three phosphoglycerate"=>array("3-phosphoglycerate","3PG","3 phosphoglycerate","3PGA","3-PGA","3-phospho-D-glycerate","3-phospho-(R)-glycerate", "3-phospho-D-glyceric acid", "3-P-D-glycerate", "D-glycerate-3-P", "D-glycerate 3-phosphate", "D-3-phosphoglycerate"),
            "glyceraldehyde 3 phosphate"=>array("G3P","GA3P","GP","glyceraldehyde 3-phosphate","glyceraldehyde-3-phosphate"),
            "3 phosphoglycerate"=>array("3-phosphoglycerate","3PGA","3-PGA","3PG","3-phospho-D-glycerate","3-phospho-(R)-glycerate", "3-phospho-D-glyceric acid", "3-P-D-glycerate", "D-glycerate-3-P", "D-glycerate 3-phosphate", "D-3-phosphoglycerate"),
            "adenosine diphosphate"=>array("ADP"),
            "raw material"=>array("reactant")
        );
        $contained=FALSE;
        if(array_key_exists($key,$syns)){
            foreach($syns[$key] as $syn){
                 if(contains($stuAns,$syn)==TRUE){
                    $contained=TRUE;
                    break;                                    
                 }
            }
        }
        return $contained;
    }

    function checkKc($stuAns, $kcAns){
        //error_log(print_r($stuAns, TRUE)); 
         //error_log(print_r($kcAns, TRUE)); 
         $keys=explode(",",$kcAns);
         $keysnum=0;
         $found=0;
         foreach($keys as $key){
             //echo $key."----";
             $keysnum++;
             if(contains($stuAns,$key)==TRUE)
                     $found++;
             else if(check_user_defined_syns($stuAns,$key)==TRUE)
                     $found++;
             else if(($r=@file_get_contents("http://words.bighugelabs.com/api/2/681486b94f65f70e7999bd145e4fc3bb/".$key."/php"))){ //check its synnonyms
                 
               // $r = file_get_contents("http://words.bighugelabs.com/api/2/681486b94f65f70e7999bd145e4fc3bb/".$key."/php");

                $syms= unserialize($r);
                $contained=FALSE;
                if(is_array ($syms)){
                    //var_dump($syms);
                    foreach($syms as $symtype){ //e.g noun  syms["noun"]
                        if(is_array($symtype["syn"]))
                        {
                            foreach($symtype["syn"] as $syn){
                                //echo $stuAns."++++";
                                //echo $syn."-----";
                                if(contains($stuAns,$syn)==TRUE){
                                    $contained=TRUE;
                                    break;                                    
                                }
                            }
                        }
                        if($contained==TRUE)
                            break;
                    }
                }
                if($contained==TRUE)
                    $found++;
            }
            
            
         }
         echo $found."/".$keysnum."=".$found/$keysnum;
         if($found/$keysnum>0.8)
             return TRUE;
         else
             return FALSE;
         //error_log(print_r(strpos($stuAns,$kcAns), TRUE)); 
        
    }
    
    function contains($s, $word){
        $s=strtolower($s);
        $word=strtolower($word);
        if(strpos($s,$word)===FALSE)
            return FALSE;
        else
            return TRUE;
    }
    
    function k_correct($kj,$ks=NULL){ //calculate the post k in terms of the knowledge component kj and the array of all the knowledge components ks
        global $g,$s; 
        if($ks!=NULL){
            $ok=1;    
            foreach($ks as $i=>$k)
                $ok=$ok*$k;
            $k_correct=($ok*(1-$s)+($kj-$ok)*$g)/($ok*(1-$s)+(1-$ok)*$g);
            return $k_correct;
        }
        else{
            $k_correct=($kj*(1-$s))/($kj*(1-$s)+(1-$kj)*$g);
            return $k_correct;
        }
    }
    
    
    function k_incorrect($kj,$ks=NULL){
        
        global $g,$s;
        if($ks!=NULL){
            $ok=1;
            foreach($ks as $i=>$k)
                $ok=$ok*$k;
            $k_incorrect=($ok*$s+($kj-$ok)*(1-$g))/($ok*$s+(1-$ok)*(1-$g));
            return $k_incorrect;
        }
        else{
            $k_incorrect=($kj*$s)/($kj*$s+(1-$kj)*(1-$g));
            return $k_incorrect;
        }
    }
    
    function kj_gain($kj,$ks=NULL){
        global $learn;
        if($ks!=NULL){
            $gain=((k_correct($kj, $ks)-$kj)+(1-k_correct($kj, $ks))*$learn)*$kj+((k_incorrect($kj, $ks)-$kj)+(1-k_incorrect($kj, $ks))*$learn)*(1-$kj);
            return $gain;            
        }
        else{
            $gain=((k_correct($kj)-$kj)+(1-k_correct($kj))*$learn)*$kj+((k_incorrect($kj)-$kj)+(1-k_incorrect($kj))*$learn)*(1-$kj);
            return $gain;   
        }
    }
?>
