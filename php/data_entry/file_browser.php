<?php
// This file has been edited by Stuart Eve (stuarteve@lparchaeology.com) for use within the Archaeological Recording Kit (ark.lparchaeology.com)
// This was checked during code-cleaning phase 17th November 2011 and deemed CLEAN - SJE/GH
/***************************************************************************
 *
 *             enCode eXplorer
 *
 *             Autor / Author : Marek Rei
 *
 *             Versioon / Version : 4.0
 *
 *             Viimati muudetud / Last change: 30.09.2007
 *
 *             Koduleht / Homepage: encode-explorer.siineiolekala.net
 *
 *             NB!: Kommentaarid on inglise keeles.
 *                  Seadistamiseks vajalikud kommentaarid on eesti ja inglise keeles.
 *                  Alates versioonist 4.0 on muutujate nimed inglise keeles.
 *
 *             NB!: Comments are in english.
 *                  Comments needed for configuring are in both estonian and english.
 *                  Starting from 4.0, variable names are in english.
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   EST: Tegemist on tasuta tarkvaraga. Seda levitatakse GPL litsentsi all.
 *
 *   Encode Explorer on kirjutatud lootuses, et sellest on inimestele kasu.
 *   Sellel puudub IGASUGUNE GARANTII ja seda kasutades ei vastuta autor 
 *   selle eesmärgipärase toimimise eest.
 *
 *   ENG: This is free software and it's distributed under GPL Licence.
 *
 *   Encode Explorer is written in the hopes that it can be useful to people.
 *   It has NO WARRANTY and when you use it, the author is not responsible
 *   for how it works (or doesn't).
 *
 ***************************************************************************/

/***************************************************************************/
/*   SIIN ON SEADED                                                        */
/*                                                                         */
/*   HERE ARE THE SETTINGS FOR CONFIGURATION                                */
/***************************************************************************/

//
// Vali sobiv keel. Vaikimisi: et
//
// Choose a language. Default: et
//

$lang = "en";

//
// Algkataloogi suhteline aadress. Reeglina ei ole vaja muuta. 
// Kasutage ainult suhtelisi alamkatalooge!
// Vaikimisi: .
//
// The starting directory.
// Use only relative subdirectories!
// Default: .
//

$starting_dir = $default_upload_dir;

//
// Kas failid avatakse uues aknas? 0=ei, 1=jah. Vaikimisi: 0
//
// Will the files be opened in a new window? 0=no, 1=yes. Default: 0
//
$open_in_new_window = 0;

//
// Maksimaalne konto suurus kilobaitides. Zone.ee tasuta serveriruumi jaoks 25600.
// 1MB = 1024KB. Vaikimisi: 25600
//
// The maximum allowed space in server (to calculate remaining space).
// 1MB = 1024KB. Default: 25600
//
$max_space = 25600;

//
// Kui sügavalt alamkataloogidest suurust näitav script faile otsib? Vaikimisi: 1
//
// How deep in subfilders will the script search for files? Default: 1
//
$dir_levels = 1;

//
// Kas kuvatakse lehe päis? 0=ei, 1=jah. Vaikimisi: 1
//
// Will the page header be displayed? 0=no, 1=yes. Default: 1
//
$show_top = 0;

//
// Kas index.php kuvatakse nimekirja? 0=ei, 1=jah. Vaikimisi: 0
//
// Will index.php be displayed on the list? 0=no, 1=yes. Default: 0
//
$show_index = 0;

//
// Kodeering, mida lehel kasutatakse. 
// Tuleb panna sobivaks, kui täpitähtedega tekib probleeme. Vaikimisi: UTF-8
//
// Charset. Use the one that suits for you. Default: UTF-8
//

$charset = "UTF-8";

//
// Olemasolevate ikoonide nimekiri.
//
// The list on available icons.
//
/*$icons = array("asp", "avi", "bmp", "chm", "css", "doc", "exe", "gif", "gz", "htm", "html", "jpg", "jpeg", "js", "jsp", "mov", "mp3", "mpeg", "mpg", "pdf", "php", "png", "ppt", "rar", "sql", "txt", "wav", "wmv", "xls", "xml", "xsl", "zip");*/

//
// Kaustade varjamine. Kaustanimesid saab juurde lisada. Näiteks
// $varjatud_kaustad = array("ikoonid", "kaustanimi", "teinekaust");
//
// The array of folders that will be hidden from the list.
//
$hidden_dirs = array();

//
// Failide varjamine. Failinimesid saab juurde lisada.
// NB! Märgitud nimega failid ja kaustad varjatakse kõigis alamkaustades.
//
// Filenames that will be hidden from the list.
//
$hidden_files = array(".ftpquota", "index.php");

//
// Parool failide uploadimiseks. Parooli märkimisega aktiviseerub ka uploadi võimalus.
// NB! Failide upload ei tööta zone.ee tasuta serveris ja hot.ee serveris!
// NB! Faile saab uploadida ainult kaustadesse, millele on eelnevalt antud vastavad õigused (chmod 777)
//
// Password for uploading files. You need to set the password to activate uploading.
// To upload into a directory it has to have proper rights.
//
$password = "";

