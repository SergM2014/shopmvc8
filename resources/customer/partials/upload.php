<label for="FileInput" > <?= $addAvatar ?></label>

<form id="MyUploadForm"  enctype="multipart/form-data" method="post">

    <input type="hidden" name="_token" id="prozessAvatar" value="<?= \Lib\TokenService::printTocken('prozessAvatar') ?>">

    <div id="avatar_area"  class="clearfix">
        <img alt="" id="image_preview" class="avatar-thumb-preview" src="<?php if(isset($_SESSION['avatar'])) {echo '/uploads/avatars/'.$_SESSION['avatar'];} else {echo URL.'img/noavatar.jpg';} ?>"  />

        <div id="output" class="avatar__progress-container invisible" ></div>
        <div class="progress ">
            <div id="progress-bar" class="invisible" role="progressbar">
                0%
            </div>
        </div>

    </div>


       <div class="clearfix"> <input name="FileInput" id="FileInput" type="file" class="file-input <?php if(isset($_SESSION['avatar'])) echo 'invisible' ?>" ></div>
        <div>
            <button  id="avatar-reset-btn"  class="avatar-reset-btn <?php if(!isset($_SESSION['avatar'])) echo "invisible" ?>" ><?= $delete ?></button>
            <button  id="avatar-submit-btn" class=" avatar-submit-btn invisible"><?= $load ?></button>
        </div>






</form>

<script src="/assets/js/uploadimage.js"></script>