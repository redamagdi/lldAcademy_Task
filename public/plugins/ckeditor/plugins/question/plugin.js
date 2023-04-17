CKEDITOR.plugins.add( 'question', {
    icons: 'question',
    init: function( editor ) {
        editor.addCommand( 'insertQuestion', {
            exec: function( editor ) {
                // var itrator = $('#qitartor').val();
                // itrator = +itrator+1;
                // var htmlEl      = "<codesnipit#/&> <input type='hidden' name='itratornummmmm"+itrator+"' value='"+itrator+"'/>  <lable> ادخل السؤال  </lable>";
                //     htmlEl      += "<input type='text' required name='qestionText"+itrator+"'> | ";
                //     htmlEl      += "<lable>ادخل ألاجابه الصحيحة لهذا السؤال  </lable>";
                //     htmlEl      += "<input type='text' required name='answerText"+itrator+"'>  </codesnipit#/&>";
                // editor.insertHtml(htmlEl);
                // $('#qitartor').val(itrator);
                $("#addNew").modal("show");

            }
        });
        editor.ui.addButton( 'Question', {
            label: 'اضف سؤال',
            command: 'insertQuestion',
            toolbar: 'question'
        });
    }
});