
<p><a href='/<?= \Lib\HelperService::currentLang() ?>adminComments/edit?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $update ?></a></p>


<form id="publish-comment-item" action="/<?= \Lib\HelperService::currentLang() ?>adminComments/publish" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

    <p><span  class="popUp-menu-item" id="popUp-admin-comment-publish" ><?= $publish ?></span></p>

</form>

<form id="unpublish-comment-item" action="/<?= \Lib\HelperService::currentLang() ?>adminComments/unpublish" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

    <p><span  class="popUp-menu-item" id="popUp-admin-comment-unpublish" ><?= $unpublish ?></span></p>

</form>
