
function editAreaLoaded(id) {
    if (id==="editor") {
        load_book();
    }
}


$(document).ready(function() {

    editAreaLoader.init({
        id: "editor" // id of the textarea to transform
        ,start_highlight: true  // if start with highlight
        ,allow_resize: "both"
        ,allow_toggle: false
        ,toolbar: " search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight, |, help"
        ,is_multi_files: true
        ,language: "en"
        ,EA_load_callback: "editAreaLoaded"
    });


    $('#log').val("");
    $('#book-link').hide();
    $('#pdf-preview').hide();
    $('#wait').hide();

});

function load_book( req_id ) {
        if (!req_id) req_id = "testbook";

        $.getJSON("loadbook.php", {id:req_id}, function(data) {
            var js_file = {id: "b_javascript", text: data['book']['javascript'] , syntax: 'js', title: 'javascript'};
            editAreaLoader.openFile('editor', js_file);

            jQuery.each( data['book']['tmpls'], function(i, val) {
                var block = {id: 'b_'+val['name'], text: val['value'], syntex: 'basic', title: val['name']};
                editAreaLoader.openFile('editor', block);
            });

            editAreaLoader.openFile('editor', js_file);
        });
}

function save_book( req_id ) {
    if (!req_id) {
        alert('you have to give it a name.');
        return;
    }
    var post_req = new Object;
    jQuery.each( editAreaLoader.getAllFiles('editor'), function(i, val) {
        post_req['@'+val.title] = val.text;
    });
    post_req['id'] = req_id;
    $.post( "save.php", post_req, function(data){
        alert('document saved');
    });
}


$(document).ready(function() {

    $('#hide-intro').show().click(function() {
        $('#intro').hide("slow");
        $('#hide-intro').hide()
        $('#show-intro').show()
    });
    $('#show-intro').hide().click(function() {
        $('#intro').show("slow");
        $('#hide-intro').show()
        $('#show-intro').hide()
    });

    $('#log').hide();
    $('#show-hide-log').click(function() {
        if ($('#show-hide-log').html()=='+') {
            $('#log').show('slow');
            $('#show-hide-log').empty();
        }
    });

    $('#load').click(function() {
        load_book( $('#book_id').val() );
    });

    $('#save').click(function() {
        save_book( $('#book_id').val() );
    });

    $('#generate').click(function() {
//        var req_id = Math.floor(Math.random()*10000000);
        var req_id = $('#book_id').val() ;
        var md5_id = md5(req_id);
        $('#book-link').hide("fast");
        $('#pdf-preview').hide("fast");
        $('#hide-intro').click();
        $('#log').empty().val("");
        $('.media').empty();
        $('#wait').show();

        var post_req = new Object;
        jQuery.each( editAreaLoader.getAllFiles('editor'), function(i, val) {
            post_req['@'+val.title] = val.text;
        });
        post_req['id'] = req_id;

        $.post( "generate.php", post_req, function(data){ 
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
                    $('#show-hide-log').click();
                    alert("The book is empty => the book does not exist");
                } else if (t1 !== -1) {
                    $('#show-hide-log').click();
                    alert("The book could not be generated due to LaTeX error(s). See the log for details.");
                }
            } );
    });

});
