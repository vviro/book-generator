
var tex_head = "\\documentclass[a5paper]{memoir}\n<br>\\usepackage{graphicx} <br>\n\\usepackage{wrapfig} <br>\n\\begin{document}\n\n";

var tex_page = '\\begin{wrapfigure}{c}{150mm} <br>    \n\\vspace{-1pt}<br>    \n\\includegraphics[height=150px]{$image}<br>   \n\\caption{$title}<br>   \n\\hspace{-20pt}<br>\n\\end{wrapfigure}<br><br>\n\n\\newpage\n';

var tex_foot = "\\end{document}";

$(document).ready(function() {
    $('#tex-head').html(tex_head);
    $('#tex-page').html(tex_page);
    $('#tex-foot').html(tex_foot);
    $('#sizex').val(4);
    $('#sizey').val(6);

    $('#book-link').hide();
    $('#pdf-preview').hide();
    $('#wait').hide();

    $(function() {
        $("#accordion").accordion({
            autoHeight: false,
            event: "mouseover"
        });
    });

});


function head() {
    return $('#tex-head').html();
}

function page() {
    return $('#tex-page').html();
}

function foot() {
    return $('#tex-foot').html();
}

$(document).ready(function() {

    $('#generate').click(function() {
        var req_id = Math.floor(Math.random()*10000000);
        var md5_id = md5(req_id);
        $('#book-link').hide("fast");
        $('#pdf-preview').hide("fast");
        $('#log').html('');
        $('.media').empty();
        $('#wait').show();
        $.post( "generate.php", {head: head(), page: page(), foot: foot(), x:$('#sizex').val(), y:$('#sizey').val(), id: req_id}, function(data){ 
                $('#log').html(data);
                $('#book-link').show("fast");
                $('#pdf-preview').show("fast");
                $('#pdf-link').attr("href", "cache/"+md5_id+"/book.pdf");
                $('#pdf-preview').attr("href", "cache/"+md5_id+"/book.pdf");
                $('#tex-link').attr("href", "cache/"+md5_id+"/book.tex");
                $('#img-link').attr("href", "cache/"+md5_id+"/book-images.tar.bz2");
                $('#wait').hide();

                $('.media').media({width:290, height:425, src:"cache/"+md5_id+"/book.pdf"});
            } );
    });

});
