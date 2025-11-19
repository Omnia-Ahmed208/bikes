'use strict';

function renderMiniChart(elementId, data = [], color = "#3563AD") {
  if (!document.querySelector(elementId)) return;

  let cardColor = config.colors.white;
  let headingColor = config.colors.headingColor;
  let axisColor = config.colors.axisColor;
  let borderColor = config.colors.borderColor;

  const chartConfig = {
    chart: {
      height: 80,
      width: 120,
      type: 'line',
      toolbar: { show: false },
      dropShadow: {
        enabled: false,
        top: 10,
        left: 5,
        blur: 3,
        color: color,
        opacity: 0.15
      },
      sparkline: { enabled: true }
    },
    grid: {
      show: false,
      padding: { right: 8 }
    },
    colors: [color],
    dataLabels: { enabled: false },
    stroke: {
      width: 2,
      curve: 'smooth'
    },
    series: [
      {
        data: data
      }
    ],
    xaxis: {
      show: false,
      lines: { show: false },
      labels: { show: false },
      axisBorder: { show: false }
    },
    yaxis: { show: false }
  };

  const chart = new ApexCharts(document.querySelector(elementId), chartConfig);
  chart.render();
}


// Function to render Line Chart
function renderLineChart(elementId, labels = [], dataset = [], isRtl = false, colors) {
    const lineChartEl = document.querySelector(elementId);

    if (!lineChartEl) {
        console.error('Chart element not found:', elementId);
        return null;
    }

    // Clear the container
    lineChartEl.innerHTML = '';

    let allData = dataset.flatMap(ds => ds.data);
    let maxY = allData.length ? Math.max(...allData) + 100 : 300;

    const lineChartConfig = {
        chart: {
            height: 300,
            type: 'line',
            parentHeightOffset: 0,
            zoom: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'Noto, sans-serif'
        },
        series: dataset,
        legend: { show: false },
        markers: {
            size: 0,
            strokeWidth: 4,
            strokeOpacity: 0,
            colors: ['#fff'],
            strokeColors: colors ?? ['#3563AD', '#28A745'],
            hover: { size: 6 }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'straight' },
        colors: colors ?? ['#3563AD', '#28A745'],
        grid: {
            borderColor: config.colors.borderColor,
            xaxis: { lines: { show: true } },
            padding: isRtl ?
                { top: -20, bottom: -8, left: 25, right: 25 } :
                { top: -20, bottom: -8, left: 15, right: 15 }
        },
        tooltip: {
            enabled: true,
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const value = series[seriesIndex][dataPointIndex];
                const datasetName = w.globals.seriesNames[seriesIndex];
                const seriesColor = w.globals.colors[seriesIndex];

                return `
                <div class="apexcharts-custom-tooltip text-white rounded px-2 py-1 d-flex align-items-center"
                style="background:${seriesColor};">
                    <span>${datasetName}: ${value}</span>
                </div>
                `;
            }
        },
        xaxis: {
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                show: true,
                style: { fontSize: '13px', colors: config.colors.textMuted }
            }
        },
        yaxis: {
            min: 0,
            max: maxY,
            tickAmount: 5,
            opposite: isRtl,
            labels: {
                show: true,
                formatter: function (val) {
                    return Math.round(val);
                },
                style: { fontSize: '12px', colors: config.colors.textMuted }
            }
        }
    };

    const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();

    // Setup custom legend
    const legendItems = document.querySelectorAll('#custom-legend .legend-item');
    legendItems.forEach(item => {
        // Remove old listeners by cloning
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);

        newItem.addEventListener('click', () => {
            const seriesIndex = parseInt(newItem.getAttribute('data-series'));
            lineChart.toggleSeries(dataset[seriesIndex].name);
            newItem.classList.toggle('legend-inactive');
        });
    });

    return lineChart;
}


