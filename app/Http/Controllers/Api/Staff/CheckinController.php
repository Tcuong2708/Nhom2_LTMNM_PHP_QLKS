<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Invoice;
use App\Models\Room;
use Illuminate\Http\Request;

class CheckinController
{
    // Lấy danh sách hóa đơn chờ check-in
    public function getPendingCheckins()
    {
        // Điều kiện: Chưa có phòng HOẶC chưa thanh toán (tùy vào logic thực tế)
        // Dùng tạm điều kiện MaPhong = null hoặc DaThanhToan = 0
        $invoices = Invoice::whereNull('MaPhong')
            ->orWhere('DaThanhToan', 0)
            ->get()->map(function ($invoice) {
                return [
                    'id' => $invoice->MaHD,
                    'hoTen' => $invoice->HoTen,
                    'idTaiKhoan' => $invoice->IDTaiKhoan,
                    'sdt' => $invoice->DienThoai,
                    'ngayCheckIn' => $invoice->NgayNhan,
                    'ngayCheckOut' => $invoice->NgayTra,
                    'totalPrice' => $invoice->TongTien,
                    'maPhong' => $invoice->MaPhong
                ];
            });
            
        // MOCK DATA: Giả lập thêm dữ liệu mẫu nếu database đang trống hoặc không có data hợp lệ
        if ($invoices->isEmpty()) {
            $invoices = [
                ['id' => 998, 'hoTen' => 'Khách Vãng Lai Mock 1', 'idTaiKhoan' => null, 'sdt' => '0999999999', 'ngayCheckIn' => date('Y-m-d'), 'ngayCheckOut' => date('Y-m-d', strtotime('+2 days')), 'totalPrice' => 1000000, 'maPhong' => null],
                ['id' => 999, 'hoTen' => 'Khách Vãng Lai Mock 2', 'idTaiKhoan' => 1, 'sdt' => '0888888888', 'ngayCheckIn' => date('Y-m-d'), 'ngayCheckOut' => date('Y-m-d', strtotime('+1 days')), 'totalPrice' => 500000, 'maPhong' => null],
            ];
        }

        return response()->json($invoices);
    }

    // Thực hiện check-in cho 1 hóa đơn
    public function executeCheckin(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            // Hỗ trợ xử lý MOCK DATA id > 900
            if ($id >= 900) {
                return response()->json(['message' => 'Check-in (Mock Data) thành công!']);
            }
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

        $maPhong = $request->input('maPhong');
        $isPaidUpfront = $request->input('isPaidUpfront', false);

        // 1. Cập nhật phòng cho hóa đơn
        $invoice->MaPhong = $maPhong;

        // 2. Cập nhật ghi chú
        $invoice->GhiChu = ($invoice->GhiChu ? $invoice->GhiChu . ' | ' : '') . '[STAFF] Đã làm thủ tục Check-in nhận phòng.';

        // 3. Thu trước 1 đêm nếu cần
        if ($isPaidUpfront) {
            $room = Room::find($maPhong);
            if ($room) {
                $invoice->GhiChu .= ' | [ĐÃ THU TRƯỚC 1 ĐÊM] Số tiền: ' . number_format($room->Price, 0, ',', '.') . ' VNĐ';
            }
        }
        $invoice->save();

        // 4. Cập nhật trạng thái phòng -> "Đang có khách" (MaTrangThai = 2)
        if ($maPhong) {
            Room::where('ID', $maPhong)->update(['MaTrangThai' => 2]);
        }

        return response()->json(['message' => 'Check-in thành công!']);
    }

    public function search(Request $request)
    {
        // MOCK DATA: Chức năng tra cứu
        $code = $request->input('code');
        return response()->json([
            'hoTen' => 'Khách hàng Demo',
            'ngayCheckIn' => date('Y-m-d\TH:i:s'),
            'ngayCheckOut' => date('Y-m-d\TH:i:s', strtotime('+2 days')),
            'trangThai' => 'PAID'
        ]);
    }
}
