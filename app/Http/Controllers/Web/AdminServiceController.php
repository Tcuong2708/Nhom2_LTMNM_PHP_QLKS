<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenDV' => 'required|string|max:255',
            'GiaTien' => 'required|numeric|min:0',
            'DonVi' => 'required|string|max:50'
        ]);

        Service::create($request->all());

        return redirect()->route('admin.service.index')->with('success', 'Thêm dịch vụ thành công!');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TenDV' => 'required|string|max:255',
            'GiaTien' => 'required|numeric|min:0',
            'DonVi' => 'required|string|max:50'
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('admin.service.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Cần kiểm tra xem dịch vụ có đang được sử dụng trong hóa đơn không
        // Nếu có thì không nên xóa. Ở đây ta tạm xóa luôn hoặc có thể soft delete.
        $service->delete();

        return redirect()->route('admin.service.index')->with('success', 'Xóa dịch vụ thành công!');
    }
}
