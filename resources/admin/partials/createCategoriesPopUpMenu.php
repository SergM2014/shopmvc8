<p><a href='/adminCategories/edit?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $update?></a></p>

<form id="publish-comment-item" action="/adminCategories/create" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

<!--    <p><span  class="popUp-menu-item" id="popUp-admin-maincategory-create" ><?/*= $createMainCategory */?></span></p>-->
    <p><span  class="popUp-menu-item" id="popUp-admin-subcategory-create" ><?= $createCategory ?></span></p>

</form>

<form id="publish-comment-item" action="/adminCategories/delete" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

    <p><span  class="popUp-menu-item" id="popUp-admin-category-delete" ><?= $deleteCategory ?></span></p>

</form>



