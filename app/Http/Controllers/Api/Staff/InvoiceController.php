<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Invoice;
use App\Models\Room;
use Illuminate\Http\Request;

class InvoiceController
{
    public function index()
    {
        $invoices = Invoice::all()->map(function ($invoice) {
            return [
                'id' => $invoice->MaHD,
                'hoTen' => $invoice->HoTen,
                'sdt' => $invoice->DienThoai,
                'ngayDat' => $invoice->NgayDat ?? $invoice->NgayNhan, // Mocking NgayDat nếu bảng không có giá trị
                'ngayCheckIn' => $invoice->NgayNhan,
                'ngayCheckOut' => $invoice->NgayTra,
                'totalPrice' => $invoice->TongTien
            ];
        });

        // MOCK DATA: Chèn dữ liệu mẫu nếu CSDL không đủ
        if ($invoices->isEmpty()) {
            $invoices = [
                 ['id' => 991, 'hoTen' => 'Nguyễn Mock 1', 'sdt' => '0901234567', 'ngayDat' => date('Y-m-d'), 'ngayCheckIn' => date('Y-m-d'), 'ngayCheckOut' => date('Y-m-d', strtotime('+2 days')), 'totalPrice' => 3600000],
                 ['id' => 992, 'hoTen' => 'Trần Mock 2', 'sdt' => '0987654321', 'ngayDat' => date('Y-m-d'), 'ngayCheckIn' => date('Y-m-d'), 'ngayCheckOut' => date('Y-m-d', strtotime('-1 days')), 'totalPrice' => 2400000],
            ];
        }

        return response()->json($invoices);
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => 'Invoice Mock Data Details'], 200);
        }
        return response()->json($invoice);
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            // Giải phóng phòng về "Trống" (MaTrangThai = 1) nếu có
            if ($invoice->MaPhong) {
                Room::where('ID', $invoice->MaPhong)->update(['MaTrangThai' => 1]);
            }
            $invoice->delete();
            return response()->json(['message' => 'Xoá thành công!']);
        }
        
        return response()->json(['message' => 'Không tìm thấy hóa đơn cần xóa!'], 404);
    }
}
