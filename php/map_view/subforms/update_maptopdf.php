<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/update_exportdownload.php
*
* process script for creating a download (paired with a subform)
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2008  L - P : Partnership Ltd.
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
* @category   subforms
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/update_exportdownload.php
* @since      File available since Release 0.8
*
* This is the companion update script that goes with the sf_exportdownload.php
* subform. This Subform is expected to be used in an overlay, but could be adjusted
* to work as a standard sf if needed. The user interface and feedback are handled by
* the sf itself.
*
* This update can be used to process a results array into any file format, but
* this export to file is performed by an export function in the export_functions.php
* file. The requested $dl_mode must therefore match an existing function.
*
* As of v0.8 the only function is exportCSV.php (function calls are not case
* sensitive).
*
* This script needs a results array to be made available to it. It expects this
* to be live and called 'results_array'.
*
* Fields and other setup should be made available in the sf_conf itself. See the SF
* for further notes.
*
*/

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
}

// start timing the script (see below for further notes)
$time_start = microtime(true);

// Markup
$mk_problem_item = getMarkup('cor_tbl_markup', $lang, 'problem_item');
$mk_problem_string = getMarkup('cor_tbl_markup', $lang, 'problem_string');

//start setting up the various variables

//set the paper size and dpi
if ($expsize == 'A4'){

    $pwidth = 210.0;
    $pheight = 297.0;
    $parray = array ($pwidth,$pheight);

    $titlefontsize = 6;
    $merlinmsgfontsize = 6;

    $imagex = 9.23;
    $imagey = 9.75;
    $imagesx = 257.30;
    $imagesy = 192;

    $framex = 9.23;
    $framey = 9.75;
    $framesx = 257.30;
    $framesy = 192.9;

    $titlex = 268.02;
    $titley = 11.19;
    $titlesx = 24.73;
    $titlesy = 2.85;

    $legx = $titlex;
    $legy = $titley + $titlesy + 20;
    $legsx = $titlesx;

    $northarrowx = $titlex;
    $northarrowy = 177.30;
    $northarrowsx = 7.09;

    $scalex = $titlex;
    $scaley = 190.02;
    $scalesx = $titlesx;

    $logox = $titlex;
    $logoy = 197.49;
    $logosx = $titlesx;

    $merlinmsgx = 9.57;
    $merlinmsgy = 12.76;
    $merlinmsgsx = 257.03;
    $merlinmsgsy = 0.17;

    if ($exdpi == '150'){

        $nwidth = 1519;
        $nheight= 1139;

        $legnwidth = 111;
        $scalewidth = 111;
        $logowidth = 111;
        $northarrowwidth = 41.84;

    }
  
    if ($exdpi == '300'){

        $nwidth = 3038;
        $nheight= 2278;

        $legnwidth = 222;
        $scalewidth = 222;
        $logowidth = 222;
        $northarrowwidth = 84;

    }

    if ($exdpi == '600'){

        $nwidth = 6077;
        $nheight= 4557;

        $legnwidth = 444;
        $scalewidth = 444;
        $logowidth = 444;
        $northarrowwidth = 165;
    }
}

if ($expsize == 'A3'){

    $pwidth = 297.0;
    $pheight = 420.0;
    $parray = array ($pwidth,$pheight);

    $titlefontsize = 12;
    $merlinmsgfontsize = 8;
    $oslicfontsize = 6;

    $imagex = 13.02;
    $imagey = 13.75;
    $imagesx = 362.8;
    $imagesy = 272;

    $framex = 13.02;
    $framey = 13.75;
    $framesx = 362.8;
    $framesy = 272;

    $titlex = 377.92;
    $titley = 15.78;
    $titlesx = 34.88;
    $titlesy = 4.02;

    $legx = $titlex;
    $legy = $titley + $titlesy + 20;
    $legsx = $titlesx;

    $northarrowx = $titlex;
    $northarrowy = 210;
    $northarrowsx = 10;

    $scalex = $titlex;
    $scaley = 227.93;
    $scalesx = $titlesx;
    $scalesy = 0;

    $logox = $titlex;
    $logoy = 278.47;
    $logosx = $titlesx;

    $merlinmsgx = 13.5;
    $merlinmsgy = 18;
    $merlinmsgsx = 362.8;
    $merlinmsgsy = 0.25;

    $projectx = $titlex;
    $projecty = 235;
    $projectsx = $titlesx;
    $projectsy = 4;

    $clientx = $titlex;
    $clienty = 245;
    $clientsx = $titlesx;
    $clientsy = 4;

    $oslicx = $titlex;
    $oslicy = 255;
    $oslicsx = $titlesx;
    $oslicsy = 4;

    if ($exdpi == '150'){

        $nwidth = 2142;
        $nheight= 1606;

        $legnwidth = 157;
        $scalewidth = 157;
        $logowidth = 157;
        $northarrowwidth = 59;

    }
  
    if ($exdpi == '300'){

        $nwidth = 4284;
        $nheight= 3212;

        $legnwidth = 313;
        $scalewidth = 313;
        $logowidth = 313;
        $northarrowwidth = 118;

    }

    if ($exdpi == '600'){

        $nwidth = 8568;
        $nheight= 6424;

        $legnwidth = 626;
        $scalewidth = 626;
        $logowidth = 626;
        $northarrowwidth = 232;
    }

}

