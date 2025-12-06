'use strict';

  let cardColor, shadeColor, labelColor, headingColor, barBgColor, borderColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
    barBgColor = '#8692d014';
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    shadeColor = '';
    barBgColor = '#4b465c14';
    borderColor = config.colors.borderColor;
  }

  // Donut Chart Colors
  const chartColors = {
    donut: {
      series1: config.colors.success,
      series2: '#28c76fb3',
      series3: '#28c76f80',
      series4: config.colors_label.success
    }
  };

function renderMiniChart(elementId, data = [], color = "#0077B6")  {
    if (!document.querySelector(elementId)) return;

    const revenueGeneratedEl = document.querySelector(elementId),
        revenueGeneratedConfig = {
        chart: {
            height: 90,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: {
            show: false
            },
            sparkline: {
            enabled: true
            }
        },
        markers: {
            colors: 'transparent',
            strokeColors: 'transparent'
        },
        grid: {
            show: false
        },
        colors: [color],
        fill: {
            type: 'gradient',
            gradient: {
            shade: shadeColor,
            shadeIntensity: 0.8,
            opacityFrom: 0.6,
            opacityTo: 0.1
            }
        },
        dataLabels: {
            enabled: false
        },
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
            show: true,
            lines: {
            show: false
            },
            labels: {
            show: false
            },
            stroke: {
            width: 0
            },
            axisBorder: {
            show: false
            }
        },
        yaxis: {
            stroke: {
            width: 0
            },
            show: false
        },
        tooltip: {
            enabled: false
        }
        };
    if (typeof revenueGeneratedEl !== undefined && revenueGeneratedEl !== null) {
        const revenueGenerated = new ApexCharts(revenueGeneratedEl, revenueGeneratedConfig);
        revenueGenerated.render();
    }
}


