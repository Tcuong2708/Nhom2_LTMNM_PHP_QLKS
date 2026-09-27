const API_URL = 'http://localhost:8080/api/invoices';

document.addEventListener('DOMContentLoaded', () => {
    fetchInvoices();
});

function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
}

async function fetchInvoices() {
    const tbody = document.getElementById('invoice-table-body');
    try {
        const response = await fetch(`${API_URL}`);
        if (!response.ok) throw new Error('Network response was not ok');
        const rawInvoices = await response.json();
        
        const invoices = rawInvoices.map(inv => ({
            id: inv.MaHD,
            hoTen: inv.HoTen,
            sdt: inv.DienThoai,
            ngayDat: inv.created_at ? inv.created_at.split('T')[0] : 'N/A',
            ngayCheckIn: inv.NgayNhan,
            ngayCheckOut: inv.NgayTra,
            totalPrice: inv.TongTien
        }));
        
        if (!invoices || invoices.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-clipboard-x text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Chưa có dữ liệu đơn đặt phòng nào.</p>
                    </td>
                </tr>
            `;
            return;
        }

        const today = new Date();

        tbody.innerHTML = invoices.map(item => {
            const priceFormatted = new Intl.NumberFormat('vi-VN').format(item.totalPrice || 0) + ' đ';
            const ngayCheckOutDate = new Date(item.ngayCheckOut);
            
            let statusHtml = '';
            if (ngayCheckOutDate < today) {
                statusHtml = '<span class="status-badge status-completed">Đã trả phòng</span>';
            } else {
                statusHtml = '<span class="status-badge status-active">Đang lưu trú</span>';
            }

            return `
            <tr>
                <td class="text-center fw-bold">#${item.id}</td>
                <td class="text-center">
                    <div class="d-flex flex-column align-items-center">
                        <span class="fw-bold text-navy">${item.hoTen}</span>
                        <small class="text-muted">
                            <i class="bi bi-telephone-fill me-1" style="font-size: 0.7rem"></i>
                            ${item.sdt || ''}
                        </small>
                    </div>
                </td>
                <td class="text-center text-muted small">${item.ngayDat || ''}</td>
                <td class="text-center">
                    <div class="d-flex flex-column align-items-center small">
                        <span><i class="bi bi-box-arrow-in-right text-success me-1"></i> ${item.ngayCheckIn || ''}</span>
                        <span><i class="bi bi-box-arrow-left text-danger me-1"></i> ${item.ngayCheckOut || ''}</span>
                    </div>
                </td>
                <td class="text-center fw-bold fs-6 text-gold">${priceFormatted}</td>
                <td class="text-center">${statusHtml}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="/admin/invoice/details?id=${item.id}" class="btn btn-sm btn-info text-white shadow-sm" title="Xem chi tiết">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/admin/invoice/print?id=${item.id}" target="_blank" class="btn btn-sm btn-success text-white shadow-sm mx-1" title="In hóa đơn">
                            <i class="bi bi-printer"></i>
                        </a>
                        <a href="/admin/invoice/delete?id=${item.id}" class="btn btn-sm btn-danger shadow-sm ms-1" title="Xóa vĩnh viễn">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            `;
        }).join('');

    } catch (error) {
        console.error('Error fetching invoices:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5 text-danger">
                    <i class="bi bi-exclamation-triangle fs-2 d-block mb-2 opacity-50"></i>
                    <p>Lỗi kết nối API. Vui lòng kiểm tra lại Backend.</p>
                </td>
            </tr>
        `;
    }
}
