(function($){
    $.fn.dialogForm = function(options) {
        var defaults = {
            dialogId: '',
            formId: '',
            gridId: ''
        };

        var options = $.extend(defaults, options);
        var dialog = $('#'+options.dialogId);

        function refreshGrid(){
            $.fn.yiiGridView.update(options.gridId);
        }

        return this.each(function(){
            var link = $(this);
            link.click(function(){
                $.get(link.attr('href'), function(html){
                    function bindFormSubmit() {
                        $('#'+options.formId, dialog).submit(function(){
                            var form = $(this);
                            $.post(form.attr('action'), form.serialize(), function(html){
                                dialog.html(html);
                                bindFormSubmit();
                                refreshGrid();
                            });
                            return false;
                        });
                    }
                    dialog.html(html);
                    dialog.dialog('option', 'title', link.attr('alt'));
                    bindFormSubmit();
                    dialog.dialog('open');
                });
                return false;
            });
        });
    }
})(jQuery);

