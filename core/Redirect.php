<?php
namespace Core;

class Redirect
{
    /**
     * Chuyển hướng đến URL chỉ định và kết thúc script
     * @param string $url URL cần chuyển hướng
     */
    public static function to(string $url): void
    {
        if (!headers_sent()) {
            header("Location: $url");
            exit;
        } else {
            // Nếu header đã gửi, dùng javascript chuyển hướng
            echo "<script>window.location.href='" . htmlspecialchars($url, ENT_QUOTES) . "';</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=" . htmlspecialchars($url, ENT_QUOTES) . "'></noscript>";
            exit;
        }
    }
}
