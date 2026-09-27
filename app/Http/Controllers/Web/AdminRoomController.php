<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomStatus;
use Illuminate\Support\Facades\File;

class AdminRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::join('Loai', 'Phong.MaLoai', '=', 'Loai.MaLoai')
            ->join('TrangThaiPhong', 'Phong.MaTrangThai', '=', 'TrangThaiPhong.MaTrangThai')
            ->select('Phong.*', 'Loai.Name as TenLoai', 'TrangThaiPhong.TrangThai as TenTrangThai')
            ->orderBy('Phong.ID', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('Phong.Name', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->get();
            
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        $roomStatuses = RoomStatus::all();
        return view('admin.rooms.create', compact('roomTypes', 'roomStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'MaLoai' => 'required|exists:Loai,MaLoai',
            'MaTrangThai' => 'required|exists:TrangThaiPhong,MaTrangThai',
            'SoGiuongPhuToiDa' => 'required|integer|min:0',
            'Detail' => 'nullable|string',
            'GhiChu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/rooms'), $filename);
            $data['ImageUrl'] = 'images/rooms/' . $filename;
        } else {
            $data['ImageUrl'] = '';
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng thành công!');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();
        $roomStatuses = RoomStatus::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes', 'roomStatuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'MaLoai' => 'required|exists:Loai,MaLoai',
            'MaTrangThai' => 'required|exists:TrangThaiPhong,MaTrangThai',
            'SoGiuongPhuToiDa' => 'required|integer|min:0',
            'Detail' => 'nullable|string',
            'GhiChu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $room = Room::findOrFail($id);
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($room->ImageUrl && File::exists(public_path($room->ImageUrl))) {
                File::delete(public_path($room->ImageUrl));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/rooms'), $filename);
            $data['ImageUrl'] = 'images/rooms/' . $filename;
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật phòng thành công!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        
        // Cảnh báo: trong thực tế cần kiểm tra xem phòng có hóa đơn/đặt phòng không trước khi xóa
        
        if ($room->ImageUrl && File::exists(public_path($room->ImageUrl))) {
            File::delete(public_path($room->ImageUrl));
        }
        
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Xóa phòng thành công!');
    }
}
