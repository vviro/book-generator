<html>

    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
	<title>MineBook</title>
	
	<link rel="stylesheet" type="text/css" href="css/reset-fonts-grids.css">
	<link rel="stylesheet" type="text/css" href="css/base-min.css"> 
	<link rel="stylesheet" type="text/css" href="css/main.css">


        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="js/jquery.media.js"></script> 
        <script type="text/javascript" src="js/jquery.metadata.min.js"></script> 
        <script type="text/javascript" src="js/php.default.min.js"></script>
        <script type="text/javascript" src="main.js"></script>

    </head>
    
    <body>
    
	<div id="doc4" class="yui-t6"> 
	    <div id="hd">
		<h1>Generate a Minesweeper Book Online!</h1>
	    </div> 
	    <div id="bd"> 
		<div id="yui-main">
	    	    <div class="yui-b">
			<div class="yui-g">
			    <div id="introduction" class="topic">
                                <h2>Introduction</h2>
                                Are you thinking of writing a Minesweeper book but are not sure about the best layout for the puzzles?<br>
                                This page is for you! Play with LaTeX online and see the result - the book in pdf - immediately!<br>
                                This template engine can be easily extended, so do not hesitate - think what sections and template variables<br>
                                do you want to see here, and tell me about them!<br>
			    </div>
                            <div id="rules" class="topic">                                
                                <h2>How to play</h2>
			        Edit the template elements, click "Generate Book", wait a few moments and follow the link.<br>
                                After the book is generated you'll see the latex2pdf output in the log window.
	
				That's it, have fun!<p>
								
			    </div>

                            <div id="template" class="topic">
                                <h2>Template elements</h2>
                                <form id="template">

                                    board size:
                                    <input type="text" size="2" maxlength="2" id="sizex"></input> x 
                                    <input type="text" size="2" maxlength="2" id="sizey"></input>
                                    <p>

                                    <h4>LaTeX header:</h4>
                                    <textarea id="tex-head" class='tex' rows="5" cols="40">
                                    </textarea>

                                    <p>

                                    <h4>puzzle page:</h4>
                                    <textarea id="tex-page" class='tex' rows="10" cols="40">
                                    </textarea>
                                    
                                    <p>

                                    <h4>LaTeX footer:</h4>
                                    <textarea id="tex-foot" class='tex' rows="2" cols="40">
                                    </textarea>
                                </form>

                            </div>			    
			</div> 
		    </div> 
		</div> 
		<div class="yui-b">
		    <ul class="right_nav">

                        <input type="button" id="generate" value="Generate Book"/>
                        <p>
                        <img src="img/wait30trans.gif" id='wait'/>
                        <p>
                        <div id='book-link'>
                            <a href="cache/anon/book.pdf" id='pdf-link' target="_blank"><h4>The Book in pdf</h4></a>

                            <a href="cache/anon/book.tex" id='tex-link'><small>LaTeX source</small></a>
                            ,
                            <a href="cache/anon/book-images.tar.bz2" id='img-link'><small>Book image files</small></a>
                        </div>
                        <p><p><p>

                        book creation log:<p>
		        <textarea id='log'  rows="10" cols="20"></textarea>

                        <p>
                        <a class="media" href="cache/anon/book.pdf" id="pdf-preview"></a> 
		    </ul>
		</div> 
	    </div> 
	    <div id="ft"><center>last edited: <?php echo date ("d-m-Y", filemtime('index.php')) ?><p></center></div> 
	</div> 
    
    </body>
    
</html>
