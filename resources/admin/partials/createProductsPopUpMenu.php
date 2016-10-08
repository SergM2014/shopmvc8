<?php $id = (int)$_POST['id']; ?>
<a href='/adminProducts/update?id=<?= $id ?>' class='popUp-menu-item'><?= $update ?></a><p class='popUp-menu-item'
       id="popUp-menu-item" data-id = "<?= $id ?>"><?= $delete ?></p>