function renderIncomeChart(elementId, data = [], categories = [], color = config.colors.primary, isRTL = false, currency_img = '') {
    const incomeChartEl = document.querySelector(elementId);
    if (!incomeChartEl) return;

    // إعداد البيانات حسب الاتجاه
    let chartData = data.length ? [...data] : [100, 200, 300, 400];
    let chartCategories = categories.length ? [...categories] : [
        'Week 4', 'Week 3', 'Week 2', 'Week 1'
    ];

    // عكس البيانات للـ RTL
    if (isRTL) {
        chartData = chartData.reverse();
        chartCategories = chartCategories.reverse();
    }

    let axisColor = config.colors.axisColor;
    let labelColor = config.colors.textMuted;
    let borderColor = config.colors.borderColor;

    const incomeChartConfig = {
        series: [{
            data: chartData
        }],
        chart: {
            height: 300,
            parentHeightOffset: 0,
            parentWidthOffset: 0,
            toolbar: { show: false },
            fontFamily: 'Noto, sans-serif',
            type: 'area',
            rtl: isRTL
        },
        dataLabels: { enabled: false },
        stroke: { width: 2, curve: 'smooth' },
        legend: { show: false },
        markers: {
            size: 6,
            colors: 'transparent',
            strokeColors: 'transparent',
            strokeWidth: 4,
            discrete: [{
                fillColor: config.colors.white,
                seriesIndex: 0,
                // إصلاح dataPointIndex بعد العكس
                dataPointIndex: chartData.length - 1,
                strokeColor: color,
                strokeWidth: 2,
                size: 6,
                radius: 8
            }],
            hover: { size: 7 }
        },
        colors: [color],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: "vertical",
                shadeIntensity: 0.6,
                gradientToColors: ["rgba(4, 80, 127, 0)"],
                inverseColors: false,
                opacityFrom: 0.6,
                opacityTo: 0,
                stops: [0, 100]
            }
        },
        grid: {
            borderColor: borderColor,
            strokeDashArray: 3,
            // تعديل padding حسب الاتجاه
            padding: isRTL ?
                { top: -20, bottom: -8, left: 25, right: 25 } :
                { top: -20, bottom: -8, left: 15, right: 15 }
        },
        xaxis: {
            categories: chartCategories,
            // إزالة reversed لأن البيانات معكوسة مسبقاً
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                show: true,
                style: { fontSize: '13px', colors: labelColor }
            }
        },
        yaxis: {
            opposite: isRTL,
            labels: {
                show: true,
                formatter: function (val) {
                    return Math.round(val / 100) + '00';
                },
                style: { fontSize: '12px', colors: labelColor }
            },
            min: 0,
            // تحديد max بناء على البيانات الفعلية
            max: Math.max(...chartData) + 200,
            // min: 100,
            // max: 1000,
            tickAmount: 5
        },
        // إضافة tooltip مخصص
        // tooltip: {
        //     enabled: true,
        //     x: {
        //         show: true
        //     },
        //     y: {
        //         formatter: function (val) {
        //             return val;
        //         }
        //     }
        // }
        tooltip: {
            enabled: true,
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const value = series[seriesIndex][dataPointIndex];
                const categories = chartCategories[dataPointIndex];
                return `
                <div class="apex-tooltip-custom bg-primary text-white border-0 p-2 py-1">
                    ${categories}: ${value}
                    ${currency_img ? `
                        <img src="${currency_img}" width="14" class="img_white" alt="sar icon">`
                        : ' SAR'
                    }
                </div>
                `;
            }
        }

    };

    const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
    incomeChart.render();
}


function renderOrderStatisticsChart(elementId, labels, series, colors, totalValue = '5', star_img = '') {
    const chartElement = document.querySelector(elementId);

    const cardColor = config.colors.white;
    const headingColor = config.colors.headingColor;
    const axisColor = config.colors.axisColor;
    const borderColor = config.colors.borderColor;

    if (!chartElement) return null;

    const orderChartConfig = {
        chart: {
            height: 165,
            width: 150,
            type: 'donut'
        },
        labels: labels,
        series: series,
        colors: colors,
        stroke: {
            width: 5,
            colors: cardColor,
            lineCap: 'round'
        },
        dataLabels: {
            enabled: false,
            formatter: function (val) {
                return parseInt(val) + '%';
            }
        },
        legend: {
            show: false
        },
        grid: {
            padding: {
                top: 0,
                bottom: 0,
                right: 15
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '50%',
                    labels: {
                        show: false
                    }
                }
            }
        },
    };

    const statisticsChart = new ApexCharts(chartElement, orderChartConfig);
    statisticsChart.render().then(() => {
        addCenterText(elementId, totalValue, star_img);
    });

    return statisticsChart; // إرجاع كائن الـ chart
}

