<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Role;

class AdminUserController extends Controller
{
    public function index()
    {
        // Join with Role table if it exists, or just pass Accounts
        $users = Account::all();
        // Assuming we need roles for display (Admin, Lễ tân, Khách hàng, vv)
        // If there's no Role relation, we map manually in view.
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string|max:255|unique:Account,TenDangNhap',
            'MatKhau' => 'required|string|min:6',
            'HoTen' => 'required|string|max:255',
            'RoleID' => 'required|integer',
            'TrangThai' => 'required|integer'
        ]);

        $data = $request->all();
        Account::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
    }

    public function edit($id)
    {
        $user = Account::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Account::findOrFail($id);

        $request->validate([
            'TenDangNhap' => 'required|string|max:255|unique:Account,TenDangNhap,' . $id . ',IDTaiKhoan',
            'MatKhau' => 'nullable|string|min:6',
            'HoTen' => 'required|string|max:255',
            'RoleID' => 'required|integer',
            'TrangThai' => 'required|integer'
        ]);

        $data = $request->except('MatKhau');
        if ($request->filled('MatKhau')) {
            $data['MatKhau'] = $request->MatKhau;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function destroy($id)
    {
        $user = Account::findOrFail($id);
        
        // Prevent deleting own account
        if (auth()->id() == $id) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản đang đăng nhập!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công!');
    }
}
