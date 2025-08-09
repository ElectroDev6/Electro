<?php
    function formatTimeAgo($datetime, $timezone = 'Asia/Ho_Chi_Minh') {
    // Đặt múi giờ
    date_default_timezone_set($timezone);
    
    try {
        $createAt = new DateTime($datetime);
        $now = new DateTime();
        
        // Tính chênh lệch tổng số phút (âm nếu là tương lai)
        $totalMinutes = ($now->getTimestamp() - $createAt->getTimestamp()) / 60;
        $totalHours = $totalMinutes / 60;
        $totalDays = floor($totalHours / 24);
        
        // Kiểm tra nếu là cùng ngày (so sánh Y-m-d)
        $isSameDay = $createAt->format('Y-m-d') === $now->format('Y-m-d');
        
        // Hàm helper để lấy phần thời gian trong ngày
        $getTimeOfDay = function($hour, $timeStr) {
            if ($hour >= 18) {
                return $timeStr . ' tối';
            } elseif ($hour >= 12) {
                return $timeStr . ' chiều';
            } elseif ($hour >= 6) {
                return $timeStr . ' sáng';
            } else {
                return $timeStr . ' đêm';
            }
        };
        // Kiểm tra nếu là thời gian tương lai
        if ($totalMinutes < 0) {
            // Thời gian trong tương lai - hiển thị bình thường
            if ($isSameDay) {
                $hour = (int)$createAt->format('G');
                $timeStr = $createAt->format('H:i');
                return 'Hôm nay, ' . $getTimeOfDay($hour, $timeStr);
            } else {
                return $createAt->format('d/m/Y H:i');
            }
        } elseif ($totalMinutes < 1) {
            return 'Vừa xong';
        } elseif ($totalMinutes < 5) {
            return '1 phút trước';
        } elseif ($totalMinutes < 60) {
            return floor($totalMinutes) . ' phút trước';
        } elseif ($isSameDay) {
            // Cùng ngày - hiển thị giờ với phần thời gian trong ngày
            $hour = (int)$createAt->format('G');
            $timeStr = $createAt->format('H:i');
            return 'Hôm nay, ' . $getTimeOfDay($hour, $timeStr);
        } elseif ($totalDays == 1) {
            // Hôm qua
            $hour = (int)$createAt->format('G');
            $timeStr = $createAt->format('H:i');
            return 'Hôm qua, ' . $getTimeOfDay($hour, $timeStr);
        } elseif ($totalDays < 7) {
            return $totalDays . ' ngày trước';
        } else {
            // Hiển thị ngày tháng đầy đủ cho các trường hợp cũ hơn 7 ngày
            return $createAt->format('d/m/Y H:i');
        }
        
    } catch (Exception $e) {
        return 'Không xác định';
    }
}