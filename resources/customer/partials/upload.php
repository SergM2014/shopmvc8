<label for="FileInput" > <?= $addAvatar ?></label>

<form id="MyUploadForm"  enctype="multipart/form-data" method="post">

    <input type="hidden" name="_token" id="prozessAvatar" value="<?= \Lib\TokenService::printTocken('prozessAvatar') ?>">

    <div id="avatar_area"  class="clearfix">
        <img alt="" id="image_preview" class="thumb left" src="<?php if(isset($_SESSION['avatar'])) {echo '/uploads/avatars/'.$_SESSION['avatar'];} else {echo URL.'img/noavatar.jpg';} ?>"  />

        <div id="output" class="invisible" ></div>
        <div class="progress right">
            <div id="progress-bar" class="invisible" role="progressbar">
                0%
            </div>
        </div>

    </div>
    <div id="avatarForm">

        <input name="FileInput" id="FileInput" type="file" class="<?php if(isset($_SESSION['avatar'])) echo 'invisible' ?>" >
        <button  id="submit-btn" class="invisible"><?= $load ?></button>
        <button  id="image-reset-btn"  class="<?php if(!isset($_SESSION['avatar'])) echo "invisible" ?>" ><?= $delete ?></button>


    </div>



</form>