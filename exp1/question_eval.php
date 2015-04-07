<article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
		<h3 class="entry-title">
			Question: 
                            <?php 
                            require_once 'QuestionSelection.php';
                            //$question=getAQuestion();
                            $question=getAdaptiveQuestion();
                            if($question==FALSE)
                                echo "Fail to fetch questions. Please login first. ";
                            else    
                                echo $question['question_text'];
                            ?>                        
		</h3>
		
        </header><!-- .entry-header -->
        <div class="entry-content">
            <form name="form_ans" action="post_answer.php" method="post">
                <label>Are all the concepts in the question covered in your Biology classes?</label> <br> 
                    all of them<span style="padding: 0 150px">&nbsp;</span> not at all 
                    <br>
                    <input type="radio" name="relevance" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="relevance" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="relevance" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="relevance" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="relevance" value="1"/><label class="question_rating">1</label>
                    
                    <br><br>
                <label for="fluency">Is the question grammatically natural?</label> <br> 
                    very natural <span style="padding: 0 155px">&nbsp;</span> not at all 
                    <br>
                    <input type="radio" name="fluency" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="fluency" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="fluency" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="fluency" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="fluency" value="1"/><label class="question_rating">1</label>
                    
                    <br><br>
                 <label>Is the question ambiguous?</label> <br> 
                    very ambiguous <span style="padding: 0 140px">&nbsp;</span> not at all 
                    <br>
                    <input type="radio" name="ambiguity" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="ambiguity" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="ambiguity" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="ambiguity" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="ambiguity" value="1"/><label class="question_rating">1</label>
                    
                <br><br>
                <label>Do you think the question was made by a human or a machine?</label> <br> 
                    
                    <input type="radio" name="like_human" value="1"/><label class="question_rating">Human</label>
                    <input type="radio" name="like_human" value="0"/><label class="question_rating">Machine</label>
                    
                <br><br>
                <label>Your answer to the question:</label> <br> 
                <p><textarea name="input_ans" rows="10" cols="60"></textarea></p>
                 <label>Did you learn or strengthen your understanding of any concept by answering the question?</label> <br> 
                    Yes. <span style="padding: 0 180px">&nbsp;</span> not at all  
                    <br>
                    <input type="radio" name="pedagogy" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="pedagogy" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="pedagogy" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="pedagogy" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="pedagogy" value="1"/><label class="question_rating">1</label>
                    
                <br><br>
                 <label>How much thinking vs. just memorizing did you use in answering the question?</label> <br> 
                    Thinking. <span style="padding: 0 150px">&nbsp;</span> Just memorizing
                    <br>
                    <input type="radio" name="depth" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="depth" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="depth" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="depth" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="depth" value="1"/><label class="question_rating">1</label>
                    
                <br><br>
                <p><input type="submit" value="Submit" name="btn_submit" /></p>
                <?php echo "<input type=\"hidden\" name=\"question_id\" value=\"".$question['id']."\"/>" ?>
            </form>
            <script>
                var frmvalidator  = new Validator("form_ans");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("relevance","selone_radio","Please provide a username");
                frmvalidator.addValidation("fluency","selone_radio","Please provide a username");
                frmvalidator.addValidation("fluency","like_human","Please provide a username");
                frmvalidator.addValidation("ambiguity","selone_radio","Please provide a username");
                frmvalidator.addValidation("pedagogy","selone_radio","Please provide a username");
                frmvalidator.addValidation("depth","selone_radio","Please provide a username");
            </script>
        </div>	
        </article><!-- #post -->