<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomMapController
{
    public function index()
    {
        // Lấy danh sách tất cả các phòng và trả về dạng JSON
        // Frontend JS mong muốn các trường: id, maLoai, price, maTrangThai
        $rooms = Room::all()->map(function ($room) {
            return [
                'id' => $room->ID,
                // MOCK DATA: Thay vì query thêm bảng loại, tạm thời giả lập tên loại bằng cách ghép chuỗi
                'maLoai' => 'Loại ' . $room->MaLoai, 
                'price' => (float) $room->Price,
                'maTrangThai' => (int) $room->MaTrangThai
            ];
        });

        return response()->json($rooms);
    }
}
