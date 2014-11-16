(function ($, Drupal, CodeMirror) {

    Drupal.behaviors.atuiDisplayFile = {
        attach: function () {
            var editor = CodeMirror.fromTextArea(document.getElementById("edit-code"), {
                lineNumbers: true
                , viewportMargin: Infinity
                , readOnly: true
                , theme: "monokai"
                , mode: "text/javascript"
            });
        }
    };

})(jQuery, Drupal, CodeMirror);
