const API_URL = 'http://localhost:8080/api/rooms/map';

document.addEventListener('DOMContentLoaded', () => {
    fetchRoomMap();
});

async function fetchRoomMap() {
    const grid = document.getElementById('room-grid');
    const spinner = document.getElementById('loading-spinner');
    
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error('Failed to fetch');
        const rooms = await response.json();
        
        spinner.style.display = 'none';

        if (!rooms || rooms.length === 0) {
            grid.innerHTML = `<div class="w-100 text-center py-5 text-muted">Không có dữ liệu phòng.</div>`;
            return;
        }

        grid.innerHTML = rooms.map(room => {
        let statusClass = '';
        let actionHtml = '';

        if (room.maTrangThai === 1) { // Trống
            statusClass = 'status-empty';
            actionHtml = `
                <a href="../../admin/check-in/index.html?roomId=${room.id}" class="btn btn-success btn-action py-1">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Check-In
                </a>
            `;
        } else if (room.maTrangThai === 2) { // Đang ở
            statusClass = 'status-occupied';
            actionHtml = `
                <a href="../../admin/check-out/index.html?roomId=${room.id}" class="btn btn-danger btn-action py-1">
                    <i class="bi bi-box-arrow-left me-1"></i>Check-Out
                </a>
            `;
        } else { // Chờ dọn dẹp
            statusClass = 'status-dirty';
            actionHtml = `
                <button class="btn btn-warning text-dark btn-action py-1" disabled>
                    <i class="bi bi-hourglass-split me-1"></i>Chờ dọn dẹp...
                </button>
            `;
        }

        const priceFormatted = new Intl.NumberFormat('vi-VN').format(room.price || 0) + ' VNĐ';
        
        return `
        <div class="room-card p-3 d-flex flex-column justify-content-between ${statusClass}">
            <div>
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold text-dark m-0">Phòng ${room.id}</h5>
                    <span class="badge bg-light text-dark border fw-bold">${room.maLoai || 'Loại 1'}</span>
                </div>
                <p class="text-muted small mt-1 mb-2">${priceFormatted}</p>
            </div>
            <div class="mt-3">
                ${actionHtml}
            </div>
        </div>
        `;
    }).join('');
    
    } catch (error) {
        console.error('Error fetching room map:', error);
        spinner.style.display = 'none';
        grid.innerHTML = `
            <div class="w-100 text-center py-5 text-danger">
                <i class="bi bi-exclamation-triangle fs-2 d-block mb-2 opacity-50"></i>
                <p>Lỗi kết nối API lấy sơ đồ phòng. Hãy đảm bảo API ${API_URL} đang hoạt động.</p>
            </div>
        `;
    }
}
