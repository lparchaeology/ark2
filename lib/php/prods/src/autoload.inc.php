<?php
// change this, if this code isn't "higher" than ALL classfiles
define("CLASS_DIR", dirname(__FILE__));
/**
 * autoload classes (no need to include them one by one)
 *
 * @uses classFolder()
 * @param $className string
 */
 
/**
 * DEV NOTE: the __autoload function no longer works in PHP >5.3 therefore I have updated this code
 *           to reflect the necessary change. SJE April 22nd 2014.
 */
  
//function __autoload($className) {
//   $folder = classFolder($className);

//   if($folder)
//       require_once($folder.$className.".class.php");
//}

function my_autoloader($className) {
   $folder = classFolder($className);

   if($folder)
       require_once($folder.$className.".class.php");
}

spl_autoload_register('my_autoloader');

// END OF SJE EDITS


/**
 * search for folders and subfolders with classes
 *
 * @param $className string
 * @param $sub string[optional]
 * @return string
 */
function classFolder($className, $sub = "/") {
   $dir = dir(CLASS_DIR.$sub);
  
   if(file_exists(CLASS_DIR.$sub.$className.".class.php"))
       return CLASS_DIR.$sub;

   while(false !== ($folder = $dir->read())) {
       if($folder != "." && $folder != "..") {
           if(is_dir(CLASS_DIR.$sub.$folder)) {
               $subFolder = classFolder($className, $sub.$folder."/");
              
               if($subFolder)
                   return $subFolder;
           }
       }
   }
   $dir->close();
   return false;
}

?>