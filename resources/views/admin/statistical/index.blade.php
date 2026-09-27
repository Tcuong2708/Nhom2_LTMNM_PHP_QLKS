@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/statistical-assets/css/index.css') }}">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container py-4">

    <div class="admin-card mb-4 shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="admin-header d-flex justify-content-center align-items-center py-3" style="background-color: var(--navy-color); color: white;">
            <h3 class="fw-bold text-uppercase mb-0">
                <i class="bi bi-bar-chart-fill me-2 text-gold"></i>Thống kê kinh doanh năm <span id="current-year">...</span>
            </h3>
        </div>
        <div class="card-body p-4 bg-white">

            <div id="loading-spinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-2">Đang tải dữ liệu thống kê...</p>
            </div>

            <div id="dashboard-content" style="display: none;">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white mb-3 h-100 shadow-sm border-0">
                            <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                                <h5 class="card-title opacity-75 small text-uppercase fw-bold">Tổng Doanh Thu Năm</h5>
                                <h2 class="fw-bold mt-2" id="total-revenue">0 đ</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3 h-100 shadow-sm border-0">
                            <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                                <h5 class="card-title opacity-75 small text-uppercase fw-bold">Tổng Đơn Đặt Phòng</h5>
                                <h2 class="fw-bold mt-2" id="total-orders">0 đơn</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-dark mb-3 h-100 shadow-sm border-0" style="background-color: var(--gold-color);">
                            <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                                <h5 class="card-title opacity-75 small text-uppercase fw-bold">Trung bình / Tháng</h5>
                                <h2 class="fw-bold mt-2 text-white" id="average-month">0 đ</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header fw-bold py-3 bg-white" style="color: var(--navy-color, #0F2942); border-bottom: 2px solid var(--gold-color);">
                        <i class="bi bi-bar-chart-line-fill me-2" style="color: #C5A017;"></i>Biểu đồ doanh thu từng tháng
                    </div>
                    <div class="card-body p-4">
                        <div style="position: relative; height:380px; width:100%">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div id="error-message" class="alert alert-danger text-center mt-4" style="display: none;">
                <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                Không thể tải dữ liệu thống kê. Vui lòng kiểm tra lại kết nối Backend.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const currentYear = new Date().getFullYear();
    document.getElementById('current-year').textContent = currentYear;
    
    // Giả lập Dữ liệu vì Controller hiện tại chưa truyền dữ liệu
    setTimeout(() => {
        const mockData = {
            nam: currentYear,
            tongDoanhThu: 1545000000,
            tongSoDon: 432,
            trungBinhThang: 128750000,
            doanhThuArr: [85000000, 92000000, 115000000, 140000000, 165000000, 180000000, 195000000, 160000000, 130000000, 110000000, 95000000, 78000000],
            soDonArr: [25, 28, 35, 42, 50, 55, 60, 48, 38, 30, 26, 22]
        };
        renderDashboard(mockData);
    }, 500); // Giả lập loading
});

function renderDashboard(data) {
    document.getElementById('loading-spinner').style.display = 'none';
    document.getElementById('dashboard-content').style.display = 'block';

    const formatCurrency = (value) => new Intl.NumberFormat('vi-VN').format(value || 0) + ' đ';
    
    document.getElementById('total-revenue').textContent = formatCurrency(data.tongDoanhThu);
    document.getElementById('total-orders').textContent = (data.tongSoDon || 0) + ' đơn';
    document.getElementById('average-month').textContent = formatCurrency(data.trungBinhThang);

    renderChart(data.doanhThuArr, data.soDonArr);
}

function renderChart(revenueData, orderData) {
    const ctxElement = document.getElementById('myChart');
    if (!ctxElement) return;

    new Chart(ctxElement, {
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [
                {
                    type: 'bar',
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: 'rgba(15, 41, 66, 0.85)',
                    borderColor: '#0F2942',
                    borderWidth: 1,
                    borderRadius: 4,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Số đơn đặt',
                    data: orderData,
                    borderColor: '#C5A017',
                    backgroundColor: '#C5A017',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.15,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let labelText = context.dataset.label || '';
                            if (labelText) { labelText += ': '; }
                            if (context.datasetIndex === 0) {
                                labelText += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                            } else {
                                labelText += context.parsed.y + ' đơn';
                            }
                            return labelText;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear', display: true, position: 'left', beginAtZero: true,
                    title: { display: true, text: 'Doanh thu (VNĐ)', font: { weight: 'bold' } },
                    ticks: { callback: function(value) { return new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(value) + ' đ'; } }
                },
                y1: {
                    type: 'linear', display: true, position: 'right', beginAtZero: true, grid: { drawOnChartArea: false },
                    title: { display: true, text: 'Số lượng đơn đặt', font: { weight: 'bold' } },
                    ticks: { stepSize: 1, callback: function(value) { return value + ' đơn'; } }
                }
            }
        }
    });
}
</script>
@endpush
