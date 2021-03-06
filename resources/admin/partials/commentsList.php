<table>
    <tr class="admin-comments-list__header">
        <th>№(ID)</th>
        <th><?= $product ?>(ID)</th>
        <th>Avatar</th>
        <th><?= $name ?></th>
        <th>Email</th>

        <th><?= $commentTitle ?></th>
        <th><?= $created ?></th>
        <th><?= $changed ?></th>
        <th><?= $published ?></th>
    </tr>

    <?php foreach($results as $comment): ?>
        <tr class="admin-comments-list__row" id="<?= $comment->id ?>">
            <th><?= $loop_counter++ .'('.$comment->id.')'?></th>
            <th><?=  $comment->title.'('.$comment->product_id.')' ?></th>
            <th><?php if ($comment->avatar) : ?><img src="/public/uploads/avatars/<?= $comment->avatar ?>" alt="" class="admin-comments-list__row-thumb" ><?php endif; ?></th>
            <th><?= $comment->name ?></th>
            <th><?= $comment->email ?></th>
            <th><?= htmlspecialchars_decode($comment->comment) ?></th>
            <th><?= $comment->created_at ?></th>
            <th class ="<?= $comment->changed ? 'changed' : 'notChanged' ?>"><?=  $comment->changed ? $yes : $no; ?></th>
            <th class="<?= $comment->published ? 'published' : 'notPublished' ?>"><?= $comment->published ? $yes : $no; ?></th>
        </tr>
    <?php endforeach; ?>

</table>




<?php if($pages>1): ?>

    <nav class="comments-pagination" id="comments-pagination">

        <?php
        $current =$_GET['p']?? $_POST['p']?? 1;

        for($i =0; $i<$pages; $i++): ?>

            <?php if($i==0 && $current>1){ ?>  <span class="pagination-item-comment" data-p="1"> << </span> <?php } ?>
            <?php if($i == 0 && $pages>1 && $current>1) {  ?> <span class="pagination-item-comment" data-p="<?= $current-1 ?>"> < </span>  ... <?php } ?>
            <?php

            if($i> ($current-6) && $i<($current+4)): ?>

                <?php if($i+1==$current){echo '<span class="pagination-item-comment-current" id="pagination-item-comment-current" data-p="'.($i+1).'">'.($i+1).'</span>'; }
                else { echo '<span class="pagination-item-comment" data-p="'.($i+1).'" >'. ($i+1).'</span>';} ?>

            <?php endif; ?>
            <?php if($current<$pages): ?>
                <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <span class="pagination-item-comment" data-p="<?= $current+1 ?>" > > </span> <?php } ?>
                <?php if($i==$pages-1){ ?>  <span class="pagination-item-comment" data-p="<?= $pages ?>" > >> </span> <?php } ?>
            <?php endif; ?>


        <?php endfor; ?>
    </nav>

<?php endif; ?>