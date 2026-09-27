<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Invoice;
use App\Models\Room;
use Illuminate\Http\Request;

class CheckoutController
{
    public function getActiveInvoices()
    {
        // Lấy những hóa đơn đang có phòng (nghĩa là đã check-in) và chưa check-out
        // Logic phụ thuộc cách quản lý dữ liệu thực tế (VD GhiChu chưa có Check-out)
        $invoices = Invoice::whereNotNull('MaPhong')
            ->where('GhiChu', 'like', '%Check-in%')
            ->where('GhiChu', 'not like', '%Check-out%')
            ->get()->map(function ($invoice) {
                return [
                    'id' => $invoice->MaHD,
                    'hoTen' => $invoice->HoTen,
                    'maPhong' => $invoice->MaPhong,
                    'ngayCheckIn' => $invoice->NgayNhan,
                    'ngayCheckOut' => $invoice->NgayTra,
                    'ghiChu' => $invoice->GhiChu
                ];
            });
            
        // MOCK DATA: Đảm bảo có dữ liệu cho frontend nếu DB trống
        if ($invoices->isEmpty()) {
            $invoices = [
                ['id' => 997, 'hoTen' => 'Mock Client (Đang lưu trú)', 'maPhong' => 101, 'ngayCheckIn' => date('Y-m-d', strtotime('-1 days')), 'ngayCheckOut' => date('Y-m-d'), 'ghiChu' => '[STAFF] Đã làm thủ tục Check-in nhận phòng.'],
            ];
        }

        return response()->json($invoices);
    }

    public function executeCheckout(Request $request)
    {
        $id = $request->input('maHD');
        $phuThu = $request->input('phuThu', 0);

        $invoice = Invoice::find($id);
        if (!$invoice) {
            // Xử lý fallback cho MOCK DATA
            if ($id == 997) {
                return response()->json(['message' => 'Trả phòng (Mock Data) thành công!']);
            }
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

        // Cập nhật hóa đơn
        $invoice->PhuThu = $phuThu;
        $invoice->DaThanhToan = 1;
        $invoice->GhiChu = ($invoice->GhiChu ? $invoice->GhiChu . ' | ' : '') . '[STAFF] Đã làm thủ tục Check-out bàn giao phòng.';
        $invoice->save();

        // Giải phóng phòng thành "Đang dọn dẹp" (MaTrangThai = 3)
        if ($invoice->MaPhong) {
            Room::where('ID', $invoice->MaPhong)->update(['MaTrangThai' => 3]);
        }

        return response()->json(['message' => 'Trả phòng và kết toán thành công!']);
    }
}
