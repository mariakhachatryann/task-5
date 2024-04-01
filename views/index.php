<div id="box">
    <p class="title1">POSTS</p>
    <div class="posts">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p class="post-title"><?= $post['title'] ?></p>
                    <p><?= substr($post['text'],0,70 ) . '...' ?></p>
                    <div class="post-details">
                        <span>Created by <?= $post['username'] ?></span>
                        <span><?= $post['created_at'] ?></span>
                    </div>
                    <?php if(isset($_SESSION['admin']) && $_SESSION['admin']['id'] == $post['admin_id']): ?>
                        <a href="index.php?action=edit&id=<?= $post['id'] ?>" class="edit-btn">Edit Post</a>
                        <a href="index.php?action=delete&id=<?= $post['id'] ?>" class="delete-btn">Delete Post</a>
                    <?php endif; ?>
                    <a href="index.php?action=view&id=<?= $post['id'] ?>" class="see-btn">See more</a>
                </div>
            <?php endforeach; ?>
        <?php else :?>
            <p>You have no posts</p>
        <?php endif; ?>
    </div>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?action=&page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

