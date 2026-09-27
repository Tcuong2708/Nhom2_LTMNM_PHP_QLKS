<?php

namespace App\Enums;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case BOOKED = 'booked';
    case MAINTENANCE = 'maintenance';

    /**
     * Lấy danh sách trạng thái hợp lệ
     *
     * @return array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
