<p class="popup-text"><?= $areYouShureToDelete ?></p>
<form id="delete-product-item" action="/adminProducts/delete" method="post" class="modal-confirm-btn-container">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

    <button type="button" class="modal-confirm-btn" id="modal-confirm-btn--reset" ><?= $no ?></button>
    <button type="submit" id="modal-confirm-btn--delete" class="modal-confirm-btn" ><?= $yes ?></button>
</form>

