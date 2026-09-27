<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class AdminCategoryController extends Controller
{
    public function index()
    {
        // Tính số lượng phòng của mỗi loại để hiển thị
        $categories = RoomType::withCount(['rooms as so_luong_phong' => function($query) {
            $query->select(\DB::raw('count(*)'));
        }])->get();
        
        // Tuy nhiên do chưa cấu hình relationship chuẩn trong Model, ta query manual
        $categories = RoomType::all();
        foreach($categories as $category) {
            $category->so_luong_phong = Room::where('MaLoai', $category->MaLoai)->count();
        }
            
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'SoNguoi' => 'required|integer|min:1'
        ]);

        RoomType::create($request->all());

        return redirect()->route('admin.category.index')->with('success', 'Thêm loại phòng thành công!');
    }

    public function edit($id)
    {
        $category = RoomType::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'SoNguoi' => 'required|integer|min:1'
        ]);

        $category = RoomType::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.category.index')->with('success', 'Cập nhật loại phòng thành công!');
    }

    public function destroy($id)
    {
        $category = RoomType::findOrFail($id);
        
        // Kiểm tra xem có phòng nào đang dùng loại này không
        $roomCount = Room::where('MaLoai', $id)->count();
        if ($roomCount > 0) {
            return redirect()->route('admin.category.index')->with('error', 'Không thể xóa loại phòng đang được sử dụng!');
        }
        
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Xóa loại phòng thành công!');
    }
}