//
// Asukoht serveris. Tavaliselt ei ole vaja siia midagi panna kuna script leiab ise õige asukoha. 
// Mõnes serveris tuleb piirangute tõttu see aadress ise teistsuguseks määrata.
// See fail peaks asuma serveris aadressil [AADRESS]/index.php
// Aadress võib olla näiteks "/www/data/www.minudomeen.ee/minunimi"
//
// Location in the server. Usually this does not have to be set manually.

$basedir = ""; // asukoht_serveris

//
// Tõlked
//
// Translations
//

$_TRANSLATIONS = array();

// Estonian
$_TRANSLATIONS["et"] = array(
    "file_name" => "Faili nimi",
    "size" => "Suurus",
    "last_changed" => "Viimati muudetud",
    "total_used_space" => "Kokku kasutatud",
    "free_space" => "Vaba ruumi",
    "password" => "Parool",
    "upload" => "Uploadi",
    "failed_upload" => "Faili ei &otilde;nnestunud serverisse laadida!",
    "failed_move" => "Faili ei &otilde;nnestunud &otilde;igesse kausta liigutada!",
    "wrong_password" => "Vale parool",
    "make_directory" => "Uus kaust",
    "new_dir_failed" => "Kausta loomine ebaõnnestus",
    "chmod_dir_failed" => "Kausta õiguste muutmine ebaõnnestus"
);

// English
$_TRANSLATIONS["en"] = array(
    "file_name" => "File name",
    "size" => "Size",
    "last_changed" => "Last changed",
    "total_used_space" => "Total used space",
    "free_space" => "Free space",
    "password" => "Password",
    "upload" => "Upload",
    "failed_upload" => "Failed to upload the file!",
    "failed_move" => "Failed to move the file into the right directory!",
    "wrong_password" => "Wrong password",
    "make_directory" => "New dir",
    "new_dir_failed" => "Failed to create directory",
    "chmod_dir_failed" => "Failed to change directory rights"
);

// Albanian
$_TRANSLATIONS["al"] = array(
    "file_name" => "Emri Skedarit",
    "size" => "Madhësia",
    "last_changed" => "Ndryshuar",
    "total_used_space" => "Memorija e përdorur total",
    "free_space" => "Memorija e lirë",
    "password" => "Fjalëkalimi",
    "upload" => "Ngarko skedarë",
    "failed_upload" => "Ngarkimi i skedarit dështoi!",
    "failed_move" => "Lëvizja e skedarit në udhëzuesin e saktë deshtoi!",
    "wrong_password" => "Fjalëkalimi i Gabuar!!",
    "make_directory" => "New dir",
    "new_dir_failed" => "Failed to create directory",
    "chmod_dir_failed" => "Failed to change directory rights"
);

// Spanish
$_TRANSLATIONS["es"] = array(
    "file_name" => "Nombre de archivo",
    "size" => "Medida",
    "last_changed" => "Ultima modificaciÃ³n",
    "total_used_space" => "Total espacio usado",
    "free_space" => "Espacio libre",
    "password" => "ContraseÃ±a",
    "upload" => "Subir el archivo",
    "failed_upload" => "Error al subir el archivo!",
    "failed_move" => "Error al mover el archivo al directorio seleccionado!",
    "wrong_password" => "ContraseÃ±a incorrecta",
    "make_directory" => "New dir",
    "new_dir_failed" => "Failed to create directory",
    "chmod_dir_failed" => "Failed to change directory rights"
);

// French
$_TRANSLATIONS["fr"] = array(
    "file_name" => "Nom de fichier",
    "size" => "Taille",
    "last_changed" => "Ajout&eacute;",
    "total_used_space" => "Espace total utilis&eacute;",
    "free_space" => "Espace libre",
    "password" => "Mot de passe",
    "upload" => "Envoyer un fichier",
    "failed_upload" => "Erreur lors de l'envoie!",
    "failed_move" => "Erreur lors du changement de dossier!",
    "wrong_password" => "Mauvais mot de passe",
    "make_directory" => "New dir",
    "new_dir_failed" => "Failed to create directory",
    "chmod_dir_failed" => "Failed to change directory rights"
);

// Romanian
$_TRANSLATIONS["ro"] = array(
    "file_name" => "Nume fisier",
    "size" => "Marime",
    "last_changed" => "Ultima modificare",
    "total_used_space" => "Spatiu total utilizat",
    "free_space" => "Spatiu disponibil",
    "password" => "Parola",
    "upload" => "Incarcare fisier",
    "failed_upload" => "Incarcarea fisierului a esuat!",
    "failed_move" => "Mutarea fisierului in alt director a esuat!",
    "wrong_password" => "Parola gresita!",
    "make_directory" => "New dir",
    "new_dir_failed" => "Failed to create directory",
    "chmod_dir_failed" => "Failed to change directory rights"
);



/***************************************************************************/
/*   CSS KUJUNDUSE MUUTMISEKS                                              */
/*                                                                         */
/*   CSS FOR CHANGING THE DESIGN                                           */
/***************************************************************************/

