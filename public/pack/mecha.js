'use strict';

var Mecha = 
{

    tabTemplate: "<li style='position:relative;'> <span class='air air-top-left delete-tab' style='top:7px; left:7px;'><button class='btn btn-xs font-xs btn-default hover-transparent' onclick='Mecha.closeFileEditor(\"#{lbl}\");'><i class='fa fa-times'></i></button></span></span><a id='li-#{lbl}' href='#{href}'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #{label}</a></li>",

    tabCounter: 12,
    tabs: null,
    editors: {},
    default_theme: 'ace/theme/monokai',

    init: function()
    {
		if ($('#moe-login-form').length) {
			return;
		}
		
        Mecha.initTree();

        var tabs = $("#tabs2").tabs({
            activate: function(event, ui) {
                setTimeout(function(){
                if (!jQuery.isEmptyObject(Mecha.editors)) {
                    console.log(Mecha.getActiveEditorMode());
                    $('#ace-mode').val(Mecha.getActiveEditorMode());
                }
            }, 120);
            }
        });
        tabs.find( ".ui-tabs-nav" ).sortable({
            axis: "x",
            stop: function() {
                tabs.tabs( "refresh" );
            }
        });
        Mecha.tabs = tabs;


        $(function(){
          $("#moeditor").resizableColumns({
            store: window.store
          });
        });

        //$('select', '#moeditor-controls').select2();

        $("#moeditor").resizable({
            stop: function( event, ui ) {
                setTimeout(function(){
                    $('.example').height($("#moeditor").height() -60).css('overflow', 'auto'); 
                    $('.ace_editor').height($("#moeditor").height() - 112);
                    //Mecha.getActiveEditor().resize(true);
                    $.each(Mecha.editors, function(i) {
                        this.editor.resize(true);
                    });
                }, 200);
            },
            start: function( event, ui ) {
                $('.example').css('height', '55px').css('overflow', 'hidden'); 
                $('.ace_editor').css('height', '20px'); 
            } 
        });

        Mecha.initHotkeys();
    }, // end init

    initHotkeys: function()
    {
        $('.ace_editor').unbind('keydown');
        $('.ace_editor').bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    Mecha.saveFile();
                    break;
                case 'f':
                    event.preventDefault();
                    alert('search will be later');
                    break;
                }
            }
        });
    }, // end 

    initTree: function()
    {
        $('#moe-tree').fileTree(
            { 
                root: '/', 
                script: '/moe/tree/connector',
                expandSpeed: 1, 
                collapseSpeed: 1
            }, 
            function(file, context) { 
                Mecha.openFile(context, file);
            }
        );
    }, // end initTree

    changeLayoutTheme: function(context, theme)
    {
        $('a', '.layout-themes').removeClass('active');
        $(context).addClass('active');

        var $tree = $('.tree-td')
        $.each(['bright', 'grey', 'dark'], function(i) {
            $tree.removeClass('tree-'+ this);
        });
        $tree.addClass('tree-'+ theme);
    }, // end changeLayoutTheme

    doChangeEditorTheme: function()
    {
        var theme = $('#ace-theme').val();
        Mecha.default_theme = theme;

        $.each(Mecha.editors, function(i) {
            this.editor.setTheme(theme);
        });
    }, // end doChangeEditorTheme

    doChangeEditorMode: function()
    {
        var mode = $('#ace-mode').val();
        Mecha.getActiveEditor().session.setMode(mode);
        Mecha.doUpdateEditorMode(mode);
    }, // end doChangeEditorMode

    closeFileEditor: function(id)
    {
        delete Mecha.editors[id];

        $('#'+ id).remove();
        $('#li-'+ id).parent().remove();

        Mecha.tabs.tabs("refresh");
    }, // end closeFileEditor

    openFile: function(context, path)
    {
        jQuery.ajax({
            url: '/moe/file/open',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { path: path },
            success: function(response) {
                console.log(response);
                
                if (response.status) {
                    Mecha.appendTab(response.content, $(context).text(), path, response.filehash);
                } else {
                }
            }
        });
    }, // end openFile

    saveFile: function()
    {
        var ace = Mecha.getActiveTabOptions();
        if (!ace) {
            toastr.info('Nothing to save');
            return false;
        }

        jQuery.ajax({
            url: '/moe/file/save',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { 
                content: ace.editor.getValue(),
                path: ace.path,
                filehash: ace.filehash
            },
            success: function(response) {
                console.log(response);
                
                if (response.status) {
                    Mecha.doUpdateEditorHash(response.filehash);
                    toastr.success('File saved', '');
                } else {
                    toastr.error('Already changed by someone else', '');
                }
            }
        });
    }, // end openFile

    refreshTree: function(context)
    {
        $(context).find('i').addClass('fa-spin');

        jQuery.ajax({
            url: '/moe/tree/connector',
            type: 'POST',
            cache: false,
            data: { dir: '/' },
            success: function(response) {

                
                $('#moe-tree').html(response);
                Mecha.initTree();

                toastr.success('Tree refreshed', '');
                $(context).find('i').removeClass('fa-spin');
            }
        });
    }, // end refreshTree

    getActiveTabOptions: function()
    {
        return Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')]
    }, // end getActiveTabOptions

    doUpdateEditorHash: function(filehash)
    {
        // FIXME: do not relate to active
        Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')].filehash = filehash;
    }, // end doUpdateEditorHash

    doUpdateEditorMode: function(mode)
    {
        // FIXME: do not relate to active
        Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')].mode = mode;
    }, // end doUpdateEditorMode

    getActiveEditor: function()
    {
        return Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')].editor;
    }, // end getActiveEditor

    getActiveEditorFilePath: function()
    {
        return Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')].path;
    }, // end getActiveEditorFilePath

    getActiveEditorMode: function()
    {
        return Mecha.editors[$($('#tabs2>div')[$("#tabs2").tabs('option', 'active')]).attr('id')].mode;
    }, // end getActiveEditorMode

    appendTab: function(content, label, filePath, filehash)
    {
        var id = "tabs-" + Mecha.tabCounter, 
            li = $(Mecha.tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label).replace(/#\{lbl\}/g, id));

        Mecha.tabs.find(".ui-tabs-nav").append(li);
        Mecha.tabs.append("<div id='" + id + "'><textarea id='e-" + id + "'>" + '' + "</textarea></div>");
        Mecha.tabs.tabs("refresh");
        Mecha.tabs.find( ".ui-tabs-nav" ).sortable({
            axis: "x",
            stop: function() {
                Mecha.tabs.tabs( "refresh" );
            }
        });

        Mecha.tabCounter++;

        $('#li-'+id).trigger('click');
        //console.log(id);
        //setTimeout(function(){$('#li-'+id).trigger('click');}, 2200);

        var editor = ace.edit('e-'+id);
        editor.setTheme(Mecha.default_theme);
        //editor.getSession().setMode("ace/mode/"+type);
        editor.getSession().setUseSoftTabs(true);
        editor.getSession().setNewLineMode("unix");

        var modelist = ace.require('ace/ext/modelist');
        var mode = modelist.getModeForPath(filePath).mode;
        editor.session.setMode(mode);
        editor.setValue(content, -1);

        Mecha.editors[id] = {
            editor: editor,
            path: filePath,
            filehash: filehash,
            mode: mode
        };

        $('#ace-mode').val(mode);

        $('.ace_editor').height($("#moeditor").height() - 112);
        Mecha.getActiveEditor().resize(true); 

        Mecha.initHotkeys();
    }, // end appendTab

    doAuth: function()
    {
        jQuery.ajax({
            url: '/moe/auth/check',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: $('#moe-login-form').serializeArray(),
            success: function(response) {
                console.log(response);
                
                if (response.status) {
                    $('#moe-login').replaceWith(response.editor);
                    Mecha.init();
                } else {
                    toastr.error('Oops!! HAHAHAHAHAHAGAHAHAA');
                }
            }
        });
    }, // end doAuth

    doFullscreen: function()
    {
        if ($('#moe-wrapper').hasClass('moe-fullscreen')) {
            $('#moe-wrapper').removeClass('moe-fullscreen');

            $('.example').css('height', '55px').css('overflow', 'hidden'); 
            $('.ace_editor').css('height', '20px'); 
            $("#moeditor").height($("#moeditor").attr('dataheight'));

        } else {
            $("#moeditor").attr('dataheight', $("#moeditor").height());
            $('#moe-wrapper').addClass('moe-fullscreen');
            $("#moeditor").height($(window).height());
        }

        setTimeout(function(){
            $('.example').height($("#moeditor").height() -60).css('overflow', 'auto'); 
            $('.ace_editor').height($("#moeditor").height() - 112);
            $.each(Mecha.editors, function(i) {
                this.editor.resize(true);
            });
        }, 50);
    }, // end doFullscreen

};



jQuery(document).ready(function(){
    Mecha.init();
});