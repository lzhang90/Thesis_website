<article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
		<h3 class="entry-title">
			Questionnaire                       
		</h3>
		
        </header><!-- .entry-header -->
        <div class="entry-content">
            <form name="form_ans" action="post_questionnaire.php" method="post">
                <label>Does imperfect grammar harm your learning ?</label> <br> 
                    Yes. <span style="padding: 0 180px">&nbsp;</span> not at all 
                    <br>
                    <input type="radio" name="grammar" value="5"/><label class="question_rating">5</label>
                    <input type="radio" name="grammar" value="4"/><label class="question_rating">4</label>
                    <input type="radio" name="grammar" value="3"/><label class="question_rating">3</label>
                    <input type="radio" name="grammar" value="2"/><label class="question_rating">2</label>
                    <input type="radio" name="grammar" value="1"/><label class="question_rating">1</label>
                    
                    <br><br>
                <label>How do you decide whether a question is machine generated or not ?</label> <br> 
                <p><textarea name="criteria" rows="10" cols="60"></textarea></p>
                <p><input type="submit" value="Submit" name="btn_submit" /></p>
            </form>
            <script>
                var frmvalidator  = new Validator("form_ans");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("grammar","selone_radio","Please provide a username");;
            </script>
        </div>	
        </article><!-- #post -->