<?php $id = (int)$_POST['id']; ?>
<p class='popUp-menu-item' id="popUp-menu-item" data-id = "<?= $id ?>"><?= $add ?></p>
<a href='/adminProducts/show?id=<?= $id ?>' class='popUp-menu-item'><?= $update ?></a>

<p class='popUp-menu-item' id="popUp-menu-item" data-id = "<?= $id ?>"><?= $delete ?></p>