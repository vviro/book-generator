
var tex_head = "\\documentclass[a5paper]{memoir}\n\\usepackage{graphicx} \n\\usepackage{wrapfig} \n\\begin{document}";

var tex_page = '\\begin{wrapfigure}{c}{150mm}     \n\\vspace{-1pt}    \n\\includegraphics[height=150px]{$image}   \n\\caption{$title}   \n\\hspace{-20pt}\n\\end{wrapfigure}\n\n\\newpage\n';

var tex_foot = "\\end{document}";

$(document).ready(function() {

    $('#tex-head').val(tex_head);
    $('#tex-page').val(tex_page);
    $('#tex-foot').val(tex_foot);
    $('#sizex').val(5);
    $('#sizey').val(6);
    $('#num_boards').val(2);

    $('#book-link').hide();
    $('#pdf-preview').hide();
    $('#wait').hide();

    $(function() {
        $("#accordion").accordion({
            event: "mouseover",
            fillSpace: true
        });
    });
    $(function() {
        $("#accordionResizer").resizable({
            resize: function() {
                $("#accordion").accordion("resize");
            },
            minHeight: 40
        });
    });

});


function head() {
    return $('#tex-head').val();
}

function page() {
    return $('#tex-page').val();
}

function foot() {
    return $('#tex-foot').val();
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
        $.post( "generate.php", {head: head(), page: page(), foot: foot(), x:$('#sizex').val(), y:$('#sizey').val(), 
                                 num_boards: $('#num_boards').val(), id: req_id}, function(data){ 
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