function renderBarChart(elementId, labels = [], data = [], barColor = '#0077B6', isRtl = false) {
    const chartElement = document.getElementById(elementId);
    if (!chartElement) {
        console.error('Chart element not found:', elementId);
        return null;
    }

    const ctx = chartElement.getContext("2d");

    // تدمير الشارت السابق إذا كان موجود
    if (chartElement.chart) {
        chartElement.chart.destroy();
    }

    // عكس ترتيب البيانات والتسميات في RTL
    const processedLabels = isRtl ? [...labels].reverse() : labels;
    const processedData = isRtl ? [...data].reverse() : data;


    const barChart = document.getElementById(elementId);
    if (!barChart) return; // exit if element not found

    new Chart(barChart, {
        type: 'bar',
        data: {
            labels: processedLabels,
            datasets: [{
                data: processedData,
                backgroundColor: barColor,
                borderColor: 'transparent',
                maxBarThickness: 15,
                borderRadius: 3 // simplified, works for Chart.js 4.x
                // borderRadius: {
                //     topRight: 0,
                //     topLeft: 0
                // }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 500 },
            plugins: {
                tooltip: {
                    rtl: isRtl,
                    // These colors need to be defined somewhere in your code
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#333',
                    borderWidth: 1,
                    borderColor: '#ccc'
                },
                legend: { display: false }
            },
            scales: {
                x: {
                    reverse: isRtl,
                    grid: { color: '#e0e0e0', drawBorder: false },
                    ticks: {
                        color: '#333',
                        maxRotation: 45,
                        minRotation: 0,
                        align: isRtl ? 'end' : 'center',
                        autoSkip: false,
                    }
                },
                y: {
                    position: isRtl ? 'right' : 'left',
                    min: 0,
                    // max: 100,
                    // max: suggestedMax,
                    grid: {
                        color: '#e0e0e0',
                        drawBorder: false,
                        borderColor: '#e0e0e0'
                    },
                    ticks: {
                        color: '#333',
                        align: isRtl ? 'end' : 'start',
                        precision: 0,
                        ticks: { stepSize: 100, color: '#333' }
                        // stepSize: Math.ceil(suggestedMax / 5)
                    }
                }
            }
        }
    });

    // // حفظ مرجع للشارت لتدميره لاحقاً
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





 // Expenses Radial Bar Chart
 function radialBarChart(){
   const expensesRadialChartEl = document.querySelector('#expensesChart'),
   expensesRadialChartConfig = {
       chart: {
       height: 145,
       sparkline: {
           enabled: true
       },
       parentHeightOffset: 0,
       type: 'radialBar'
       },
       colors: [config.colors.warning],
       series: [78],
       plotOptions: {
       radialBar: {
           offsetY: 0,
           startAngle: -90,
           endAngle: 90,
           hollow: {
           size: '65%'
           },
           track: {
           strokeWidth: '45%',
           background: borderColor
           },
           dataLabels: {
           name: {
               show: false
           },
           value: {
               fontSize: '22px',
               color: headingColor,
               fontWeight: 600,
               offsetY: -5
           }
           }
       }
       },
       grid: {
       show: false,
       padding: {
           bottom: 5
       }
       },
       stroke: {
       lineCap: 'round'
       },
       labels: ['Progress'],
       responsive: [
       {
           breakpoint: 1442,
           options: {
           chart: {
               height: 400
           },
           plotOptions: {
               radialBar: {
               dataLabels: {
                   value: {
                   fontSize: '18px'
                   }
               },
               hollow: {
                   size: '60%'
               }
               }
           }
           }
       },
       {
           breakpoint: 1025,
           options: {
           chart: {
               height: 136
           },
           plotOptions: {
               radialBar: {
               hollow: {
                   size: '65%'
               },
               dataLabels: {
                   value: {
                   fontSize: '18px'
                   }
               }
               }
           }
           }
       },
       {
           breakpoint: 769,
           options: {
           chart: {
               height: 120
           },
           plotOptions: {
               radialBar: {
               hollow: {
                   size: '55%'
               }
               }
           }
           }
       },
       {
           breakpoint: 426,
           options: {
           chart: {
               height: 145
           },
           plotOptions: {
               radialBar: {
               hollow: {
                   size: '65%'
               }
               }
           },
           dataLabels: {
               value: {
               offsetY: 0
               }
           }
           }
       },
       {
           breakpoint: 376,
           options: {
           chart: {
               height: 105
           },
           plotOptions: {
               radialBar: {
               hollow: {
                   size: '60%'
               }
               }
           }
           }
       }
       ]
   };

   if (typeof expensesRadialChartEl !== undefined && expensesRadialChartEl !== null) {
    const expensesRadialChart = new ApexCharts(expensesRadialChartEl, expensesRadialChartConfig);
    expensesRadialChart.render();
   }
 }



// function halfDoughnutChart(labels) {
//     var ctx = document.getElementById("campaign_performance");
//     var myChart = new Chart(ctx, {
//     //     type: 'doughnut',
//     //     data: {
//     //         labels: labels,
//     //         datasets: [{
//     //             label: '# of Votes',
//     //             data: [25, 25, 25, 25, 0],
//     //             backgroundColor: [
//     //                 '#D32F2F',
//     //                 '#FFB300',
//     //                 '#F39C12',
//     //                 '#4CAF50',
//     //                 '#00bcd4',
//     //             ],
//     //             borderWidth: 5,      // ← سماكة الفاصل
//     //             borderColor: '#fff', // ← لون الفاصل
//     //         }]
//     //     },
//     //     options: {
//     //         legend: {
//     //             display: false
//     //         },
//     //         cutoutPercentage: 56,
//     //         rotation: 1 * Math.PI,
//     //         circumference: 1 * Math.PI
//     //     }
//     // });
// }
function halfDoughnutChart(labels) {
    var ctx = document.getElementById("campaign_performance");

    var segmentValues = [0, 25, 50, 100]; // القيم التي تريد عرضها

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        plugins: [ChartDataLabels],
        data: {
            labels: labels,
            datasets: [{
                label: '# of Votes',
                data: [25, 25, 25, 25],
                backgroundColor: [
                    '#D32F2F',
                    '#FFB300',
                    '#F39C12',
                    '#4CAF50',
                ],
                borderWidth: 4,
                borderColor: '#fff',
            }]
        },
        options: {
            legend: {
                display: false
            },
            cutoutPercentage: 56,
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,

            tooltips: {
                enabled: false // إخفاء tooltip
            },

            plugins: {
                datalabels: {
                    color: '#444C53',
                    font: {
                        size: 10,
                    },
                    formatter: function(value, ctx) {
                        return segmentValues[ctx.dataIndex] ?? '';
                    },
                    anchor: 'start',
                    align: 'start',
                    offset: 1
                }
            }
        }
    });
}