if ($expsize == 'A0'){

    $pwidth = 841.0;
    $pheight = 1189.0;
    $parray = array ($pwidth,$pheight);

    $titlefontsize = 24;
    $merlinmsgfontsize = 16;
    $oslicfontsize = 8;

    $imagex = 36.74;
    $imagey = 38.9;
    $imagesx = 1027.2;
    $imagesy = 772.6;

    $framex = 36.7;
    $framey = 38.9;
    $framesx = 1027.2;
    $framesy = 772.6;

    $titlex = 1070;
    $titley = 44.6;
    $titlesx = 98.8;
    $titlesy = 22.7;

    $legx = $titlex;
    $legy = $titley + $titlesy + 20;
    $legsx = $titlesx;

    $northarrowx = $titlex;
    $northarrowy = 675;
    $northarrowsx = 30;

    $scalex = $titlex;
    $scaley = 713.63;
    $scalesx = $titlesx;
    $scalesy = '';

    $logox = $titlex;
    $logoy = 791.01;
    $logosx = $titlesx;

    $merlinmsgx = 37;
    $merlinmsgy = 41;
    $merlinmsgsx = 1027.2;
    $merlinmsgsy = 0.25;

    $projectx = $titlex;
    $projecty = 725;
    $projectsx = $titlesx;
    $projectsy = 4;

    $clientx = $titlex;
    $clienty = 740;
    $clientsx = $titlesx;
    $clientsy = 4;

    $oslicx = $titlex;
    $oslicy = 755;
    $oslicsx = $titlesx;
    $oslicsy = 4;


    if ($exdpi == '150'){

        $nwidth = 6066;
        $nheight= 4562;

        $legnwidth = 583;
        $scalewidth = 583;
        $logowidth = 583;
        $northarrowwidth = 177;

    } 

    if ($exdpi == '300'){

        $nwidth = 12132;
        $nheight= 9125;

        $legnwidth = 1166;
        $scalewidth = 1166;
        $logowidth = 1166;
        $northarrowwidth = 354;

    } 

    if ($exdpi == '600'){

        $nwidth = 24264;
        $nheight= 18248;

        $legnwidth = 2332;
        $scalewidth = 2332;
        $logowidth = 2332;
        $northarrowwidth = 708;
    }
}


// ---- PROCESS ---- //

//this is where we start processing and making the PDF itself

//choose the right north arrow image
$north_arrow_url = "$ark_server_path/skins/$skin/images/legend/northarrow.png";

//set up the logo
$logo_url = "$ark_server_path/skins/$skin/images/logo.png";

//set the Merlin Message (DEV NOTE: This can be built later using drawing numbers etc.)
$merlinmsg = 'This map was created using ARK';

//Set the OS License and project names
//$oslic = 'Note: Reproduced from Ordnance Survey material by permission of the controller of HMSO, Licence number XXXXXXXX';
//$project = 'Project: North Harlow Development';
//$client = 'Client: North Harlow Joint Venture';

//draw the actual map image using the tiling

$number_of_tiles = 3;

//get the current geographic extents
  
$extents = explode(',',$extents);

$geo_minx = $extents[0];
$geo_maxx = $extents[2];
$geo_miny = $extents[1];
$geo_maxy = $extents[3];

$geo_length = $geo_maxx - $geo_minx;

$tile_geo_length = $geo_length/$number_of_tiles;

//get the image dimensions (on paper)

$tile_image_length = $imagesx/$number_of_tiles;

$new_maxx = $geo_minx+$tile_geo_length;
$tile_extent = "$geo_minx,$geo_miny,$new_maxx,$geo_maxy";
$tile_extent_array['minx'] = $geo_minx;
$tile_extent_array['miny'] = $geo_miny;
$tile_extent_array['maxx'] = $new_maxx;
$tile_extent_array['maxy'] = $geo_maxy;

$nwidth = ($tile_image_length/25.4) * $exdpi;
$nheight = ($imagesy/25.4) * $exdpi;

//get the tile itself

$url1 = $wms_url ."&BBOX=$tile_extent&WIDTH=$nwidth&HEIGHT=$nheight";

$imagex1 = $imagex;

$old_imagex = $imagex1;

// set the tile number to be incremented later

$tile_number = 2;

//change the mapObj for the other tiles

