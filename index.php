<html>

    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
	<title>Scripted LaTeX Generator</title>
	
	<link rel="stylesheet" type="text/css" href="css/reset-fonts-grids.css">
	<link rel="stylesheet" type="text/css" href="css/base-min.css"> 
	<link rel="stylesheet" type="text/css" href="css/main.css">

        <script type="text/javascript" src="js/php.default.min.js"></script>
        <script type="text/javascript" src="edit_area/edit_area_full.js"></script>
        
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

        <script type="text/javascript" src="js/jquery.media.js"></script> 
        <script type="text/javascript" src="js/jquery.metadata.min.js"></script> 

        <script type="text/javascript" src="main.js"></script>

        <script> var init_book = "<?php echo $_REQUEST['id'] ? $_REQUEST['id'] : "testbook"  ; ?>" </script>

    </head>
    
    <body>
	<div id="doc4" class="yui-t6"> 
	    <div id="hd">
		<h1>Create a JavaScripted LaTeX Document!</h1>
	    </div> 
	    <div id="bd"> 
		<div id="yui-main">
	    	    <div class="yui-b">
			<div class="yui-g">

                            <div id="intro">
                                <h2>Introduction</h2>
                                Do you need an automation tool for creating a high quality print documents?<br>
                                This page is for you! Play with LaTeX online and see the resulting pdf immediately!<br>
                                <i>Curious about the code? Want to contribute? Check out the <a href="http://github.com/vviro/book-generator" target="_blank">repository</a> at GitHub!</i>

                                <h2>How to use the system</h2>
                                You can define any number of LaTeX snippets and in them use the variables, that are set by your javascript code.<br>
                                The javascript template works as follows:<br><br>
                                    <b><i>$-sign</i></b> means the produced LaTeX code,<br>
                                    <b><i>@templateA( var1, var2 )</i></b> means content of LaTeX snippet with name templateA and variables var1 and var2 set to the values of corresponding variables from the javascript. In templates you may use arbitrary number of variables. The only thing you have to pay attention to is that variables must be placed in alphabetical order when you are calling the template: <i>(fn(a,b,c), not fn(b,c,a))</i><br><br>
			        After you are finished with editing, click "Generate LaTeX", allow a few moments for generating the document.<br>
                                After the pdf file is generated you'll see the pdflatex output in the log window, which you may use for debugging eventual LaTeX errors.
	
				That's it - have fun!<p><p>
			    </div>
                            <a href="#" id='hide-intro'><small><i>hide the introduction</i></small></a>
                            <a href="#" id='show-intro'><h3>Introduction (+)</h3></a>

                            <div id="latex-js">
                                <h2>LaTeX-generating Javascript</h2>

                                <textarea id="editor">
                                </textarea>
                            </div>


                            <div>
<!--                                <input type="button" value="save current state"/> -->
                            </div>

			</div> 
		    </div> 
		</div> 
		<div class="yui-b">
		    <ul class="right_nav">

                        <input type="text" id="book_id"/> <p>
                        <input type="button" id="load" value="Load Book"/>
                        <input type="button" id="save" value="Save Book"/> <p>

                        <input type="button" id="generate" value="Generate LaTeX"/>
                        <p>
                        <img src="img/wait30trans.gif" id='wait'/>
                        <p>
                        <div id='book-link'>
                            <a href="cache/anon/book.pdf" id='pdf-link' target="_blank"><h4>The Book in pdf</h4></a>

                            <a href="cache/anon/book.tex" id='tex-link'><small>LaTeX source</small></a>
                            ,
                            <a href="cache/anon/book-images.tar.bz2" id='img-link'><small>Book image files</small></a>
                        </div>
                        <p><p>
                        
                        <a class="media" href="cache/anon/book.pdf" id="pdf-preview"></a>
                        <p>
                        pdflatex log: <a href="#" id='show-hide-log'>+</a><p>
		        <textarea id='log'  rows="10" cols="20"></textarea>
                        document versions:<p><div id='versions'></div>
                    </ul>
		</div> 
	    </div>
	    <div id="ft">
                <div id="footer">
                <center>last edited: <?php echo date ("d-m-Y", filemtime('index.php')) ?><p></center>
                </div>
            </div> 
	</div> 
    
    </body>
    
</html>
