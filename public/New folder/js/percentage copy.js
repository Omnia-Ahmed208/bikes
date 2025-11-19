/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  const patientPercentageChartEl = document.querySelector('#patientPercentageChart'),
    patientPercentageChartConfig = {
      chart: {
        height: 80,
        width: 120,
        type: 'line',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: false,
          top: 10,
          left: 5,
          blur: 3,
          color: "#3563AD",
          opacity: 0.15
        },
        sparkline: {
          enabled: true
        }
      },
      grid: {
        show: false,
        padding: {
          right: 8
        }
      },
      colors: ["#3563AD"],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          data: [110, 270, 145, 245, 205, 285]
        }
      ],
      xaxis: {
        show: false,
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        show: false
      }
    };
  if (typeof patientPercentageChartEl !== undefined && patientPercentageChartEl !== null) {
    const patientPercentageChart = new ApexCharts(patientPercentageChartEl, patientPercentageChartConfig);
    patientPercentageChart.render();
  }












    const patientPercentageChart_2El = document.querySelector('#patientPercentageChart_2'),
    patientPercentageChart_2Config = {
      chart: {
        height: 80,
        width: 120,
        type: 'line',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: false,
          top: 10,
          left: 5,
          blur: 3,
          color: "#3563AD",
          opacity: 0.15
        },
        sparkline: {
          enabled: true
        }
      },
      grid: {
        show: false,
        padding: {
          right: 8
        }
      },
      colors: ["#3563AD"],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          data: [110, 270, 145, 245, 205, 285]
        }
      ],
      xaxis: {
        show: false,
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        show: false
      }
    };
  if (typeof patientPercentageChart_2El !== undefined && patientPercentageChart_2El !== null) {
    const patientPercentageChart_2 = new ApexCharts(patientPercentageChart_2El, patientPercentageChart_2Config);
    patientPercentageChart_2.render();
  }








    const patientPercentageChart_3El = document.querySelector('#patientPercentageChart_3'),
    patientPercentageChart_3Config = {
      chart: {
        height: 80,
        width: 120,
        type: 'line',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: false,
          top: 10,
          left: 5,
          blur: 3,
          color: "#3563AD",
          opacity: 0.15
        },
        sparkline: {
          enabled: true
        }
      },
      grid: {
        show: false,
        padding: {
          right: 8
        }
      },
      colors: ["#3563AD"],
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          data: [110, 270, 145, 245, 205, 285]
        }
      ],
      xaxis: {
        show: false,
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        show: false
      }
    };
  if (typeof patientPercentageChart_3El !== undefined && patientPercentageChart_3El !== null) {
    const patientPercentageChart_3 = new ApexCharts(patientPercentageChart_3El, patientPercentageChart_3Config);
    patientPercentageChart_3.render();
  }

})();
