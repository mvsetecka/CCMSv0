/**
 * acronym.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

function init() {
	SXE.initElementDialog('pre');
	if (SXE.currentAction == "update") {
		SXE.showRemoveButton();
	}
}

function insertAcronym() {
	SXE.insertElement('pre');
	tinyMCEPopup.close();
}

function removeAcronym() {
	SXE.removeElement('pre');
	tinyMCEPopup.close();
}

tinyMCEPopup.onInit.add(init);
