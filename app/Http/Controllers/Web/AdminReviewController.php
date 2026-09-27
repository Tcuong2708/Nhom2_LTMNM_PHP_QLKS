<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::leftJoin('Account', 'DanhGia.User_ID', '=', 'Account.IDTaiKhoan')
            ->select('DanhGia.*', 'Account.HoTen as NguoiDanhGia')
            ->orderBy('DanhGia.id', 'desc')
            ->get();
            
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá!');
    }
}
