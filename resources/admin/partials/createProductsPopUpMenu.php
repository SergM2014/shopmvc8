<?php $id = (int)$_POST['id']; ?>

<p><a href='/adminProducts/create' class='popUp-menu-item'><?= $add ?></a></p>
<a href='/adminProducts/show?id=<?= $id ?>' class='popUp-menu-item'><?= $update ?></a>

<p class='popUp-menu-item' id="popUp-menu-item" data-id = "<?= $id ?>"><?= $delete ?></p>