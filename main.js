
var js_example =
"n = 3;\n" +
"\n" +
"$ += @header();\n" +
"\n" +
"for (i = 1; i < n; i++) {\n" +
"  name = generateName(i);\n" +
"  $ += @block_1( name );\n" +
"}\n" +
"\n" +
"$ += @footer();\n" +
"\n" +
"function generateName( i ) {\n" +
"   if (i % 2) return \"Ms. \" + i;\n" +
"   else return \"Mr. \" + i ;\n" +
"}\n" +
"";

var tex_head = "\\documentclass[a5paper]{memoir}\n\\usepackage{graphicx} \n\\usepackage{wrapfig} \n\\begin{document}";

var tex_page = '\\begin{wrapfigure}{c}{150mm}     \n\\vspace{-1pt}    \n\\includegraphics[height=150px]{$image}   \n\\caption{$title}   \n\\hspace{-20pt}\n\\end{wrapfigure}\n\n\\newpage\n';

var block_1_text = "Hello, my name is $name.\n";

var tex_foot = "\n\\end{document}";

function editAreaLoaded(id) {
    if (id==="js-code") {
        var js_file = {id: "javascript", text: js_example, syntax: 'js', title: 'javascript'};
        editAreaLoader.openFile('js-code', js_file);

        var header_file = {id: "header", text: tex_head, syntax: 'basic', title: 'header'};
        editAreaLoader.openFile('js-code', header_file);

        var block_1_file = {id: "block_1", text: block_1_text, syntax: 'basic', title: 'block_1'};
        editAreaLoader.openFile('js-code', block_1_file);

        var footer_file = {id: "footer", text: tex_foot, syntax: 'basic', title: 'footer'};
        editAreaLoader.openFile('js-code', footer_file);

        editAreaLoader.openFile('js-code', js_file);

    }
}


$(document).ready(function() {

    $('#js-code').val(js_example);
    $('#js-code').html(js_example);

    editAreaLoader.init({
        id: "js-code" // id of the textarea to transform
        ,start_highlight: true  // if start with highlight
        ,allow_resize: "both"
        ,allow_toggle: true
        ,toolbar: " new_document, save, load, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight, |, help"
        ,is_multi_files: true
        ,language: "en"
        ,EA_load_callback: "editAreaLoaded"
    });

    $('#tex-head').val(tex_head);
    $('#tex-foot').val(tex_foot);

    $('#sizex').val(5);
    $('#sizey').val(6);
    $('#num_boards').val(2);

    $('#log').val("");
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
        $('#log').empty().val("");
        $('.media').empty();
        $('#wait').show();
        $.post( "generate.php", {head: head(), page: page(), foot: foot(), x:$('#sizex').val(), y:$('#sizey').val(), 
                                 num_boards: $('#num_boards').val(), id: req_id}, function(data){ 

                $('#log').val(data);
                $('#wait').hide();
                $('#tex-link').attr("href", "cache/"+md5_id+"/book.tex");
                $('#img-link').attr("href", "cache/"+md5_id+"/book-images.tar.bz2");

                var t1 = data.indexOf("no output PDF file produced");
                var t2 = data.indexOf("Output written on");

                if (t1 === -1 && t2 !== -1) {
                    $('#book-link').show("fast");
                    $('#pdf-preview').show("fast");
                    $('#pdf-link').attr("href", "cache/"+md5_id+"/book.pdf");
                    $('#pdf-preview').attr("href", "cache/"+md5_id+"/book.pdf");
                    $('.media').media({width:290, height:425, src:"cache/"+md5_id+"/book.pdf"});
                } else if (t1 === -1 && t2 ===-1) {
                    alert("The book is empty => the book does not exist");
                } else if (t1 !== -1) {
                    alert("The book could not be generated due to LaTeX error(s). See the log for details.");
                }
            } );
    });

});
