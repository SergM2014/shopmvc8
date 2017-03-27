<p><a href='/<?= \Lib\HelperService::currentLang() ?>admin<?= ucfirst($significant == 'category' ? 'categorie' : $significant) ?>s/edit?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $update ?></a></p>
<p><a href='/<?= \Lib\HelperService::currentLang() ?>admin<?= ucfirst($significant == 'category' ? 'categorie' : $significant) ?>s/create' class='popUp-menu-item'><?= $create ?></a></p>

<p><span  class="popUp-menu-item" id="popUp-admin-<?= $significant ?>-delete" data-<?= $significant ?>-id =  <?= (int)$_POST['id'] ?>  ><?= $delete ?></span></p>





