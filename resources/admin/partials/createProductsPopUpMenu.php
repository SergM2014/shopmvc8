<?php $id = (int)$_POST['id']; ?>

<p><a href='/adminProducts/create' class='popUp-menu-item'><?= $add ?></a></p>
<p><a href='/adminProducts/show?id=<?= $id ?>' class='popUp-menu-item'><?= $update ?></a></p>


<p><a href="#" class="popUp-menu-item" id="popUp-menu-item-delete" onclick="event.preventDefault(); document.getElementById('delete-item').submit();" ><?= $delete ?> </a></p>
<form id="delete-item" action="/adminProducts/delete" method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">
</form>