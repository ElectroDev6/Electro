<?php
ob_start();
?>
<div class="pagination">
    <div class="pagination__info">Hiển thị 1-6 trong số 0 mục</div>
    <div class="pagination__controls"></div>
</div>
<?php
$htmlPagination = ob_get_clean();
?>