function addCenterText(elementId, totalValue, star_img) {
    const chartContainer = document.querySelector(elementId);
    if (!chartContainer) return;

    // إنشاء div للنص المركزي
    const centerText = document.createElement('div');
    centerText.innerHTML = `<img src="${star_img}" width="20" class="star_img mx-1" alt="star icon"> ${totalValue}`;
    // centerText.innerHTML = `⭐ ${totalValue}`;

    // تطبيق الـ styles
    centerText.style.cssText = `
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1rem;
        font-family: 'Public Sans', sans-serif;
        font-weight: 400;
        color: #333333;
        text-align: center;
        pointer-events: none;
        z-index: 10;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    // التأكد من positioning
    chartContainer.style.position = 'relative';

    // إضافة النص للشارت
    chartContainer.appendChild(centerText);
}


function renderHorizontalBarChart(elementId, seriesData, categories, isRtl = false) {
    const chartElement = document.querySelector(elementId);
    if (!chartElement) return;
    // نتحقق من حجم الشاشة
    const isSmallScreen = window.innerWidth < 768;

    const horizontalBarChartConfig = {
        chart: {
            height: 100,
            type: 'bar',
            toolbar: { show: false },
            fontFamily: 'Noto, sans-serif',
            rtl: isRtl
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '60%',
                borderRadius: 20,
                distributed: true,
                dataLabels: {
                    position: 'right'
                }
            }
        },
        grid: {
            borderColor: config.colors.borderColor,
            xaxis: { lines: { show: false } },
            padding: isRtl
                ? { top: -20, bottom: -8, left: isSmallScreen ? 0 : 30, right: isSmallScreen ? -90 : 20 }
                : { top: -20, bottom: -8, left: -30, right: 0 }
        },
        colors: ['#9A9A9A', '#28A745'],
        dataLabels: {
            enabled: false
        },
        series: [{
            data: seriesData
        }],
        xaxis: {
            min: 0,
            max: Math.max(...seriesData) + 10,
            tickAmount: 4,
            categories: categories,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    colors: config.colors.labelColor,
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            opposite: isRtl,
            labels: {
                style: {
                    colors: config.colors.labelColor,
                    fontSize: '13px',
                },
                align: isRtl ? 'right' : 'left',
                offsetX: isRtl ? (isSmallScreen ? 50 : 320) : 0 // تحريك النص أفقيًا
            }
        },
        tooltip: {
            enabled: true,
            style: {
                direction: isRtl ? 'rtl' : 'ltr'
            },
            y: {
                formatter: function (value) {
                    return value;
                }
            }
        },
        legend: {
            show: false
        }
    };

    const horizontalBarChart = new ApexCharts(chartElement, horizontalBarChartConfig);
    horizontalBarChart.render();
}



// function renderBarChart(elementId, labels, data, barColor, isRtl = false) {
//     const chartElement = document.getElementById(elementId);
//     if (!chartElement) return;

//     // تأكد من أن الـ canvas له أبعاد محددة
//     const parentHeight = chartElement.parentElement.offsetHeight || 300;
//     chartElement.style.height = parentHeight + 'px';
//     chartElement.style.maxHeight = '340px'; // حد أقصى للارتفاع

//     // Color Variables
//     let cardColor, headingColor, labelColor, borderColor, legendColor;
//     cardColor = config.colors.cardColor;
//     headingColor = config.colors.headingColor;
//     labelColor = config.colors.labelColor;
//     legendColor = config.colors.bodyColor;
//     borderColor = config.colors.borderColor;

//     const ctx = chartElement.getContext("2d");

//     // تدمير الشارت السابق إذا كان موجود
//     if (chartElement.chart) {
//         chartElement.chart.destroy();
//     }

//     // عكس ترتيب البيانات والتسميات في RTL
//     const processedLabels = isRtl ? [...labels].reverse() : labels;
//     const processedData = isRtl ? [...data].reverse() : data;

//     const barChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: processedLabels,
//             datasets: [
//                 {
//                     data: processedData,
//                     backgroundColor: barColor,
//                     borderColor: 'transparent',
//                     maxBarThickness: 15,
//                     borderRadius: {
//                         topRight: 0,
//                         topLeft: 0
//                     }
//                 }
//             ]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             animation: {
//                 duration: 500
//             },
//             aspectRatio: false,
//             rtl: isRtl,
//             plugins: {
//                 tooltip: {
//                     enabled: false, // إلغاء الـ tooltip الافتراضي
//                     external: function(context) {
//                         // Custom tooltip function
//                         const { chart, tooltip } = context;

//                         // إنشاء عنصر tooltip إذا لم يكن موجود
//                         let tooltipEl = chart.canvas.parentNode.querySelector('.chartjs-custom-tooltip');
//                         if (!tooltipEl) {
//                             tooltipEl = document.createElement('div');
//                             tooltipEl.className = 'chartjs-custom-tooltip';
//                             tooltipEl.style.position = 'absolute';
//                             tooltipEl.style.pointerEvents = 'none';
//                             tooltipEl.style.transition = 'all 0.2s ease';
//                             chart.canvas.parentNode.appendChild(tooltipEl);
//                         }

//                         // إخفاء tooltip إذا لم يعد مطلوب
//                         if (tooltip.opacity === 0) {
//                             tooltipEl.style.opacity = 0;
//                             return;
//                         }

//                         // إنشاء محتوى tooltip
//                         if (tooltip.body) {
//                             const dataPoint = tooltip.dataPoints[0];
//                             const label = dataPoint.label;
//                             const value = dataPoint.parsed.y;

//                             tooltipEl.innerHTML = `
//                                 <div class="apexcharts-custom-tooltip bg-primary text-white rounded px-2 py-1 d-flex align-items-center" style="
//                                     background-color: #3563AD !important;
//                                     color: white !important;
//                                     padding: 6px 12px !important;
//                                     border-radius: 6px !important;
//                                     font-size: 12px !important;
//                                     font-weight: 500 !important;
//                                     box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
//                                     white-space: nowrap !important;
//                                     direction: ${isRtl ? 'rtl' : 'ltr'} !important;
//                                 ">
//                                     <span>${label}: ${value}</span>
//                                 </div>
//                             `;
//                         }

//                         // تحديد موضع tooltip
//                         const { offsetLeft: positionX, offsetTop: positionY } = chart.canvas;

//                         // حساب الموضع مع مراعاة RTL
//                         let tooltipX = positionX + tooltip.caretX;
//                         let tooltipY = positionY + tooltip.caretY;

//                         // تعديل الموضع في RTL
//                         if (isRtl) {
//                             tooltipX = tooltipX - tooltipEl.offsetWidth - 10;
//                         } else {
//                             tooltipX = tooltipX + 10;
//                         }

//                         tooltipY = tooltipY - tooltipEl.offsetHeight - 10;

//                         // تطبيق الموضع والشفافية
//                         tooltipEl.style.opacity = 1;
//                         tooltipEl.style.left = tooltipX + 'px';
//                         tooltipEl.style.top = tooltipY + 'px';
//                         tooltipEl.style.zIndex = 9999;
//                     }
//                 },
//                 legend: {
//                     display: false
//                 }
//             },
//             scales: {
//                 x: {
//                     reverse: isRtl,
//                     grid: {
//                         color: borderColor,
//                         drawBorder: false,
//                         borderColor: borderColor
//                     },
//                     ticks: {
//                         color: labelColor,
//                         maxRotation: 45,
//                         minRotation: 0,
//                         align: isRtl ? 'end' : 'center',
//                         autoSkip: false, // لاظهار كل التسميات
//                     }
//                 },
//                 y: {
//                     position: isRtl ? 'right' : 'left',
//                     min: 0,
//                     // max: 100,
//                     max: Math.ceil((Math.max(...data) + 100) / 100) * 100, // تقريب للمئات
//                     grid: {
//                         color: borderColor,
//                         drawBorder: false,
//                         borderColor: borderColor
//                     },
//                     ticks: {
//                         stepSize: 100, // خطوات بالمئات
//                         color: labelColor,
//                         align: isRtl ? 'end' : 'start',
//                         stepSize: 1, //  1 لأن عشان عندنا أعداد صغيرة
//                         precision: 0 // يمنع الفواصل العشرية
//                     },
//                     suggestedMax: Math.max(...data) + 1 // يخلي المقياس ديناميكي حسب البيانات
//                 }
//             },
//             layout: {
//                 padding: {
//                     top: 10,
//                     bottom: 10,
//                     left: isRtl ? 20 : 5,
//                     right: isRtl ? 5 : 20
//                 }
//             }
//         }
//     });

//     // حفظ مرجع للشارت لتدميره لاحقاً
//     chartElement.chart = barChart;

//     // إضافة CSS للـ canvas لدعم RTL
//     if (isRtl) {
//         chartElement.style.direction = 'rtl';
//         chartElement.parentElement.style.direction = 'rtl';
//     } else {
//         chartElement.style.direction = 'ltr';
//         chartElement.parentElement.style.direction = 'ltr';
//     }

//     return barChart;
// }



// Fixed Function to render Line Chart for doctor reports

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



function renderDoctorMiniChart(elementId, data = [], color = "#3563AD") {
  if (!document.querySelector(elementId)) return;

  let cardColor = config.colors.white;
  let headingColor = config.colors.headingColor;
  let axisColor = config.colors.axisColor;
  let borderColor = config.colors.borderColor;

  const chartConfig = {
    chart: {
      height: 80,
      width: 120,
      type: 'line',
      toolbar: { show: false },
      dropShadow: {
        enabled: false,
        top: 10,
        left: 5,
        blur: 3,
        color: color,
        opacity: 0.15
      },
      sparkline: { enabled: true }
    },
    grid: {
      show: false,
      padding: { right: 8 }
    },
    tooltip: {
        enabled: false,
    },
    colors: [color],
    dataLabels: { enabled: false },
    stroke: {
      width: 2,
      curve: 'smooth'
    },
    series: [
      {
        data: data
      }
    ],
    xaxis: {
      show: false,
      lines: { show: false },
      labels: { show: false },
      axisBorder: { show: false }
    },
    yaxis: { show: false }
  };

  const chart = new ApexCharts(document.querySelector(elementId), chartConfig);
  chart.render();
}


function renderDoctorReportLineChart(elementId, categories = [], series = [], isRtl = false, colors) {
    const lineChartEl = document.querySelector(elementId);

    if (!lineChartEl) {
        console.error('Chart element not found:', elementId);
        return null;
    }

    // Clear any existing chart properly
    if (lineChartEl._chartInstance) {
        lineChartEl._chartInstance.destroy();
        lineChartEl._chartInstance = null;
    }

    // Colors
    let cardColor = config.colors.cardColor;
    let labelColor = config.colors.textMuted;
    let borderColor = config.colors.borderColor;

    // Calculate max Y value properly
    let allData = [];
    series.forEach(s => {
        if (s.data && Array.isArray(s.data)) {
            allData = allData.concat(s.data);
        }
    });

    let maxY = allData.length ? Math.max(...allData) : 0;

    // Set reasonable Y-axis range
    if (maxY === 0) {
        maxY = 10; // Default range when no data
    } else {
        maxY = Math.ceil(maxY * 1.2); // Add 20% padding
    }

    const lineChartConfig = {
        chart: {
            height: 300,
            type: 'line',
            parentHeightOffset: 0,
            zoom: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'Noto, sans-serif',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        series: series,
        legend: {
            show: false
        },
        markers: {
            size: 4,
            strokeWidth: 2,
            strokeColors: ['#fff'],
            colors: colors,
            hover: {
                size: 6
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: colors,
        grid: {
            borderColor: borderColor,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
            padding: isRtl ?
                { top: -20, bottom: -8, left: 25, right: 25 } :
                { top: -20, bottom: -8, left: 15, right: 15 }
        },
        tooltip: {
            enabled: true,
            shared: true,
            intersect: false,
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const value = series[seriesIndex][dataPointIndex];
                const datasetName = w.globals.seriesNames[seriesIndex];
                const category = w.globals.labels[dataPointIndex];
                const seriesColor = w.globals.colors[seriesIndex];

                return `
                <div class="apexcharts-custom-tooltip text-white rounded px-2 py-1"
                style="background:${seriesColor}; font-size: 12px;">
                    ${datasetName}: ${value} مواعيد
                </div>
                `;
            }
        },
        xaxis: {
            categories: categories,
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                show: true,
                style: {
                    fontSize: '11px',
                    colors: labelColor,
                    fontFamily: 'Noto, sans-serif'
                },
                rotate: -45,
                rotateAlways: false
            }
        },
        yaxis: {
            min: 0,
            max: maxY,
            forceNiceScale: true,
            decimalsInFloat: 0,
            opposite: isRtl,
            labels: {
                show: true,
                formatter: function (val) {
                    return Math.floor(val); // Show whole numbers only
                },
                style: {
                    fontSize: '11px',
                    colors: labelColor,
                    fontFamily: 'Noto, sans-serif'
                }
            }
        }
    };

    // Create and render new chart
    const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();

    // Store reference on the element itself
    lineChartEl._chartInstance = lineChart;

    // Setup custom legend functionality
    setupCustomLegend(lineChart);

    return lineChart;
}

// Function to handle custom legend clicks
function setupCustomLegend(chart) {
    const legendItems = document.querySelectorAll('#custom-legend .legend-item');

    legendItems.forEach((item, index) => {
        // Add cursor pointer style
        item.style.cursor = 'pointer';

        // Add click event
        item.addEventListener('click', function() {
            const seriesIndex = parseInt(this.getAttribute('data-series'));

            // Toggle series visibility
            chart.toggleSeries(chart.w.globals.seriesNames[seriesIndex]);

            // Toggle opacity for visual feedback
            if (this.style.opacity === '0.5') {
                this.style.opacity = '1';
            } else {
                this.style.opacity = '0.5';
            }
        });
    });
}








// Fixed Function to render Line Chart for admin reports
function renderAdminMiniChart(elementId, data = [], color = "#3563AD") {
  if (!document.querySelector(elementId)) return;

  let cardColor = config.colors.white;
  let headingColor = config.colors.headingColor;
  let axisColor = config.colors.axisColor;
  let borderColor = config.colors.borderColor;

  const chartConfig = {
    chart: {
      height: 80,
      width: 120,
      type: 'line',
      toolbar: { show: false },
      dropShadow: {
        enabled: false,
        top: 10,
        left: 5,
        blur: 3,
        color: color,
        opacity: 0.15
      },
      sparkline: { enabled: true }
    },
    grid: {
      show: false,
      padding: { right: 8 }
    },
    tooltip: {
        enabled: false,
    },
    colors: [color],
    dataLabels: { enabled: false },
    stroke: {
      width: 2,
      curve: 'smooth'
    },
    series: [
      {
        data: data
      }
    ],
    xaxis: {
      show: false,
      lines: { show: false },
      labels: { show: false },
      axisBorder: { show: false }
    },
    yaxis: { show: false }
  };

  const chart = new ApexCharts(document.querySelector(elementId), chartConfig);
  chart.render();
}





function renderAdminUsersActivityChart(elementId, labels = [], dataset = [], isRtl = false, colors = null) {
    const lineChartEl = document.querySelector(elementId);

    if (!lineChartEl) {
        console.error('Chart element not found:', elementId);
        return null;
    }

    // Clear the container
    lineChartEl.innerHTML = '';

    let allData = dataset.flatMap(ds => ds.data);
    let maxY = allData.length ? Math.max(...allData) + 100 : 300;

    // الألوان الافتراضية إذا لم يتم توفير ألوان مخصصة
    const defaultColors = ['#17a2b8', '#007bff', '#ffc107', '#6c757d'];
    const chartColors = colors || defaultColors;

    const lineChartConfig = {
        chart: {
            height: 300,
            type: 'line',
            parentHeightOffset: 0,
            zoom: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'Noto, sans-serif'
        },
        series: dataset,
        legend: { show: false },
        markers: {
            size: 0,
            strokeWidth: 4,
            strokeOpacity: 0,
            colors: ['#fff'],
            strokeColors: chartColors,
            hover: { size: 6 }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'straight',
            width: 3
        },
        colors: chartColors,
        grid: {
            borderColor: config.colors.borderColor,
            xaxis: { lines: { show: true } },
            padding: isRtl ?
                { top: -20, bottom: -8, left: 25, right: 25 } :
                { top: -20, bottom: -8, left: 15, right: 15 }
        },
        tooltip: {
            enabled: true,
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const value = series[seriesIndex][dataPointIndex];
                const datasetName = w.globals.seriesNames[seriesIndex];
                const seriesColor = w.globals.colors[seriesIndex];

                return `
                <div class="apexcharts-custom-tooltip text-white rounded px-2 py-1 d-flex align-items-center"
                style="background:${seriesColor}; padding: 6px 12px; border-radius: 6px; font-size: 12px;">
                    <span>${datasetName}: ${value}</span>
                </div>
                `;
            }
        },
        xaxis: {
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                show: true,
                style: {
                    fontSize: '13px',
                    colors: config.colors.textMuted,
                    fontFamily: 'Noto, sans-serif'
                }
            }
        },
        yaxis: {
            min: 0,
            max: maxY,
            tickAmount: 5,
            opposite: isRtl,
            labels: {
                show: true,
                formatter: function (val) {
                    return Math.round(val);
                },
                style: {
                    fontSize: '12px',
                    colors: config.colors.textMuted,
                    fontFamily: 'Noto, sans-serif'
                }
            }
        }
    };

    const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();

    // Setup custom legend with better event handling
    setupCustomLegend(lineChart, dataset);

    return lineChart;
}
