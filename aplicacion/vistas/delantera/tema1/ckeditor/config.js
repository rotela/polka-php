/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	$DOMINIO='http://localhost/polka/aplicacion/vistas/delantera/tema1';
	config.filebrowserBrowseUrl      = $DOMINIO+'/kcfinder/browse.php';
	config.filebrowserImageBrowseUrl = $DOMINIO+'/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = $DOMINIO+'/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl      = $DOMINIO+'/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = $DOMINIO+'/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = $DOMINIO+'/kcfinder/upload.php?type=flash';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
