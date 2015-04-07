<article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
		<h3 class="entry-title">
			Question: 
                            <?php 
                            $answer_posted=FALSE;
                            if(isset($_GET["post_answer"]))
                                if($_GET["post_answer"]=='true')
                                    $answer_posted=TRUE; 
                            
                            if($answer_posted){
                                echo $_SESSION['question_text'];
                            }
                            else{
                                require_once 'QuestionSelection.php';
                                //$question=getAQuestion();
                                $question=getAdaptiveQuestion();
                                if($question==FALSE)
                                    echo "Fail to fetch questions. Please login first. ";
                                else{
                                    //$_SESSION['question_text']=$question['question_text'];
                                    echo $question['question_text'];
                                }
                            
                            }
                            ?>                        
		</h3>
		
        </header><!-- .entry-header -->
        <div class="entry-content">    
            <?php                 
            if($answer_posted) {?>
                <label>Your answer to the question:</label> <br> 
                    <p><textarea name="input_ans" rows="10" cols="60" disabled><?php
                        echo $_SESSION['stu_answer'];
                    ?></textarea></p> 
                <label >Feedback: </label><br>
                <?php echo $_SESSION['feedback'] ?> <br>
              <!--  <label >Answer keys: </label><br>
                <?php echo $_SESSION['answerKey'] ?><br>   -->
                <form name="form_ans" action="post_feedback_to_answer.php" method="post">
                  <!--    <label>Any comments or suggestion to the system feedback/answer?</label> <br> 
                    <p><textarea name="comment" rows="10" cols="60"></textarea></p> -->
                     <?php echo "<input type=\"hidden\" name=\"question_id\" value=\"".$_GET['id']."\"/>" ?>
                    <p><input type="submit" value="Next question" name="btn_submit" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();" /></p>
                </form>
                <script>
                var frmvalidator  = new Validator("form_ans");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("feedback_rating","selone_radio","Please provide a rating");

                </script>
            <?php }
            else {?>
                <form name="form_ans" action="post_answer.php" method="post">
                    <label>Your answer to the question:</label> <br> 
                    <p><textarea name="input_ans" rows="10" cols="60"></textarea></p> 
                    <p><input type="submit" value="Submit" name="btn_submit" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();" /></p>

                    <?php echo "<input type=\"hidden\" name=\"question_id\" value=\"".$question['id']."\"/>" ?>
                </form>
            <?php }?>
                
            
 
        </div>	
        </article><!-- #post -->