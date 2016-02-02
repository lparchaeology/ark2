<?php

//get the photo from the user
$abk_cd = "ARK_".$user_id;

$files = getFile("abk_cd", $abk_cd, 'profilephoto');
if ($files){
    $image = current($files);
    if (file_exists("{$registered_files_dir}/arkthumb_{$image['id']}.jpg")){
        $profilephoto = "{$registered_files_host}arkthumb_{$image['id']}.jpg";
    }
}
if (!isset($profilephoto)){
    if(rand(0,1)==0){
        $profilephoto = $skin_path.'/images/common/placeholder-man.png';
    } else {
        $profilephoto = $skin_path.'/images/common/placeholder-woman.png';
    }
}

$user_role = resTblTd($conf_field_abktype, "abk_cd", $abk_cd);

?>
<div class="userprofile">
<div class="photo">
<div class="mask"><a href="<?php print $ark_dir?>micro_view.php?item_key=abk_cd&abk_cd=<?php print $abk_cd?>"> <img src="<?php print $skin_path?>/images/common/mask-profile-photo.svg" alt="" /></a></div>
<img src="<?php print $profilephoto ?>" alt="" />
</div>
<p class="name"><a href="<?php print $ark_dir?>micro_view.php?item_key=abk_cd&abk_cd=<?php print $abk_cd?>"><?php print $soft_name?></a></p>
<p class="role"><?php print $user_role?></p>
</div>
