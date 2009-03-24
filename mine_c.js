
main();

function main()
{
    n = 0;

    n1 = 4;
    n2 = 4;

    x = parseInt(readFile('sizex'));
    y = parseInt(readFile('sizey'));

    startLaTeX();

    //draw 4x6
    for (k=0; k < n1; k++) {
        n++;
        q = "triangular";
        imya = "PuzzleNumber"+n;
        drawMines(x,y,q,imya);
    }
    //draw 6x8
    for (k=0; k < n2; k++) {
        n++;
        q = "quadratic";
        imya = "PuzzleNumber"+n;
        drawMines(x,y,q,imya);
    }

    finishLaTeX();
}

function startLaTeX() {
    runCommand('touch', 'book.tex');
    header = '\n\\documentclass[a5paper]{memoir}\n\n\\usepackage{graphicx} \n\\usepackage{wrapfig} \n\n\\begin{document}\n\n';
    header = readFile('header.tex');

    runCommand('bash','-c', 'echo "'+header+'" > book.tex');
};

function finishLaTeX() {
    footer = '\n\\end{document}';
    footer = readFile('footer.tex');
    runCommand('bash','-c', 'echo "'+footer+'" >> book.tex');
};


function addMinePage( title, mine_image_file )
{
    page = "\\begin{wrapfigure}{c}{150mm} \n    \\vspace{-1pt}\n    \\includegraphics[height=150px]{'" + mine_image_file + "'}\n   \\caption{"+title+"}\n    \\hspace{-20pt}\n\\end{wrapfigure}\n\n\\newpage\n";
    page = readFile('page.tex');

    page = page.replace('$image', mine_image_file);
    page = page.replace('$title', title);

    runCommand('bash','-c', 'echo "'+page+'" >> book.tex');
}

