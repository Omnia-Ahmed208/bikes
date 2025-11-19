<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>iSky Device Management - لوحة تحكم الأجهزة</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .device-card {
            transition: all 0.3s ease;
            border-left: 4px solid #6c757d;
        }
        .device-card.online {
            border-left-color: #28a745;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
        }
        .device-card.offline {
            border-left-color: #dc3545;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.1);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .refresh-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
        .device-controls {
            display: none;
        }
        .device-card.online .device-controls {
            display: block;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-microchip text-primary"></i>
                        لوحة تحكم أجهزة iSky
                    </h1>
                    <div>
                        <span class="badge bg-info me-2" id="total-devices">إجمالي: 0</span>
                        <span class="badge bg-success me-2" id="online-devices">متصل: 0</span>
                        <span class="badge bg-danger" id="offline-devices">غير متصل: 0</span>
                    </div>
                </div>

                <!-- Refresh Button -->
                <button class="btn btn-primary refresh-btn" onclick="refreshAllDevices()">
                    <i class="fas fa-sync-alt" id="refresh-icon"></i>
                    تحديث
                </button>

                <!-- Server Status -->
                <div class="alert alert-info" id="server-status">
                    <i class="fas fa-server"></i>
                    حالة السيرفر: <span id="server-status-text">جاري التحقق...</span>
                </div>

                <!-- Devices Grid -->
                <div class="row" id="devices-container">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-2">جاري تحميل الأجهزة...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Detail Modal -->
    <div class="modal fade" id="deviceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تفاصيل الجهاز: <span id="modal-hostname"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-content">
                    <!-- Content loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let refreshInterval;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            refreshAllDevices();

            // Auto refresh every 30 seconds
            refreshInterval = setInterval(refreshAllDevices, 30000);
        });

        // Refresh all devices
        async function refreshAllDevices() {
            const refreshIcon = document.getElementById('refresh-icon');
            const container = document.getElementById('devices-container');

            refreshIcon.classList.add('fa-spin');
            container.classList.add('loading');

            try {
                const response = await fetch('/devices/check-all');
                const data = await response.json();

                updateServerStatus(data.server_status);
                updateDeviceStats(data.total_devices, data.online_devices, data.total_devices - data.online_devices);
                renderDevices(data.devices);

            } catch (error) {
                console.error('Error refreshing devices:', error);
                updateServerStatus('offline');
                showError('خطأ في الاتصال بالسيرفر');
            } finally {
                refreshIcon.classList.remove('fa-spin');
                container.classList.remove('loading');
            }
        }

        // Update server status
        function updateServerStatus(status) {
            const statusElement = document.getElementById('server-status');
            const statusText = document.getElementById('server-status-text');

            if (status === 'online') {
                statusElement.className = 'alert alert-success';
                statusText.textContent = 'متصل';
            } else {
                statusElement.className = 'alert alert-danger';
                statusText.textContent = 'غير متصل';
            }
        }

        // Update device statistics
        function updateDeviceStats(total, online, offline) {
            document.getElementById('total-devices').textContent = `إجمالي: ${total}`;
            document.getElementById('online-devices').textContent = `متصل: ${online}`;
            document.getElementById('offline-devices').textContent = `غير متصل: ${offline}`;
        }

        // Render devices
        function renderDevices(devices) {
            const container = document.getElementById('devices-container');

            if (!devices || Object.keys(devices).length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h4>لا توجد أجهزة مسجلة</h4>
                        <p class="text-muted">تأكد من تسجيل الأجهزة في النظام</p>
                    </div>
                `;
                return;
            }

            let html = '';
            Object.entries(devices).forEach(([hostname, device]) => {
                const statusClass = device.status === 'online' ? 'online' : 'offline';
                const statusColor = device.status === 'online' ? 'success' : 'danger';
                const statusIcon = device.status === 'online' ? 'check-circle' : 'times-circle';

                html += `
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card device-card ${statusClass}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">${hostname}</h6>
                                <span class="badge bg-${statusColor} status-badge">
                                    <i class="fas fa-${statusIcon}"></i>
                                    ${device.status === 'online' ? 'متصل' : 'غير متصل'}
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>IP:</strong> ${device.current_ip}<br>
                                    <strong>SSH Tunnel:</strong>
                                    <span class="badge bg-${device.ssh_tunnel === 'active' ? 'success' : 'warning'}">
                                        ${device.ssh_tunnel || 'unknown'}
                                    </span><br>
                                    <strong>آخر اتصال:</strong> ${device.last_seen ? new Date(device.last_seen).toLocaleString('ar') : 'غير معروف'}
                                </p>

                                <div class="device-controls">
                                    <div class="btn-group w-100 mb-2" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="getDeviceDetails('${hostname}')">
                                            <i class="fas fa-info-circle"></i> تفاصيل
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="getDeviceGPS('${hostname}')">
                                            <i class="fas fa-map-marker-alt"></i> GPS
                                        </button>
                                    </div>

                                    <div class="btn-group w-100" role="group">
                                        <button class="btn btn-sm btn-success" onclick="controlRelay('${hostname}', 'on')">
                                            <i class="fas fa-power-off"></i> تشغيل
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="controlRelay('${hostname}', 'off')">
                                            <i class="fas fa-power-off"></i> إيقاف
                                        </button>
                                    </div>
                                </div>

                                ${device.error ? `<div class="alert alert-danger mt-2 mb-0"><small>${device.error}</small></div>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Get device details
        async function getDeviceDetails(hostname) {
            try {
                const response = await fetch(`/devices/${hostname}/status`);
                const data = await response.json();

                if (data.success) {
                    showDeviceModal(hostname, data);
                } else {
                    showError(`فشل في الحصول على تفاصيل ${hostname}`);
                }
            } catch (error) {
                showError(`خطأ في الاتصال بـ ${hostname}`);
            }
        }

        // Get device GPS
        async function getDeviceGPS(hostname) {
            try {
                const response = await fetch(`/devices/${hostname}/gps`);
                const data = await response.json();

                if (data.success) {
                    showGPSModal(hostname, data);
                } else {
                    showError(`فشل في الحصول على موقع ${hostname}`);
                }
            } catch (error) {
                showError(`خطأ في الحصول على موقع ${hostname}`);
            }
        }

        // Control relay
        async function controlRelay(hostname, action) {
            try {
                const response = await fetch(`/devices/${hostname}/relay`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ action: action })
                });

                const data = await response.json();

                if (data.success) {
                    showSuccess(`تم ${action === 'on' ? 'تشغيل' : 'إيقاف'} الريلاي في ${hostname}`);
                } else {
                    showError(`فشل في التحكم بالريلاي في ${hostname}`);
                }
            } catch (error) {
                showError(`خطأ في التحكم بالريلاي في ${hostname}`);
            }
        }

        // Show device modal
        function showDeviceModal(hostname, data) {
            document.getElementById('modal-hostname').textContent = hostname;

            const content = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الجهاز</h6>
                        <table class="table table-sm">
                            <tr><td>اسم الجهاز:</td><td>${data.device_name}</td></tr>
                            <tr><td>الموقع:</td><td>${data.location}</td></tr>
                            <tr><td>IP الحالي:</td><td>${data.current_ip}</td></tr>
                            <tr><td>حالة SSH:</td><td>${data.ssh_tunnel}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>موقع GPS</h6>
                        <table class="table table-sm">
                            <tr><td>خط العرض:</td><td>${data.gps?.latitude || 'غير متاح'}</td></tr>
                            <tr><td>خط الطول:</td><td>${data.gps?.longitude || 'غير متاح'}</td></tr>
                            <tr><td>الارتفاع:</td><td>${data.gps?.altitude || 'غير متاح'} م</td></tr>
                            <tr><td>الأقمار:</td><td>${data.gps?.satellites || 'غير متاح'}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>البطارية</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar ${data.battery?.current_voltage > 3.5 ? 'bg-success' : 'bg-warning'}"
                                 style="width: ${(data.battery?.current_voltage / 4.2) * 100}%">
                                ${data.battery?.current_voltage || 'غير متاح'} V
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>الوحدات المتاحة</h6>
                        <div class="d-flex flex-wrap gap-1">
                            ${Object.entries(data.modules || {}).map(([module, info]) =>
                                `<span class="badge bg-${info.status === 'active' || info.available ? 'success' : 'secondary'}">${module}</span>`
                            ).join('')}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('modal-content').innerHTML = content;
            new bootstrap.Modal(document.getElementById('deviceModal')).show();
        }

        // Show GPS modal
        function showGPSModal(hostname, data) {
            document.getElementById('modal-hostname').textContent = `${hostname} - موقع GPS`;

            const content = `
                <div class="text-center">
                    <h4>الموقع الحالي</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">خط العرض</h5>
                                    <h3 class="text-primary">${data.lat}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">خط الطول</h5>
                                    <h3 class="text-primary">${data.lon}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <strong>الارتفاع:</strong> ${data.altitude} م
                        </div>
                        <div class="col-md-4">
                            <strong>السرعة:</strong> ${data.speed} كم/س
                        </div>
                        <div class="col-md-4">
                            <strong>الأقمار:</strong> ${data.satellites}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="https://www.google.com/maps?q=${data.lat},${data.lon}"
                           target="_blank" class="btn btn-primary">
                            <i class="fas fa-map"></i> عرض على الخريطة
                        </a>
                    </div>
                </div>
            `;

            document.getElementById('modal-content').innerHTML = content;
            new bootstrap.Modal(document.getElementById('deviceModal')).show();
        }

        // Show success message
        function showSuccess(message) {
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-check-circle"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);

            // Auto remove after 3 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert-success');
                if (alert) alert.remove();
            }, 3000);
        }

        // Show error message
        function showError(message) {
            const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-exclamation-triangle"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);

            // Auto remove after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert-danger');
                if (alert) alert.remove();
            }, 5000);
        }

        // Clear auto refresh on page unload
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</body>
</html>
