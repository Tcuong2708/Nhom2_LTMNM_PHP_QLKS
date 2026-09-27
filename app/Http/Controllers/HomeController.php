<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 4 hạng phòng bán chạy nhất (dựa vào số lượng hóa đơn)
        $topRooms = DB::table('loai')
            ->leftJoin('phong', 'loai.MaLoai', '=', 'phong.MaLoai')
            ->leftJoin('hoadon', 'phong.ID', '=', 'hoadon.MaPhong')
            ->selectRaw('loai.MaLoai, loai.Name as LoaiName, loai.SoNguoi, COUNT(hoadon.MaHD) as TotalBookings, MIN(phong.Price) as Price, MIN(phong.ImageUrl) as ImageUrl, MIN(phong.ID) as RoomID')
            ->groupBy('loai.MaLoai', 'loai.Name', 'loai.SoNguoi')
            ->orderByDesc('TotalBookings')
            ->take(4)
            ->get();

        return view('home', compact('topRooms'));
    }

    public function info()
    {
        return view('home.info');
    }

    public function reviews()
    {
        $reviews = \App\Models\Review::orderBy('NgayDanhGia', 'desc')->get();
        return view('home.review', compact('reviews'));
    }

    public function rooms(Request $request)
    {
        $categories = RoomType::all();
        
        $query = Room::query()
            ->join('loai', 'phong.MaLoai', '=', 'loai.MaLoai')
            ->select('phong.*', 'loai.Name as LoaiName');

        // Lọc theo search (theo tên loại phòng thay vì mã phòng)
        if ($request->has('search') && $request->search != '') {
            $query->where('loai.Name', 'LIKE', '%' . $request->search . '%');
        }

        // Lọc theo category (maLoai)
        if ($request->has('category') && $request->category != '') {
            $query->where('MaLoai', $request->category);
        }

        // Lọc theo giá
        if ($request->has('priceRange') && $request->priceRange != '') {
            if ($request->priceRange == 'lt500') {
                $query->where('Price', '<', 500000);
            } elseif ($request->priceRange == 'gt2000') {
                $query->where('Price', '>', 2000000);
            }
        }

        // Chỉ lấy 1 phòng đại diện cho mỗi loại phòng
        $rooms = $query->get()->unique('MaLoai');

        return view('home.rooms.list', compact('rooms', 'categories'));
    }

    public function roomDetail($id)
    {
        $room = Room::findOrFail($id);
        $category = RoomType::find($room->MaLoai);
        
        return view('home.rooms.detail', compact('room', 'category'));
    }
}
