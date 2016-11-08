
<p><a href='/adminProducts/create' class='popUp-menu-item'><?= $add ?></a></p>
<p><a href='/adminProducts/show?id=<?= $id ?>' class='popUp-menu-item'><?= $update ?></a></p>
<p><span  class="popUp-menu-item" id="popUp-admin-product-delete" data-delete-product-id="<?= (int)$_POST['id'] ?>"><?= $delete ?></span></p>