function drawMines(m,n,fmt,imya) {

var i,j,checkSum,sumNeib
level = 2;

vect_mines = '';
vect_sol = '';

function inTable (i,j,m,n)
{
if (i*(i-m-1)*(j-0)*(j-n-1)==0) {return 0} else {return 1}
}


function showstar (i)
{
if (i==1) {return '*'} else {return '_'}
}

mines = new Array()
for (i=0; i <m+2; i++) {
   mines[i] = new Array()
   for (j=0; j <n+2; j++) {
      mines[i][j] = 0;
   }
}


if (level==0) {

for (i=1; i <m+1; i++) {
      for (j=1; j <n+1; j++) {
      mines[i][j] = Math.round(Math.random());
   }
}

               }


if (level==1) {

      for (j=1; j <n+1; j++) {
      mines[1][j] = Math.round(Math.random());
   }

for (i=2; i <m+1; i++) {
    for (j=1; j <n+1; j++) {
        mines[i][j] = Math.round(Math.random());
        checkSum = mines[i-2][j]+mines[i-1][j-1]+mines[i][j]+mines[i-1][j+1];
        sumNeib = inTable(i-2,j,m,n)+inTable(i-1,j-1,m,n) + inTable(i,j,m,n) + inTable(i-1,j+1,m,n);
    if (checkSum==sumNeib) {mines[i][j]=0} 
    else 
    {
        if (checkSum==0) {mines[i][j]=1}
    } 
}}

               }

if (level==2) {
      for (j=1; j <n+1; j++) {
      mines[1][j] = Math.round(Math.random());
   }

for (i=2; i <m+1; i++) {
      for (j=1; j <n+1; j++) {
mines[i][j] = Math.round(Math.random());
checkSum = mines[i-2][j]+mines[i-1][j-1]+mines[i][j]+mines[i-1][j+1];
sumNeib = inTable(i-2,j,m,n)+inTable(i-1,j-1,m,n) + inTable(i,j,m,n) + inTable(i-1,j+1,m,n);
      if (checkSum==sumNeib) {mines[i][j]=0} else 
{if (checkSum==0) {mines[i][j]=1}
   } 
}
}


      for (j=2; j <n+1; j++) {
checkSum = mines[m][j-2]+mines[m-1][j-1]+mines[m][j];
sumNeib = inTable(m,j-2,m,n)+inTable(m-1,j-1,m,n) + inTable(m,j,m,n);
 if (checkSum==sumNeib) {mines[m][j]=0} else 
{if (checkSum==0) {mines[m][j]=1}
   }
   }


             }


numbers = new Array()
for (i=1; i <m+1; i++) {
   numbers[i] = new Array()
   for (j=1; j <n+1; j++) {
      numbers[i][j] = mines[i-1][j]+mines[i][j-1]+mines[i+1][j]+mines[i][j+1];
//      print(i + "x"+ j + ": " + numbers[i][j]);
   }
}

t1 = '<table border=3 cellpadding="7" rules="all">';

//var imya = Math.random();

/*
$('#tex-mines').append('\\label{'+imya+'}');
$('#tex-mines').append('\\begin{tabular}{|');
*/
for (i=1; i <n+1; i++) { 
//    $('#tex-mines').append('c|') 
};

//$('#vect_mines').append('mines,name='+imya+',m='+m+',n='+n+':');
vect_mines = vect_mines + 'mines,name='+imya+',m='+m+',n='+n+':';

//$('#tex-mines').append('}');
//$('#tex-mines').append('\\hline');
//$('#tex-mines').append('<br>');

for (i=1; i <m+1; i++) {

t1 += '<tr border=3>';

for (j=1; j <n+1; j++) {
    t1 += '<td border=3 style="width:20px;height:20px">';
    if ((i+j)/2 == Math.round((i+j)/2))  { 
        t1 += "<div>" + showstar(mines[i][j]) +"</div>";
//        $('#tex-mines').append( showstar(mines[i][j]) );
//        $('#vect_mines').append(showstar(mines[i][j])+',');
        vect_mines += showstar(mines[i][j])+',';
    }
    else {
        t1 += "<div>" +"  "+  "</div>";
//        $('#vect_mines').append(",");
        vect_mines += ',';
    }  
    if (j < n) 
//        $('#tex-mines').append('&'); 
        ;
}
t1 += '</tr>';
//$('#tex-mines').append('\\\\ \\hline');
//$('#tex-mines').append('<br>');

}

t1 += '</table>';
//$('#tex-mines').append('\\end{tabular} \\quad \\quad \\end{equation}');


//$('#tables').append(t1+'<br><br><br>');

t2 = '<table cellpadding="7" rules="all" border=3>';

//$('#vect_sol').append('sol,name='+imya+',m='+m+',n='+n+':');
vect_sol += 'sol,name='+imya+',m='+m+',n='+n+':';
//$('#tex-sol').append('\\ref{'+imya+'} \\begin{tabular}{|');
for (i=1; i <n+1; i++) { 
//    $('#tex-sol').append('c|') 
};
//$('#tex-sol').append('}');
//$('#tex-sol').append('\\hline');
//$('#tex-sol').append('<br>');

for (i=1; i <m+1; i++) {

t2 += '<tr>';

for (j=1; j <n+1; j++) {
    t2 += '<td style="width:20px">';

    if ((i+j)/2 != Math.round((i+j)/2))  { 
        t2 += "<div>" + numbers[i][j] +"</div>";
//        $('#tex-sol').append( numbers[i][j] );
//        $('#vect_sol').append( numbers[i][j] +',');
        vect_sol += numbers[i][j] +',';
    }
   else {
        t2 += "<div>" +"  "+  "</div>";
//        $('#vect_sol').append(",");
        vect_sol += ',';
    }
  
//   if (j < n) $('#tex-sol').append('&');
    
}

t2 += '</tr>';
//$('#tex-sol').append('\\\\ \\hline');
//$('#tex-sol').append('<br>');

}

t2 += '</table>';
//$('#tex-sol').append('\\end{tabular} \\quad \\quad');
//$('#tables').append(t2);

//'#tables'.forms.mmm.m.value=m
//'#tables'.forms.mmm.n.value=n
//'#tables'.forms.mmm.level.value=level

board_url = 'http://pc-alex.dyndns.org:8080/tmp/board.php?vector=';

m_url = board_url+vect_mines+"&fmt="+fmt;
s_url = board_url+vect_sol+"&fmt="+fmt;

imya2 = m+"x"+n+"_"+fmt+"_"+imya;

runCommand('wget' , m_url , "-O", "img/"+ imya2 + "_mines.png" );
runCommand('wget' , s_url , "-O", "img/"+ imya2 + "_sol.png" );

addMinePage( imya, "img/"+ imya2 + "_sol.png" );

};