function css()
{
?>

<style type="text/css">

BODY {
    background-color:#FFFFFF;
}

A {
    color: #000000;
    text-decoration: none;
}

A:hover {
    text-decoration: underline;
}

#top {
    width:674px;
    height:110px;
    margin:3px;
    clip: rect(20px, 97px, 13px, 33px);
    overflow:hidden;
}

#top div{
    position:absolute;
    overflow:hidden;
    white-space:nowrap;
    height:107px;
    width:674px;
}

#top div.a0 {
    font-size: 24px;
    color:#92c3e1;
    height:auto;
    font-weight:bold;
    text-align:center;
    top:50px;
    
}

#top div.a1 {
    font-size: 105px;
    color:#f5faff;
    line-height:13px;
    text-indent: -100px;
}

#top div.a2 {
    font-size: 305px;
    color:#f8fbff;
    line-height:65px;
    text-indent: -170px;
}

#top div.a3 {
    font-size: 40px;
    color:#ecf4fd;
    line-height:85px;
    text-indent: -560px;

}

#top div.a4 {
    font-size: 100px;
    color:#f3f8fd;
    line-height:185px;
    text-indent: -460px;
}

#top div.a5 {
    font-size:34px;
    position:absolute;
    top:0px;
    left:0px;

}

#fb_frame {
    margin: 0;
}

#error {
    width:300px;
    background-color:#FFE4E1;
    font-family:Verdana;
    font-size:10px;
    color:#000000;
    padding:7px;
    position: relative;
    margin: 10px auto;
    text-align:center;
    border: 1px dotted #CDD2D6;
}

input {
    font-family:Verdana;
    font-size:10px;
    border: 1px solid #CDD2D6;
}

table.table {
    width: 674px; 
    font-family: Verdana; 
    font-size: 11px;
    margin:3px;
}

table.table tr.row.one {
    background-color:#fcfdfe;
}

table.table tr.row.two {
    background-color:#f8f9fa;
}

table.table tr.row td.icon {
    width:25px;
}

table.table tr.row td.name {
    
}

table.table tr.row td.size {
    width: 100px; 
    text-align: right;
}

table.table tr.row td.changed {
    width: 150px;
    text-align: center;
}

table.table tr.row td.long {

}

#upload {
    color:#000000;
    font-family:Verdana;
    font-size:10px;
    width:680px;
    position: relative;
    margin: 0 auto;
    text-align:center;
}

#upload input.text{
    width:100px;
}

#upload td.password {
    text-align:left;
}

#upload td.file {
    text-align:right;
}

#info {
    color:#000000;
    font-family:Verdana;
    font-size:10px;
    width:680px;
    position: relative;
    margin: 0 auto;
    text-align:center;
}

</style>

<?php
}

/***************************************************************************/
/*   PILTIDE KOODID                                                        */
/*   Saad neid ise oma piltidest juurde genereerida base64 konverteriga    */
/*   Näiteks siin: http://www.motobit.com/util/base64-decoder-encoder.asp  */
/*   Või siin: http://www.greywyvern.com/code/php/binary2base64            */
/*   Või kasuta lihtsalt PHP base64_encode() funktsiooni                   */
/*                                                                         */
/*   IMAGE CODES IN BASE64                                                 */
/*   You can generate your own with a converter                            */
/*   Like here: http://www.motobit.com/util/base64-decoder-encoder.asp     */
/*   /*   Or here: http://www.greywyvern.com/code/php/binary2base64        */
/*   Or just use PHP base64_encode() function                              */
/***************************************************************************/