while ($tile_number <= 3 ){

    $geo_minx = $tile_extent_array['minx'];
    $geo_maxx = $tile_extent_array['maxx'];


    $new_maxx = $geo_maxx+$tile_geo_length;
    $tile_extent = "$geo_maxx,$geo_miny,$new_maxx,$geo_maxy";
    $tile_extent_array['minx'] = $geo_maxx;
    $tile_extent_array['miny'] = $geo_miny;
    $tile_extent_array['maxx'] = $new_maxx;
    $tile_extent_array['maxy'] = $geo_maxy;

    //$img = $map->draw();
    $url = $wms_url ."&BBOX=$tile_extent&WIDTH=$nwidth&HEIGHT=$nheight";

    $imagex2 = $old_imagex + $tile_image_length;
    $old_imagex = $imagex2;

    $tile_array[$tile_number] =  array('url' => $url, 'imagex' => $imagex2);

    $tile_number++;

}

// set up a file name and path
$orig_file = tempnam($export_dir, 'mapToPDF');
if (!file_exists($orig_file)) {
    echo "ADMIN ERROR: Unable to create file on directory: '$export_dir'<br/>";
}
$file = $orig_file.'.pdf';
if (!is_writable($export_dir)) {
    echo "ADMIN ERROR: trying to write to $export_dir failing - therefore actually writing to $file (this download will still work)\n";
}
//start the construction of the PDF

//create a new pdf object and a new page

$pdf=new PDF_ImageAlpha('L','mm',$parray);
$pdf->AddPage();

//set the font for the title text

$pdf->SetFont('Arial','B',$titlefontsize);

//insert the first tile
$pdf->Image($url1,$imagex1,$imagey,$tile_image_length,$imagesy,'PNG');

//loop through the tiles and place them all

foreach ($tile_array as $tile_no) {

    $pdf->Image($tile_no["url"],$tile_no["imagex"],$imagey,$tile_image_length,$imagesy,'PNG');

}

//insert the legend

//$pdf->Image($leg_url,$legx,$legy,$legsx);

//insert the scalebar

$pdf->SetFont('Arial','',$merlinmsgfontsize);
$pdf->SetXY($scalex,$scaley);
$pdf->MultiCell($scalesx,$scalesy,$scale_text,0,'L');

//$pdf->Image($scale_url,$scalex,$scaley,$scalesx);

//draw the border

$pdf->Rect($framex,$framey,$framesx,$framesy,'D');

//draw the north arrow

$pdf->Image($north_arrow_url,$northarrowx,$northarrowy,$northarrowsx);

//draw the logo

$pdf->Image($logo_url,$logox,$logoy,$logosx);

//Write the title text

$pdf->SetFont('Arial','',$titlefontsize);
$pdf->SetXY($titlex,$titley);
$pdf->MultiCell($titlesx,$titlesy,$title,0,'L');

//Write the merlinmsg text

$pdf->SetFont('Arial','',$merlinmsgfontsize);
$pdf->SetXY($merlinmsgx,$merlinmsgy);
$pdf->MultiCell($merlinmsgsx,$merlinmsgsy,$merlinmsg,0,'L');

/*//Write the Project name text

$pdf->SetFont('Arial','',$merlinmsgfontsize);
$pdf->SetXY($projectx,$projecty);
$pdf->MultiCell($projectsx,$projectsy,$project,0,'L');

//Write the Client text

$pdf->SetFont('Arial','',$merlinmsgfontsize);
$pdf->SetXY($clientx,$clienty);
$pdf->MultiCell($clientsx,$clientsy,$client,0,'L');

//Write the OS license text

$pdf->SetFont('Arial','',$oslicfontsize);
$pdf->SetXY($oslicx,$oslicy);
$pdf->MultiCell($oslicsx,$oslicsy,$oslic,0,'L');
*/
//actually create the file
$pdf->Output("$file", 'F');

//set the php ini values back to defaults

ini_restore('memory_limit');
ini_restore('max_execution_time');

if (file_exists($file)) {
    $dl['file'] = $file;
}

// errors and messages are returned in an array
// detect this and handle the output as appropriate
if (is_array($dl)) {
    if (array_key_exists('error', $dl)) {
        $error[]['vars'] = $dl['error'];
    }
    if (array_key_exists('message', $dl)) {
        $msg = $dl['message'][0];
        $message[] = $msg['vars'];
        $message[] = "$mk_problem_item: {$msg['problem_key']} - {$msg['problem_val']}";
        $message[] = "$mk_problem_string: '{$msg['problem_string']}'";
        $dl = $dl['file'];
    }
}

// if the $dl is done and we don't have errors then set a flag to
// put the 
if ($dl && !$error) {
    $dl_success = TRUE;
}

// we want the script to run for a minimum time
$target_time = 5; // in seconds
// find out how long the script took
$time_end = microtime(true);
$time = $time_end - $time_start;
// find out how much time remains (or not)
$leftover_time = $target_time - $time;
if ($leftover_time > 0) {
    // sleep for the rest of the time
    sleep($leftover_time);
}


?>
