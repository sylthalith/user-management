<div class="pagination">
    <?php if ($paginator->hasPreviousPage()): ?>
        <a href="<?= request()->getUri(['page' => $paginator->getPreviousPageNumber()]) ?>" class="btn dark-btn pagination-btn">←</a>
    <?php endif ?>
    <?php if (!$paginator->reachedLeft()): ?>
        <a href="<?= request()->getUri(['page' => $paginator->getFirstPageNumber()]) ?>" class="btn dark-btn pagination-btn"><?= $paginator->getFirstPageNumber() ?></a>
    <?php endif ?>
    <?php if ($paginator->hasLeftDots()): ?>
        <span class="dots">...</span>
    <?php endif ?>
    <?php foreach ($paginator->getDisplayPages() as $page): ?>
        <a href="<?= request()->getUri(['page' => $page]) ?>" class="btn dark-btn pagination-btn <?= $paginator->isCurrentPageNumber($page) ? 'current' : '' ?>"><?= $page ?></a>
    <?php endforeach ?>
    <?php if ($paginator->hasRightDots()): ?>
        <span class="dots">...</span>
    <?php endif ?>
    <?php if (!$paginator->reachedRight()): ?>
        <a href="<?= request()->getUri(['page' => $paginator->getLastPageNumber()]) ?>" class="btn dark-btn pagination-btn"><?= $paginator->getLastPageNumber() ?></a>
    <?php endif ?>
    <?php if ($paginator->hasNextPage()): ?>
    <a href="<?= request()->getUri(['page' => $paginator->getNextPageNumber()]) ?>" class="btn dark-btn pagination-btn">→</a>
    <?php endif ?>
</div>