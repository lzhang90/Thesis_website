<!DOCTYPE html>

<html lang="en-US">
        <?php
        
        session_start();
        //create connection    

    //$con=mysqli_connect("localhost:3306", "root","qbasic","question");
    $con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

        $result = mysqli_query($con,"SELECT count(*) as num FROM question");
        
        while($row = mysqli_fetch_array($result))
        {
        $num= $row['num'];
        }
        
        if(isset($_SESSION["user"])){
            $_SESSION["user"]=$_SESSION["user"];
            $user=$_SESSION["user"];
            $alreadyAnswered=0;
            $result=mysqli_query($con,"SELECT count(*) as num FROM user_ans where user_id='".$user."'");
            while($row = mysqli_fetch_array($result)){
                    $alreadyAnswered=$row['num'];
            }
        }
        else{
            $user=null;
        }
        
        
        ?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>Biology Questions</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="../wordpress/xmlrpc.php">

	<link rel="alternate" type="application/rss+xml" title="Biology Questions &raquo; Feed" href="../wordpress/?feed=rss2" />
<link rel="alternate" type="application/rss+xml" title="Biology Questions &raquo; Comments Feed" href="../wordpress/?feed=comments-rss2" />
<link rel='stylesheet' id='open-sans-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=3.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css'  href='../wordpress/wp-includes/css/dashicons.min.css?ver=3.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='admin-bar-css'  href='../wordpress/wp-includes/css/admin-bar.min.css?ver=3.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='twentythirteen-fonts-css'  href='//fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C700%2C300italic%2C400italic%2C700italic%7CBitter%3A400%2C700&#038;subset=latin%2Clatin-ext' type='text/css' media='all' />
<link rel='stylesheet' id='genericons-css'  href='../wordpress/wp-content/themes/twentythirteen/fonts/genericons.css?ver=2.09' type='text/css' media='all' />
<link rel='stylesheet' id='twentythirteen-style-css'  href='../wordpress/wp-content/themes/twentythirteen/style.css?ver=2013-07-18' type='text/css' media='all' />
<link rel='stylesheet' type='text/css' href='css\headerstyle.css'>
<script src="gen_validatorv4.js" type="text/javascript"></script>

<script type='text/javascript' src='../wordpress/wp-includes/js/jquery/jquery.js?ver=1.10.2'></script>
<script type='text/javascript' src='../wordpress/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="../wordpress/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="../wordpress/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 3.8.1" />
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
	<style type="text/css" id="twentythirteen-header-css">
			.site-header {
			background: url(../wordpress/wp-content/themes/twentythirteen/images/headers/circle.png) no-repeat scroll top;
			background-size: 1600px auto;
		}
		</style>
	<style type="text/css" media="print">#wpadminbar { display:none; }</style>
<style type="text/css" media="screen">
	html { margin-top: 32px !important; }
	* html body { margin-top: 32px !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 46px !important; }
		* html body { margin-top: 46px !important; }
	}
</style>
<script>
    //Set Videos below header
    $("iframe").each(function(){
    var ifr_source = $(this).attr('src');
    var wmode = "wmode=transparent";
    if(ifr_source.indexOf('?') !== -1) {
        var getQString = ifr_source.split('?');
        var oldString = getQString[1];
        var newString = getQString[0];
            $(this).attr('src',newString+'?'+wmode+'&'+oldString);
    }
    else $(this).attr('src',ifr_source+'?'+wmode);
});
</script>
</head>

<body class="home blog logged-in admin-bar no-customize-support single-author">
    <div id="fixed-header">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <?php
        if($user!=null){
             echo "<font color='white'>".$user."</font>";
             echo "<a href='logout.php'> Logout</a>";
        } else {?>
        <a href='login.php'><font color='white'>Login</font></a>
        <?php } ?>      
            </div>
	<div id="page" class="hfeed site">
            
		<header id="masthead" class="site-header" role="banner">
			<a class="home-link" href="index.php" title="Biology Questions" rel="home">
				<h1 class="site-title">Biology Questions</h1>
				<h2 class="site-description"></h2>
			</a>

			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<!-- <h3 class="menu-toggle">Menu</h3>
					<a class="screen-reader-text skip-link" href="#content" title="Skip to content">Skip to content</a>-->
					<div class="nav-menu"><ul><li class="page_item page-item-2"><a href="index.php?page_id=2">Pick a question</a></li></ul></div>  <!-- pick a question-->
			</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->

		<div id="main" class="site-main">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		

        <?php
        if(isset($_GET["page_id"])){
            $page=$_GET["page_id"];
        }
        else {$page=1;}
        if($user!=null)
            if($num==$alreadyAnswered){
                $result=mysqli_query($con,"SELECT * FROM user where username='".$user."'");
                $grammar_prefer=0;
                while($row = mysqli_fetch_array($result))
                    $grammar_prefer=$row['grammar_prefer'];
                if($grammar_prefer==0)
                    $page=3;
                else
                    $page=4;
            }
            
        if ($page==0):
            ?>
        <article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
				<h2 class="entry-title">
                        <?php echo ("There are ".($num-$alreadyAnswered)." questions left to be answered. <p>"); 
                        echo ("\n\tClicking on the Pick a question button will forward you to a new question.");?>
		</h2>
		
		</header><!-- .entry-header -->

	
        </article>     
        <?php
        elseif ($page==1 || empty($page)) :
                ?>
        <article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
            <h2 class="entry-title">
                <?php 
                if($user==null) echo ("Please login first");
                else {
                    echo ("There are ".($num-$alreadyAnswered)." questions left to be answered.");
                    
                }
                    ?>
            </h2>
		
	</header><!-- .entry-header -->

	
        </article><!-- #post -->
        <?php elseif ($page==2) :?>
            <?php include 'question_eval.php';?>
        <?php elseif ($page==3) :?>
            <?php include 'questionnaire.php';?>
        <?php elseif ($page==4) :?>
             <article class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
    
	<header class="entry-header">
		
				<h2 class="entry-title">
			You have finished all the questions, thanks.
		</h2>
		
		</header><!-- .entry-header -->

	
        </article>     
        <?php endif;?>
		</div><!-- #content -->
	</div><!-- #primary -->


		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">


			<div class="site-info">
				<a href="http://wordpress.org/" title="Semantic Personal Publishing Platform">Designed by Lishan Zhang</a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
</body>
</html>