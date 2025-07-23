<?php

// global variables to store section content
global $__sections;
$__sections = [];

global $__currentSection;
$__currentSection = null;

/**
 * Renders a view file within a layout.
 *
 * @param string $viewName The name of the view file (e.g., 'home', 'product/detail').
 * @param array $data Data to pass to the view.
 * @return void
 */
function render($viewName, $data = [])
{
    global $__sections, $__currentSection;

    extract($data);
    $pageName = basename($viewName);

    $uri = $_SERVER['REQUEST_URI'];
    // Debug nếu cần:
    // print_r($uri);

    // Xác định đường dẫn view & layout theo route
    if (str_starts_with(trim($uri, '/'), 'admin')) {
        $viewPath = BASE_PATH . '/app/views/admin/' . str_replace('.', '/', $viewName) . '.php';
        $layoutPath = BASE_PATH . '/app/views/admin/layout/main.php';
    } else {
        $viewPath = BASE_PATH . '/app/views/web/' . str_replace('.', '/', $viewName) . '.php';
    }

    if (!file_exists($viewPath)) {
        die("View file not found: " . $viewPath);
    }

    // Bắt đầu capture nội dung view
    ob_start();
    require $viewPath;
    $viewContent = ob_get_clean();

    // Nếu có dùng extend layout từ view
    if (isset($__sections['__layout'])) {
        $layoutPath = BASE_PATH . '/app/views/web/' . str_replace('.', '/', $__sections['__layout']) . '.php';
        if (!file_exists($layoutPath)) {
            die("Layout file not found: " . $layoutPath);
        }
        require $layoutPath;
    } else {
        echo $viewContent;
    }

    // Reset
    $__sections = [];
    $__currentSection = null;
}


/**+
 * Declares that the current view extends a given layout.
 *
 * @param string $layoutName The name of the layout file (e.g., 'layouts.main').
 * @return void
 */
function extend($layoutName)
{
    global $__sections;
    $__sections['__layout'] = $layoutName;
}

/**
 * Starts capturing content for a named section.
 *
 * @param string $sectionName The name of the section.
 * @return void
 */
function section($sectionName)
{
    global $__currentSection, $__sections;
    if ($__currentSection !== null) {
        die("Cannot nest sections. Section '{$__currentSection}' is already open.");
    }
    $__currentSection = $sectionName;
    ob_start();
}

/**
 * Ends capturing content for the current section and stores it.
 *
 * @return void
 */
function endSection()
{
    global $__currentSection, $__sections;
    if ($__currentSection === null) {
        die("No section is currently open to end.");
    }
    $__sections[$__currentSection] = ob_get_clean();
    $__currentSection = null;
}

/**
 * Displays the content of a named section in the layout.
 *
 * @param string $sectionName The name of the section to display.
 * @param string $defaultContent Optional default content if the section is not defined.
 * @return void
 */
function yieldSection($sectionName, $defaultContent = '')
{
    global $__sections;
    echo $__sections[$sectionName] ?? $defaultContent;
}

/**
 * Includes a partial file.
 *
 * @param string $partialName The name of the partial file (e.g., 'partials/_header').
 * @param array $data Data to pass to the partial.
 * @return void
 */
function partial($partialName, $data = [])
{
    extract($data);

    $partialPath = BASE_PATH . '/app/views/web/' . str_replace('.', '/', $partialName) . '.php';
    if (!file_exists($partialPath)) {
        die("Partial file not found: " . $partialPath);
    }
    require $partialPath;
}
