/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* ark_file_upload_handler.js
*
* this is the js file that handles file uploads called from within sf_mediabrowser.php
*
* Javascript > 1.7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2009  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category   base
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/js/ark_file_upload_handler.js
* @since      File available since Release 1.1
*
* Markup needed by this script needs to be supplied to it by the page that calls it.
* See also mkJsMarkup() in global_functions
*
*/

// DEV NOTE: Move this to js_funtions GH 8/12/12
// DEV NOTE: remove hard coded paths
// create the function to create the nice view for the register
function formatFilesRegister(file, filename, crunched) {
    parent.document.getElementById('mb_fileform').value = parent.document.getElementById('mb_fileform').value + ' ' + file;
    if (crunched == true) {
        //we have a thumbnail so include it
        thumb = '<img src=\"data/files/arkthumb_' + file + '\" alt=\"file_image\"/></a>';
    } else {
        thumb = '<img src=' + phpvars.skin_path + 'images/results/thumb_default.png\" alt=\"icon\" class=\"icon\" title=\"' + filename + '\"/>';
    }
    file_list = '<li class="file_list">'+ thumb + '<a target=\"\" href=\"data/files/webthumb_' + file + '.jpg\" alt=\"' + filename + '\" title=\"' + filename + '\">' + filename + '</a></li>';
    jQuery(parent.document.getElementById('mb_file_list')).append(file_list);
}

jQuery(document).ready(function(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        // path to server-side upload script
        action: 'lib/js/valums-fileuploader/server/ark_file_processor.php',
        params: {
            upload_dir: phpvars.upload_dir_plus_trailing_slash,
            filesize_limit: phpvars.filesize_limit
        },
        onComplete: function(id, fileName, responseJSON){
            // upload is OK and then send off to be processed and thumbed etc.
            if (responseJSON.success){
                // get the element containing the filename and insert an element to let the user know
                // it is being processed/thumbed
                jQuery('span').each(function(index) {
                    if(jQuery(this).text()==fileName) {
                        filename_elem = jQuery(this);
                        filename_elem.text(fileName + markup.mk_beingthumbed);
                        jQuery('<span class="qq-upload-spinner">&nbsp;</span>').insertAfter(filename_elem);
                    }
                });
                // now run the process asynchronously and give appropriate feedback
                jQuery.ajax({
                    url:    ajax.ajax_url + '&filename=' + fileName,
                    success: function(result) {
                        // parse the results JSON array
                        var result_obj = jQuery.parseJSON(result);
                        console.log (result_obj);
                        // examine the results and respond to the user
                        if ('setup' in result_obj) {
                            // an admin error has occured
                            // the ajax has returned an error, provide feedback
                            console.log ("ADMIN ERROR (see object below):");
                            console.log (result_obj);
                            filename_elem.text(fileName + ' ' + markup.mk_uploadfailureadmin);
                            jQuery(filename_elem).next().remove();
                            return 0;
                        };
                        if ('err' in result_obj) {
                            // the ajax has returned an error, provide feedback
                            filename_elem.text(fileName + ' ' + markup.mk_uploadfailure + result_obj.process.lut.results.error);
                            jQuery(filename_elem).next().remove();
                        } else {
                            if ('process' in result_obj) {
                                if (result_obj.process.lut.results.success == 1) {
                                    // check if the file has been linked
                                    if (result_obj.linked == 1) {
                                        linkedtext = ' ' + markup.mk_linksuccess + ' ' + markup.mk_keyval_pair;
                                    } else if (result_obj.linked == 'register') {
                                        if (result_obj.crunch.arkthumb !== undefined){
                                            crunched = true;
                                        } else {
                                            crunched = false;
                                        }
                                        formatFilesRegister(result_obj.process.lut.results.new_id, fileName, crunched);
                                        linkedtext = ' ' + markup.mk_linksuccess;
                                    } else {
                                        linkedtext = '';
                                    }
                                    // check if the file has been crunched as well
                                    if (result_obj.crunch.arkthumb !== undefined) {
                                        filename_elem.text(fileName + ' ' + markup.mk_uploadsuccess + linkedtext);
                                        jQuery(filename_elem).next().remove();
                                    } else {
                                        // examine the results
                                        var fback = 0;
                                        if ('convertible' in result_obj.crunch) {
                                            fback = result_obj.crunch.convertible;
                                            if ('err' in result_obj.crunch.conversion) {
                                                fback = fback + ' - ' + result_obj.crunch.conversion.err;
                                            };
                                        };
                                        filename_elem.text(fileName + ' ' + markup.mk_uploadsuccessnocrunch + ' [error= ' + fback + ']' + linkedtext);
                                        jQuery(filename_elem).next().remove();
                                    }
                                }
                            }
                        }
                    },
                    async: true
                });
            } else {
                console.log ("Response from valums file uploader was not valid JSON");
            }
        }
    });
});