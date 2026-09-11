<?php

namespace App\Services;

use App\Models\Room; // Giả sử có Model Room
use App\Enums\RoomStatus;
use Illuminate\Support\Collection;
use Exception;

class RoomService
{
    /**
     * Lấy danh sách các phòng còn trống
     *
     * @return Collection
     */
    public function getAvailableRooms(): Collection
    {
        // Truy vấn CSDL Mysql lấy các phòng có trạng thái 'available'
        return Room::where('status', RoomStatus::AVAILABLE->value)->get();
    }

    /**
     * Đặt phòng theo ID
     *
     * @param int $roomId
     * @return Room
     * @throws Exception
     */
    public function bookRoom(int $roomId): Room
    {
        $room = Room::find($roomId);

        if (!$room) {
            throw new Exception("Phòng không tồn tại.");
        }

        if ($room->status !== RoomStatus::AVAILABLE->value) {
            throw new Exception("Phòng này không còn trống.");
        }

        // Cập nhật trạng thái thành đã đặt
        $room->status = RoomStatus::BOOKED->value;
        $room->save();

        return $room;
    }
}
