<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* create_png.php
*
* this file can be used to dynamically create a coloured png for a legend
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/skins/arkologick/create_png.php
* @since      File available since Release 0.8
*/
header('Content-type: image/png');

include('../../../config/settings.php');
include('../../../php/global_functions.php');
//we need to get the correct skin_path - as this is a standalone file talking to the server we need to futz a bit
$expl_skin_path = explode('skins', $skin_path);
$skin_path = '/' . $ark_server_path . '/skins' . $expl_skin_path[1];
//script to output a png (after headers have been sent)
//this script can be used as the src in an <img> tag

$r =  reqQst($_REQUEST,'r');
$g =  reqQst($_REQUEST,'g');
$b =  reqQst($_REQUEST,'b');
$type =  reqQst($_REQUEST,'type');

if ($type == 1) {

 $im_file = $skin_path. "/images/legend/line.png";

}

if ($type == 2) {

 // $im_file = "../../../ark/skins/arkologik/images/legend/poly.png";
  $im_file = $skin_path . "/images/legend/poly.png";


}

if ($type == 3) {

  //$im_file = "../../../ark/skins/arkologik/images/legend/raster.png";
  $im_file = $skin_path . "/images/legend/raster.png";


}

if ($type == 4) {

 // $im_file = "../../../ark/skins/arkologik/images/legend/poly.png";
  $im_file = $skin_path . "/images/legend/poly.png";


}

if ($type == 0) {

 // $im_file = "../../../ark/skins/arkologik/images/legend/point.png";
 $im_file = $skin_path . "/images/legend/point.png";


}

if ($type == 5) {

  $im_file = $marker_dynamic_icon_path;

}

//then create the image resource

  $im = imagecreatefrompng($im_file);

//grab the size of the image

  $imagesizearray[] = getimagesize($im_file);
  $w = $imagesizearray[0];
  //$h = $imagesizearray[1];

//make a blank png to be merged

$im2 = imagecreatetruecolor($w[0],$w[1]);

//get the colour and set the background but
//catch the raster geometry type as that has no colour values
//set the values to be grey

$im_color = ImageColorAllocate( $im2, $r, $g, $b ); 
imagefill($im2,0,0,$im_color);

//make sure the alpha blending is set to ensure the transparency

imagealphablending($im, 1);
imagealphablending($im2, 1);

//merge the images

imagecopy($im2, $im, 0,0,0,0,16,16);

//output the final png

imagepng($im2);

//clean up

imagedestroy($im);
imagedestroy($im2);
?>