$icons = array();
$icons["asp"] = "R0lGODlhEAAQAKIAAAAA/wAAhACEhMDAwP///8bGxoSEhAAAACH5BAEAAAMALAAAAAAQABAAQANK
OLrcewUeAokI9JG4oTlgA35RUQDFJ6bg4SgSxxGGCpdxERjRO4wf16vl05SCQoak06n1brFJgUBN
LpeGy/NHyp22jwPJZCuGGAkAOw==";
$icons["avi"] = "R0lGODlhEAAQALP/AMDAwAAAgAD//wCAgP8AAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARYEEhwqrUzn8J7MUcmbR5nFKFWckiLqKuJDBMZG/MgDHw/
cBXcoCUoIorDwQGBe7mOyCMOJ9EVr8MZ8wUYEIwCRABRaFEBz9aYLIPduKNYu2ao2+9wdHofAQA7";
$icons["bmp"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AAAAv78AvwC/v8DAwICAgP8AAAD/AP//AAAA//8A/wD/
/////yH5BAEAAAoALAAAAAAQABAAAARaUEmJAKhgzkwt3gpSUQ9gHNx1PWMSmA6hDGWGHAzgwsRw
jBKCgbEzIAaLAWciLCKVmpBoSgVSDo/sYfuzXrtTSzSE1XaXk5t5671mH+w2ef1Du80iu8TC52si
ADs=";
$icons["chm"] = "R0lGODlhEAAQAKIAAAAAhP//AISEAMDAwP///8bGxoSEhAAAACH5BAEAAAMALAAAAAAQABAAQANQ
OLoq7ssQYqoUIZQTrTlZURUZJ1EWAZZMi2WwOJxTDayaOXkT19I1guBAFLRcMI3x+Ao4YLrJpviB
zoKUQ3OjANYEngh2MiyKxzjfjMhuHxMAOw==";
$icons["css"] = "R0lGODlhDQAQAMQAAAAAAP///4SGhMbHxroPAKENAIgMAM0cDdEwItREONpYTOOFfOyspvfY1eeX
kfLDwPvq6v///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
ABEALAAAAAANABAAAAVVoCCOZGQKQaqmg3Cu6xC4KJwCOFDbrG5DDEhg4IMRHAUIcddINBABAmMZ
YCQOi1SjMNQlpCvFoytgHA4MVZqcelwDD0NvF2i05zzVcsDv+4k5gYIAIQA7";
$icons["directory"] = "R0lGODlhDwANAMIGAP//mczMZgAAAP/MmZmZAP//zP///////yH5BAEAAAcALAAAAAAPAA0AAAM9
eEfMohCSUwoA5MUVug9Ns1RkWQGBQFhX6w7p6rYDUMfsbNv4XP8oVY62gwmJwIFxlSwqY5/o5yGo
Wq/XBAA7";
$icons["doc"] = "R0lGODlhEAAQAMIBAAAAAP///wAA/8zMzJmZmWZmZv///////yH5BAEAAAcALAAAAAAQABAAAANU
eErF3kXJU4K9loB5CMbVJlWfBZynAKjsug7B4AoBW7uw7Ab7DmuH1Y2mquQ2reRg4JEFk7uL09Yi
LI9PAI/lkSKFraU1AFyUME5F4cpmizqouDwBADs=";
$icons["exe"] = "R0lGODlhEAAOAMIAAP///5mZmWZmZgAAAMzMzAAAzAAAmf///yH5BAEAAAcALAAAAAAQAA4AAAM8
GKK83oLISWcYgZTN+xbDUhjjCAzneWWC87whAcx0Pa+yrYORrq8Bnw2UEdYuPeOMl1OuXo3oYEqt
WqcJADs=";
$icons["gif"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AMDAwICAgP8AAAD/AAD//////wAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAgALAAAAAAQABAAAARcsMhJkb0l6a1JuVbGbUTyIUYgjgngAkYqDgQ9DEBCxAEi
Ei8ALsELaXCHJK5o1AGSh0EBEABgjgABwQMEXp0JgcDl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd
FxEAOw==";
$icons["gz"] = "R0lGODlhEAAQAMQAAJzO/2OczgBjnGPO/wCczgAxMTHOzsDAwM7OMf//nP//zv//986cAP/OMf/O
Y//OnP8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAcALAAAAAAQABAAQAVr4CGOUmkWI6Qkj9O8DSMdEjBDUbSs7TvXsxHJVEKJICxHgWgSAFCQ3crh
8tFsBwhz6zQKRRKBhBAOHyEQmoBAMBgGASN6TkdfbzrFFPbDRqdVDQh9N0kwMTJ3X2psbnBeiyQE
kUJiYmRiByEAOw==";
$icons["htm"] = "R0lGODlhEAAQALMAAAAA/wAAhDFj/zFjnDGc/zHO/wCEhDH//8DAwDGcAP////f398bGxoSEhAAA
AAAAACH5BAEAAAgALAAAAAAQABAAQARXsMlJJbqoqb1U+FvoZGFnGEK4jdoyvDDcsWqpLIzSXBpn
HIVEQEVzxWIzUmd5ayZ7tRBjx1MxZ44sKWRQHAhD0XYjICQA4dX26rzR2uzFO+4cZe/4/CgCADs=";
$icons["html"] = $icons["htm"];
$icons["jpeg"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AAAAv78AvwC/v8DAwICAgP8AAAD/AP//AAAA//8A/wD/
/////yH5BAEAAAoALAAAAAAQABAAAARaEMlJlb3o6a0PulbGbcfzKQwhjg/gAkwqDgdNA88RE4p4
vIABbhfSCBNIIbGYAyATAwSAAMAYAYGD5/ezNhOBgKvpPV7JzJpaiO5pgK/2iiXX2u/aqgXOd10i
ADs=";
$icons["jpg"] = $icons["jpeg"];
$icons["js"] = "R0lGODlhEAAQAOMAAP///wAAAMzMzJmZmWZmZv//AJmZAGZmAP//////////////////////////
/////yH5BAEAAAgALAAAAAAQABAAAARbcJAh6aw1DMB5nZ0QEB0wFAAqcuLGkYdhtAHQepyqrSJp
AoZYYFizaV4oXanXOQVnRaMLmTKyjh5KIGZlAki0FO+4KYySK6NvIBAMAu3ojUMkLkftvH5f7/uH
EQA7";
$icons["jsp"] = "R0lGODlhEAAQAOMAAP///wAAAMzMzJmZmWZmZv//AJmZAGZmAP//////////////////////////
/////yH5BAEAAAgALAAAAAAQABAAAARbcJAh6aw1DMB5nZ0QEB0wFAAqcuLGkYdhtAHQepyqrSJp
AoZYYFizaV4oXanXOQVnRaMLmTKyjh5KIGZlAki0FO+4KYySK6NvIBAMAu3ojUMkLkftvH5f7/uH
EQA7";
$icons["mov"] = "R0lGODlhEAAQAKL/AMDAwAD/AACAAP8AAP///8DAwICAgAAAACH5BAEAAAAALAAAAAAQABAAAANS
CArW7isaQispJqppaSGZ1FFHeYijdwgLlxarEAh0LVANLJRBf/Q7geEAO5l+wB8MppD1nrsV8QQQ
DHwBKaHEBBy/le4mpUK9qJuCes1Ge7/wBAA7";
$icons["mp3"] = "R0lGODlhEAAQAJEAAMDAwP///8bGxgAAACH5BAEAAAAALAAAAAAQABAAQAI5xI45wDwB4XtQLBNz
EPFSnVkOWE3NJx2RiJGrtwnyTMPu0bSghYxu6esEPixKYqgq/oA6V1EBxRUAADs=";
$icons["mpeg"] = $icons["avi"];
$icons["mpeg"] = $icons["avi"];
$icons["arrow_down"] = "R0lGODlhBwAGAIABAHh5f////yH+FUNyZWF0ZWQgd2l0aCBUaGUgR0lNUAAh+QQBCgABACwAAAAA
BwAGAAACCowfoMucbhZKpwAAOw==";
$icons["arrow_up"] = "R0lGODlhBwAGAIABAHh5f////yH+FUNyZWF0ZWQgd2l0aCBUaGUgR0lNUAAh+QQBCgABACwAAAAA
BwAGAAACCoxhCavLDiNLqQAAOw==";
$icons["pdf"] = "R0lGODlhEAAQALMAAP///+/v7wAAAN4AAMbGxgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AP+A/yH5BAEAAA8ALAAAAAAQABAAQARF8D1Bq5V4hh3G4JswWSQoSkLnfZsXiGQpECfKfSxXp227
vhiBC2QKEnU7AECgZC5fFePtuJvmQlIfsdr7dXa4IxYViz0iADs=";
$icons["php"] = "R0lGODlhDgAQAOMAAP///wAAAMzMzJmZmWZmZpnMmWaZZjOZM8zMmQBmAMz//5nMzDOZZmbMmWaZ
M////yH5BAEAAA8ALAAAAAAOABAAAARUcJAh6RwvvwG67wKWEd8nAETGlV3gBhtrwiRbgPD6HUsC
CLmPQWAAHArAB6lgOHp8yYGBcfM0TlEEw7HwIHAxgKIp9v1osu85LFsTBPC4PPmq22ERADs=";
$icons["png"] = "R0lGODlhEAAQALP/AMDAwAD/AACAAICAAP8AAIAAAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARcEMlJgb3I6K0PulbGbYfxAUQhjkbiJkQqDgc9DIlxxAUg
Hq8EzsALaXCBJK5o1CWSgQEiUUhgjgnBwQMEXp0GgcDl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd
FxEAOw==";
$icons["ppt"] = "R0lGODlhEAAQAIQAAP////8AAAAAAMzMzGZmAJmZAGZmZpmZmWaZAMzMmZmZzMyZzJnMmZmZZplm
AGZmmf///////////////////////////////////////////////////////////////yH5BAEA
ABAALAAAAAAQABAAAAVzICQeBmmWhqhCBuC+bikGBR0gNuIeQErAsIBLQBQIA4SAAwlwDJ6AgeBX
AxytMOkVgNMRBoxFVFAA/F5bl9ZaZpufAwBD4EXasa810FVQJOILdDk2SVkCKg9qUXAKAAmHIg17
hogDCQqWfk+XkBANRaChIQA7";
$icons["rar"] = "R0lGODlhEAAQAIQBAAAAAP///wAAmQAAZszMzJkAAGYAZpkAmf8A/wCZZmYAADMzMwD/ADOZzDMA
mZmZmQAzmTP/AACZ/wAzzP//AJmZM2ZmADOZmQBm////M2ZmZgCZzACZMwBmZgBmAP///yH5BAEA
AB8ALAAAAAAQABAAAAV8YKGI5GiSH6ESxmO8MFwQQX1QSK7rylMHBsJhSCQWfgFAZcHUMJ8FwUAg
AFivWECK8CAMLlKBYxoe0GqdTEPS2LDXDcc5cCFAJhPMHaIXIAEWZVSDA1mGWFsqAxVTjWVyPxwU
DJQRDJaWAz41HgQJn6CgDn8WY4KNh6kfIQA7";
$icons["sql"] = "R0lGODlhDQAQAMQAAAAAAP///4WS2djc8wAboQAWiAcjsh85uzJJwEdcxVptzZml36225cXN7uvu
+YSGhMbHxv///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
ABEALAAAAAANABAAAAVV4COOZGQ+Qaqm0HOuKxS4KJwCOFDbrG47DEcA4oMZFgQHcTdIDBABA2MZ
YCQOgtSAMNQlpCtFo/tgHA4MVZqcalwDjUJvFxi05zzVEsLv+4k5gYIAIQA7";
$icons["unknown"] = "R0lGODlhEAAQALMAAAAAAAAA/wCEAISEhMbGxv8AAP//AP//////////////////////////////
//+A/yH5BAEAAA8ALAAAAAAQABAAAAQ58L1Bq5V4ns03GZnWccQBYsPIASyAqh3hSinszaItv/ax
0z0frqYbBn85GJKoNPaWhKh0imxZr64IADs=";
$icons["txt"] = "R0lGODlhEAAQAMIAAP///wAAAMzMzJmZmWZmZv///////////yH5BAEAAAcALAAAAAAQABAAAANC
eBrA3ioeNkC9MNbH8yFAKI5CoI0oUJ5N4DCqqYCpuCpV67rhfeS1WIS22/Vkv+CRVeQJZ8pnUukb
CK7YrG/SbEYSADs=";
$icons["wav"] = "R0lGODlhEAAQALP/AMDAwAAAgAD//wCAgP8AAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARYEEhwqrUzn8J7MUcmbR5nFKFWckiLqKuJDBMZG/MgDHw/
cBXcoCUoIorDwQGBe7mOyCMOJ9EVr8MZ8wUYEIwCRABRaFEBz9aYLIPduKNYu2ao2+9wdHofAQA7";
$icons["wmv"] = $icons["avi"];
$icons["xls"] = "R0lGODlhEAAQAOMAAP///8zMzAAAAJmZmQBmAACZAGZmZmaZZplmmZnMmcyZzP//////////////
/////yH5BAEAAA8ALAAAAAAQABAAAARv8MlhqK1G6meA/94gSAVSDN9AoEA3HgTcwbAn3AIBrOW6
BkBAYFQAFAzHUiIkHD10JWVAERw+VUakyRNoFmhQkyGQUAASAoQP6wMNv7FYMS5salg7FaprlXSA
ZEIDXSJ3IId2fkCDgI1ODyI4kpIRADs=";
$icons["xml"] = "R0lGODlhEAAQAMQAAAAA/wAAnAAAhDFj/zFjnKXO9zGc/zHO/wCEhDH//zGcAMDAwP////f398bG
xoSEhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAsALAAAAAAQABAAQAVl4COOpLicy8M0RcMI8NoyUCq7CDLctN0QwGDQVVMxjkhXw8F4nB6FwAqR
OCgErkChuBJ6ib6VWCnmIs9Hh/N5JJMhcG6UgWAkDAKGtiGXDgwKAHl7Zm5jK4WHbomGSjVxkJFx
CyEAOw==";
$icons["xsl"] = "R0lGODlhEAAQAMQAAAAA/wAAnAAAhDFj/zFjnKXO9zGc/zHO/wCEhDH//8DAwDGcAP//AISEAP//
//f398bGxoSEhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAoALAAAAAAQABAAQAV5oBKNZDkqqOg0zeMIsPMUrqTOLoIMMu1ILIYkwmhICEhk7SZruh4QRwQV
KQRkiMRhIXAFCrYGY2xEJJU/BXAoeTyd6ch77oBMqfS3ZG+TWx0IDgkGAg5fD30zVwMGCwCFh2Fi
e3kyQGMREkVtcIgKYmRteTZ8paZ8IQA7";
$icons["zip"] = "R0lGODlhEAAQAMQAAJzO/2OczgBjnGPO/wCczgAxMTHOzsDAwM7OMf//nP//zv//986cAP/OMf/O
Y//OnP8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAcALAAAAAAQABAAQAVr4CGOUmkWI6Qkj9O8DSMdEjBDUbSs7TvXsxHJVEKJICxHgWgSAFCQ3crh
8tFsBwhz6zQKRRKBhBAOHyEQmoBAMBgGASN6TkdfbzrFFPbDRqdVDQh9N0kwMTJ3X2psbnBeiyQE
kUJiYmRiByEAOw==";


/***************************************************************************/
/*   EDASIST KOODI EI OLE TARVIS MUUTA                                     */
/*                                                                         */
/*   HERE COMES THE CODE.                                                  */
/*   DON'T CHANGE UNLESS YOU KNOW WHAT YOU ARE DOING ;)                    */
/***************************************************************************/


//
// If an image was requested, return it and die()
//
if(isset($_GET['img']))
{
    if(strlen($_GET['img']) > 0)
    {
        header('Content-type: image/gif');
        if(isset($icons[$_GET['img']]))
            print base64_decode($icons[$_GET['img']]);
        else
            print base64_decode($icons["unknown"]);
    }
    die();
}

//
// Set the selected language
//
$_LANG = $_TRANSLATIONS[$lang];

//
// Format the file size
//
function fileSizeF($size) 
{
    $sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
    $y = $sizes[0];
    for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) 
    {
        $size = $size / 1024;
        $y  = $sizes[$i];
    }
    return round($size, 2)." ".$y;
}

function fileRealSize($file)
{
    $sizeInBytes = filesize($file);
    //
    // If filesize() fails (with larger files), try to get the size from unix command line.
    if (!$sizeInBytes) {
        $sizeInBytes=exec("ls -l '$file' | awk '{print $5}'");
    }
    else
        return $sizeInBytes;
}

//
// Return file extension (the string after the last dot.
//
function fileExtension($file)
{
    $a = explode(".", $file);
    $b = count($a);
    return $a[$b-1];
}

//
// Formatinf the changing time
//
function fileChanged($time)
{
    return date("d.m.y H:i:s", $time);
}

//
// Find the icon for the extension
//
function fileIcon($l)
{
    global $ark_root_path;
    $l = strtolower($l);
    return "$ark_root_path/php/data_entry/file_browser.php?img=".$l;
}

//
// Generates the sorting arrows
//
function makeArrow($sort_by, $sort_as, $type, $dir, $text)
{
    global $ark_root_path;
    if($sort_by == $type && $sort_as == "desc")
    {
        return "<a href=\"?dir=".$dir."&amp;sort_by=".$type."&amp;sort_as=asc\">
        $text <img style=\"border:0;\" alt=\"asc\" src=\"$ark_root_path/php/data_entry/file_browser.php?img=arrow_up\" /></a>";
    }
    else
        return "<a href=\"?dir=".$dir."&amp;sort_by=".$type."&amp;sort_as=desc\">
        $text <img style=\"border:0;\" alt=\"desc\" src=\"$ark_root_path/php/data_entry/file_browser.php?img=arrow_down\" /></a>";
}

//
// Funcions that help sort the files
//
function name_cmp_desc($a, $b)
{
   return strcasecmp($a["name"], $b["name"]);
}

function size_cmp_desc($a, $b)
{
    return ($a["size"] - $b["size"]);
}

function size_cmp_asc($b, $a)
{
    return ($a["size"] - $b["size"]);
}

function changed_cmp_desc($a, $b)
{
    return ($a["changed"] - $b["changed"]);
}

function changed_cmp_asc($b, $a)
{
    return ($a["changed"] - $b["changed"]);
}

function name_cmp_asc($b, $a)
{
    return strcasecmp($a["name"], $b["name"]);
}

//
// Read file sizes from directories and calculate the size
//
function sum_dir($start_dir, $ignore_files, $levels = 1) 
{
    if ($dir = opendir($start_dir)) 
    {
        $filesize = 0;
        while ((($file = readdir($dir)) !== false)) 
        {
            if (!in_array($file, $ignore_files)) 
            {
                if ((is_dir($start_dir . '/' . $file)) && ($levels - 1 >= 0)) 
                {
                    $levels -= 1;
                    $filesize += sum_dir($start_dir . '/' . $file, $ignore_files, $levels);
                }
                elseif (is_file($start_dir . '/' . $file)) 
                {                    
                    $filesize += filesize($start_dir . '/' . $file) / 1024;
                }
            }
        }
        
        closedir($dir);
        return $filesize;
    }
}


//
// Find the directory one level up
//
function upperDir($dir)
{
    $chops = explode("/", $dir);
    $num = count($chops);
    $chops2 = array();
    for($i = 0; $i < $num - 1; $i++)
    {
        $chops2[$i] = $chops[$i];
    }
    $dir2 = implode("/", $chops2);
    return $dir2;
}

//
// Let's see what folder is being opened and react accordingly
//
if(!isset($_GET["dir"]) || strlen($_GET["dir"]) == 0) 
{
    $dir = $starting_dir;
    $upper_dir = "";
}
else
{
    //
    // This format is forbidden
    //
    if(ereg("\.\.(.*)", $_GET["dir"]) )
    {
        $dir = $starting_dir;
        $upper_dir = "";
    }
    else
    {
        $dir = $_GET["dir"];
        $upper_dir = upperDir($dir);
    }
}


//
// Creating the new directory
//
$error = NULL;
if(isset($_POST['userdir']) && strlen($_POST['userdir']) > 0)
{
    if($password && $_POST['password'] == $password)
    {
        $forbidden = array(".", "/", "\\");
        for($i = 0; $i < count($forbidden); $i++)
            $_POST['userdir'] = str_replace($forbidden[$i], "", $_POST['userdir']);
        if(!mkdir($dir."/".$_POST['userdir'], 0777))
            $error = $_LANG["new_dir_failed"];
        else if(!chmod($dir."/".$_POST['userdir'], 0777))
            $error = $_LANG["chmod_dir_failed"];
    }
    else
        $error = $_LANG["wrong_password"];
}

//
// Moving the uploaded file. If needed, let's produce an error.
//
if(isset($_FILES['userfile']['name']) && strlen($_FILES['userfile']['name']) > 0)
{
    if($password && $_POST['password'] == $password)
    {
        $name = basename($_FILES['userfile']['name']);
        if(get_magic_quotes_gpc())
            $name = stripslashes($name);

        $upload_dir = ($basedir?$basedir:dirname($_SERVER['SCRIPT_FILENAME']))."/".$dir."/";
        $upload_file = $upload_dir . $name;

        if(!is_uploaded_file($_FILES['userfile']['tmp_name']))
        {
            $error = $_LANG["failed_upload"];
        }
        else if(!@move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_file))
        {
            $error = $_LANG["failed_move"];
        }
        else
            chmod($upload_file, 0777);
    }
    else
        $error = $_LANG["wrong_password"];
}


//
// Reading the data of files and directories
//

if ($open_dir = @opendir($dir)) {
    // debug
    //echo "dir $dir is readable<br/>";
    $dirs = array();
    $files = array();
    $i = 0;
    while ($it = readdir($open_dir)) {
        if($it != "." && $it != "..") {
            if(is_dir($dir."/".$it)) {
                if(!in_array($it, $hidden_dirs)) {
                    $dirs[] = htmlspecialchars($it);
                }
            } elseif (!in_array($it, $hidden_files)) {
                $files[$i]["name"] = htmlspecialchars($it);
                $it = $dir."/".$it;
                $files[$i]["extension"] = fileExtension($it);
                $files[$i]["size"] = fileRealSize($it);
                $files[$i]["changed"] = filemtime($it);
                $i++;
            }
        }
    }
    closedir($open_dir);
    
    //
    // Sort files and folders. By default, they are sorted by name.
    //
    if($files || $dirs) {
        if(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "name" && $_GET["sort_as"] != "asc")
        {
            @sort($dirs);
            @usort($files, "name_cmp_desc");
        }
        elseif(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "name" && $_GET["sort_as"] == "asc")
        {
            @rsort($dirs);
            @usort($files, "name_cmp_asc");
        }
        elseif(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "size" && $_GET["sort_as"] != "asc" && $files)
        {
            usort($files, "size_cmp_desc");
        }
        elseif(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "size" && $_GET["sort_as"] == "asc" && $files)
        {
            usort($files, "size_cmp_asc");
        }
        elseif(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "changed" && $_GET["sort_as"] != "asc" && $files)
        {
            usort($files, "changed_cmp_desc");
        }
        elseif(isset($_GET["sort_by"]) && isset($_GET["sort_as"]) && $_GET["sort_by"] == "changed" && $_GET["sort_as"] == "asc" && $files)
        {
            usort($files, "changed_cmp_asc");
        }
        else
        {
            @sort($dirs);
            @usort($files, "name_cmp_desc");
        }
    }
    
    // this puts in the CSS
    css();
    
    //
    // Print the error (if there is something to print)
    //
    if ($error) {
        ?>
        <div id="error"><?php print $error; ?></div>
        <?php
    }
    
?>

    <div id="fb_frame">

    <!-- START: List table -->
    <table class="table" border="0" cellpadding="3" cellspacing="0">
        <tr class="row one">
            <td class="icon">
                &nbsp;
            </td>
            <td class="name">
                <?php print makeArrow((isset($_GET["sort_by"])?$_GET["sort_by"]:""), (isset($_GET["sort_as"])?$_GET["sort_as"]:""), "name", $dir, $_LANG["file_name"]);?>
            </td>
            <td class="size">
                <?php print makeArrow((isset($_GET["sort_by"])?$_GET["sort_by"]:""), (isset($_GET["sort_as"])?$_GET["sort_as"]:""), "size", $dir, $_LANG["size"]); ?>    
            </td>
            <td class="changed">
                <?php print makeArrow((isset($_GET["sort_by"])?$_GET["sort_by"]:""), (isset($_GET["sort_as"])?$_GET["sort_as"]:""), "changed", $dir, $_LANG["last_changed"]); ?>
            </td>
        </tr>
        <tr class="row two">
            <td class="icon">
                <img alt="dir" src="php/data_entry/file_browser.php?img=directory" />
            </td>
            <td colspan="3" class="long">
                <a href="?dir=<?php print $upper_dir; ?>">..</a>
            </td>
        </tr>
        
<?php
    //
    // Ready to display folders and files.
    //
    $row = 1;
    
    //
    // Folders first
    //
    if ($dirs) {
        foreach ($dirs as $a_dir) {
            $row_style = ($row ? "one" : "two");
?>
    <tr class="row <?php echo $row_style; ?>">
        <td class="icon">
            <img alt="dir" src="php/data_entry/file_browser.php?img=directory" />
        </td>
        <td colspan="3">
            <?php 
                echo "<a href=\"?dir=".$dir."/".$a_dir."\">".$a_dir."</a>"; 
            ?>
        </td>
    </tr>
<?php
            $row =! $row;
        }
    }
    
    //
    // Now the files
    //
    
    if ($files) {
        foreach ($files as $a_file) {
            $row_style = ($row ? "one" : "two");
?>

    <tr class="row <?php echo $row_style; ?>">
        <td class="icon">
            <img alt="<?php print $a_file["extension"]; ?>" src="<?php print fileIcon($a_file["extension"]); ?>" />
        </td>
        <td class="name">
<?php
            if (is_array($upload_results)) {
                if (in_array($a_file["name"],$upload_results)) {
                    $uploaded = getMarkup('cor_tbl_markup', $lang, 'fileuploaded');
                }
            }
                print "            <a href=\"".$dir."/".$a_file["name"]."\"";
                if($open_in_new_window)
                    print "target=\"_blank\"";
                print ">".$a_file["name"]." " . $uploaded."</a>"; 
?>

        </td>
        <td class="size">
            <?php print fileSizeF($a_file["size"]); ?>
        </td>
        <td class="changed">
            <?php print fileChanged($a_file["changed"]);?>    
        </td>
    </tr>
<?php
            $row =! $row;
        }
    }
    
    //
    // The files and folders have been displayed
    //

?>

</table>
<!-- END: List table -->
</div>

<?php

}
?>
