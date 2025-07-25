<!-- Phần danh mục -->
        <div class="content-wrapper">
            <div class="category-tabs">
                <button class="category-tabs__button category-tabs__button--active">
                    <img src="/img/Icon All.svg" alt="Tất cả">
                    <span>Tất cả</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/iphone223.png" alt="Điện thoại">
                    <span>Điện thoại</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/laptop.png" alt="Laptop">
                    <span>Laptop</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/tainghe.png" alt="Phụ kiện">
                    <span>Phụ kiện</span>
                </button>
            </div>



            .content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}   
// Phan danh mục 
.category-tabs {
    display: flex;
    gap: 15px;
    border-radius: 8px;
    padding: 0; // Xóa padding thừa
    

    &__button {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 5px;
        height: 80px;
        width: 106px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;

        &--active {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        &:hover {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        img {
            width: 28px;
            height: 28px;
            margin-bottom: 5px;
        }
    }
}
