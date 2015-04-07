<?php
    if(isset($_SESSION['user'])){
        $user=$_SESSION['user'];
    }
    else {
        echo "Login first.";
    }
    //select a question that has not been answered yet 
    global $con;
    $test_type=$_GET['type'];
    $result=  mysqli_query($con, "select id,question from test_questions q where q.id not in (select question_id from ".$test_type."_ans where user_id='".$user."');");
    $hasT=FALSE;
    
    if(isset($result))
    if($result->num_rows>0){
        $hasT=TRUE;
        $rand = rand(1,$result->num_rows);
        for($i=0;$i<$rand;$i++){
            $row=mysqli_fetch_array($result);
        }
        $qid=$row['id'];
        $qtext=$row['question'];

        $choice_result= mysqli_query($con, "select c.text text,c.correct correct from test_questions q, test_choice c where q.id=c.qid and q.id=".$qid.";");
        $choice=array();
        for($i=0;$i<$choice_result->num_rows;$i++){
            $choice_row=mysqli_fetch_array($choice_result);
            $choice[$choice_row['text']]=$choice_row['correct'];
        }
        $choice["Don't know"]= 0;
    }
?>

<article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
		<h3 class="entry-title">
			Test                       
		</h3>
		
        </header><!-- .entry-header -->
        <div class="entry-content">
            <form name="form_test" action="post_test.php" method="post">
            <?php if($hasT){?>
                <label><?php echo $qtext?></label> <br> 
                    <br>
                    <?php
                    foreach ($choice as $text=>$correct){
                        echo '<input type="radio" name="test" value="'.$correct.'"/><label class="question_rating">'.$text.'</label> <br>';
                    }
                    ?>
                    
                    <br><br>
                    <?php echo "<input type=\"hidden\" name=\"question_id\" value=\"".$qid."\"/>" ?>
                     <?php echo "<input type=\"hidden\" name=\"type\" value=\"".$test_type."\"/>" ?>
                <p><input type="submit" value="Submit" name="btn_submit" /></p>
           
            <?php }
            else {
                echo "<label> No Test left.</label> <br> ";
            }
            ?>
            </form>
            <script>
                var frmvalidator  = new Validator("form_test");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("test","selone_radio","Please provide a username");;
            </script>
        </div>	
        </article><!-- #post -->