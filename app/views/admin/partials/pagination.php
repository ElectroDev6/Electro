<?php
    ob_start();
?>      
            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination__info">Hiển thị 1-8 trong số 56 mục</div>
                <div class="pagination__controls">
                    <button class="pagination__btn pagination__btn--active">1</button>
                    <button class="pagination__btn">2</button>
                    <button class="pagination__btn">3</button>
                    <button class="pagination__btn">4</button>
                    <button class="pagination__btn">5</button>
                </div>
            </div
<?php
    $htmlPagination = ob_get_clean();
?>