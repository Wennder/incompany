/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        //DATA FILTERING
        config.allowedContent = true;
        
        //TOOL BAR
        config.toolbar = 'Full';
        
        config.toolbar_Full =
        [
                { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
                { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
                'HiddenField' ] },
                '/',
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
                { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
                '/',
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                { name: 'colors', items : [ 'TextColor','BGColor' ] },
                { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
        ];
        
        config.toolbar_Email =
        [
                { name: 'document', items : [ 'Source','-','NewPage','DocProps','Preview','Print','-','Templates' ] },
                { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                { name: 'editing', items : [ 'SelectAll','-','SpellChecker', 'Scayt' ] },
                '/',
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote',
                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
                { name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak'] },
                '/',
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                { name: 'colors', items : [ 'TextColor','BGColor' ] },
                { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
        ];

        config.toolbar_Basic =
        [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];
};
