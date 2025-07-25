<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng #001</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
         <?php echo $contentSidebar; ?>
        <div class="blogs">
        <div class="blogs__container">
            <!-- Header Section -->
            <div class="blogs__header">
                <h1 class="blogs__title">Trang Bài Viết</h1>
                <button class="blogs__add-btn">
                    <i class="fas fa-plus"></i>
                    Add New
                </button>
            </div>

            <!-- Filters Section -->
            <div class="blogs__filters">
                <div class="blogs__filter-group">
                    <div class="blogs__search-wrapper">
                        <label class="blogs__label" for="title-search">Title</label>
                        <input 
                            type="text" 
                            id="title-search"
                            class="blogs__search-input" 
                            placeholder="Search posts..."
                        >
                    </div>
                    
                    <div class="blogs__select-wrapper">
                        <label class="blogs__label" for="topic-filter">Topic</label>
                        <select id="topic-filter" class="blogs__select">
                            <option value="">Tất cả tiêu đề</option>
                            <option value="productivity">Productivity</option>
                            <option value="technology">Technology</option>
                            <option value="lifestyle">Lifestyle</option>
                            <option value="business">Business</option>
                        </select>
                    </div>
                    
                    <div class="blogs__select-wrapper">
                        <label class="blogs__label" for="status-filter">Status</label>
                        <select id="status-filter" class="blogs__select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                    </div>
                </div>
                
                <div class="blogs__filter-actions">
                    <button class="blogs__filter-btn">
                        <i class="fas fa-filter"></i>
                        Lọc
                    </button>
                    <button class="blogs__reset-btn">
                        <i class="fas fa-times"></i>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="blogs__table-wrapper">
                <table class="blogs__table">
                    <thead class="blogs__table-head">
                        <tr class="blogs__table-row blogs__table-row--header">
                            <th class="blogs__table-cell blogs__table-cell--header">Name</th>
                            <th class="blogs__table-cell blogs__table-cell--header">Người dùng</th>
                            <th class="blogs__table-cell blogs__table-cell--header">Tiêu đề</th>
                            <th class="blogs__table-cell blogs__table-cell--header">Ngày tạo</th>
                            <th class="blogs__table-cell blogs__table-cell--header">Trạng thái</th>
                            <th class="blogs__table-cell blogs__table-cell--header">Điều hướng</th>
                        </tr>
                    </thead>
                    <tbody class="blogs__table-body">
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">10 Tips for Better Productivity</div>
                                        <div class="blogs__post-meta">15 comments • 250 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">John Doe</td>
                            <td class="blogs__table-cell">Productivity</td>
                            <td class="blogs__table-cell">Jul 15, 2023</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--published">Published</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">The Future of AI in Business</div>
                                        <div class="blogs__post-meta">8 comments • 500 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">Jane Smith</td>
                            <td class="blogs__table-cell">Technology</td>
                            <td class="blogs__table-cell">Jul 10, 2023</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--published">Published</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">5 Morning Habits of Successful People</div>
                                        <div class="blogs__post-meta">22 comments • 456 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">Robert Johnson</td>
                            <td class="blogs__table-cell">Lifestyle</td>
                            <td class="blogs__table-cell">Jul 5, 2023</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--published">Published</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">How to Build a Successful E-commerce Business</div>
                                        <div class="blogs__post-meta">0 comments • 0 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">Emily Brown</td>
                            <td class="blogs__table-cell">Business</td>
                            <td class="blogs__table-cell">-</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--draft">Draft</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">The Complete Guide to Digital Marketing</div>
                                        <div class="blogs__post-meta">0 comments • 0 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">Michael Taylor</td>
                            <td class="blogs__table-cell">Business</td>
                            <td class="blogs__table-cell">Aug 15, 2023</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--scheduled">Scheduled</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="blogs__table-row">
                            <td class="blogs__table-cell">
                                <div class="blogs__post">
                                    <i class="fas fa-file-alt blogs__post-icon"></i>
                                    <div class="blogs__post-content">
                                        <div class="blogs__post-title">The Rise of Remote Work</div>
                                        <div class="blogs__post-meta">7 comments • 456 views</div>
                                    </div>
                                </div>
                            </td>
                            <td class="blogs__table-cell">Sarah Lee</td>
                            <td class="blogs__table-cell">Technology</td>
                            <td class="blogs__table-cell">Jun 28, 2023</td>
                            <td class="blogs__table-cell">
                                <span class="blogs__status blogs__status--published">Published</span>
                            </td>
                            <td class="blogs__table-cell">
                                <div class="blogs__actions">
                                    <button class="blogs__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="blogs__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </main>
</body>
</html>