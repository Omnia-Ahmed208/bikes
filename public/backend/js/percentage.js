'use strict';

function renderBarChart(elementId, labels, data, barColor, isRtl = false) {
    const chartElement = document.getElementById(elementId);
    if (!chartElement) {
        console.error('Chart element not found:', elementId);
        return null;
    }

    // Color Variables
    let cardColor, headingColor, labelColor, borderColor, legendColor;
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.labelColor;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;

    const ctx = chartElement.getContext("2d");

    // تدمير الشارت السابق إذا كان موجود
    if (chartElement.chart) {
        chartElement.chart.destroy();
    }

    // عكس ترتيب البيانات والتسميات في RTL
    const processedLabels = isRtl ? [...labels].reverse() : labels;
    const processedData = isRtl ? [...data].reverse() : data;

    // حساب الـ max ديناميكياً مع هامش
    const maxDataValue = Math.max(...data);
    const suggestedMax = maxDataValue === 0 ? 10 : Math.ceil(maxDataValue * 1.2);

    const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: processedLabels,
            datasets: [
                {
                    data: processedData,
                    backgroundColor: barColor,
                    borderColor: 'transparent',
                    maxBarThickness: 15,
                    borderRadius: {
                        topRight: 0,
                        topLeft: 0
                    }
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 500
            },
            aspectRatio: false,
            rtl: isRtl,
            plugins: {
                tooltip: {
                    enabled: false,
                    external: function(context) {
                        // Custom tooltip function
                        const { chart, tooltip } = context;

                        // إنشاء عنصر tooltip إذا لم يكن موجود
                        let tooltipEl = chart.canvas.parentNode.querySelector('.chartjs-custom-tooltip');
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.className = 'chartjs-custom-tooltip';
                            tooltipEl.style.position = 'absolute';
                            tooltipEl.style.pointerEvents = 'none';
                            tooltipEl.style.transition = 'all 0.2s ease';
                            chart.canvas.parentNode.appendChild(tooltipEl);
                        }

                        // إخفاء tooltip إذا لم يعد مطلوب
                        if (tooltip.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }

                        // إنشاء محتوى tooltip
                        if (tooltip.body) {
                            const dataPoint = tooltip.dataPoints[0];
                            const label = dataPoint.label;
                            const value = dataPoint.parsed.y;

                            tooltipEl.innerHTML = `
                                <div class="apexcharts-custom-tooltip bg-primary text-white rounded px-2 py-1 d-flex align-items-center" style="
                                    background-color: #3563AD !important;
                                    color: white !important;
                                    padding: 6px 12px !important;
                                    border-radius: 6px !important;
                                    font-size: 12px !important;
                                    font-weight: 500 !important;
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
                                    white-space: nowrap !important;
                                    direction: ${isRtl ? 'rtl' : 'ltr'} !important;
                                ">
                                    <span>${label}: ${value}</span>
                                </div>
                            `;
                        }

                        // تحديد موضع tooltip
                        const { offsetLeft: positionX, offsetTop: positionY } = chart.canvas;

                        // حساب الموضع مع مراعاة RTL
                        let tooltipX = positionX + tooltip.caretX;
                        let tooltipY = positionY + tooltip.caretY;

                        // تعديل الموضع في RTL
                        if (isRtl) {
                            tooltipX = tooltipX - tooltipEl.offsetWidth - 10;
                        } else {
                            tooltipX = tooltipX + 10;
                        }

                        tooltipY = tooltipY - tooltipEl.offsetHeight - 10;

                        // تطبيق الموضع والشفافية
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = tooltipX + 'px';
                        tooltipEl.style.top = tooltipY + 'px';
                        tooltipEl.style.zIndex = 9999;
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    reverse: isRtl,
                    grid: {
                        color: borderColor,
                        drawBorder: false,
                        borderColor: borderColor
                    },
                    ticks: {
                        color: labelColor,
                        maxRotation: 45,
                        minRotation: 0,
                        align: isRtl ? 'end' : 'center',
                        autoSkip: false,
                    }
                },
                y: {
                    position: isRtl ? 'right' : 'left',
                    min: 0,
                    max: suggestedMax,
                    grid: {
                        color: borderColor,
                        drawBorder: false,
                        borderColor: borderColor
                    },
                    ticks: {
                        color: labelColor,
                        align: isRtl ? 'end' : 'start',
                        precision: 0,
                        stepSize: Math.ceil(suggestedMax / 5) // خطوات ديناميكية
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: isRtl ? 20 : 5,
                    right: isRtl ? 5 : 20
                }
            }
        }
    });

    // حفظ مرجع للشارت لتدميره لاحقاً
    chartElement.chart = barChart;

    // إضافة CSS للـ canvas لدعم RTL
    if (isRtl) {
        chartElement.style.direction = 'rtl';
        chartElement.parentElement.style.direction = 'rtl';
    } else {
        chartElement.style.direction = 'ltr';
        chartElement.parentElement.style.direction = 'ltr';
    }

    return barChart;
}
