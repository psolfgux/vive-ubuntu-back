/**
 * Academy Dashboard charts and datatable
 */

'use strict';

// Hour pie chart

(function () {
  let labelColor, headingColor, borderColor, currentTheme;

  if (isDarkStyle) {
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    borderColor = config.colors_dark.borderColor;
    currentTheme = 'dark';
  } else {
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    borderColor = config.colors.borderColor;
    currentTheme = 'light';
  }

  // Donut Chart Colors
  const chartColors = {
    donut: {
      series1: '#5BB420',
      series2: '#67CB24',
      series3: config.colors.success,
      series4: '#8EE753',
      series5: '#AAED7E',
      series6: '#C7F3A9',
      series7: '#5BB420',
      series8: '#67CB24',
      series9: '#8EE753',
    }
  };


  // datatbale bar chart

  const labels1 = JSON.parse(document.querySelector('#labels1').value);
  const ntematicas = document.querySelector('#ntematicas').value;
  const data1 = JSON.parse(document.querySelector('#data1').value);

  const horizontalBarChartEl = document.querySelector('#horizontalBarChart'),
    horizontalBarChartConfig = {
      chart: {
        height: 270,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: '70%',
          distributed: true,
          startingShape: 'rounded',
          borderRadius: 7
        }
      },
      grid: {
        strokeDashArray: 10,
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: false
          }
        },
        padding: {
          top: -35,
          bottom: -12
        }
      },
      fill: {
        opacity: 1
      },
      colors: [
        config.colors.primary,
        config.colors.info,
        config.colors.success,
        config.colors.secondary,
        config.colors.danger,
        config.colors.warning
      ],
      dataLabels: {
        enabled: true,
        style: {
          colors: ['#fff'],
          fontWeight: 500,
          fontSize: '13px',
          fontFamily: 'Inter'
        },
        formatter: function (val, opts) {
          return horizontalBarChartConfig.labels[opts.dataPointIndex];
        },
        offsetX: 0,
        dropShadow: {
          enabled: false
        }
      },
      labels: labels1,
      series: [
        {
          data: data1
        }
      ],

      xaxis: {
        categories: ['8', '7', '6', '5', '4', '3', '2', '1'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          },
          formatter: function (val) {
            return `${val}`;
          }
        }
      },
      yaxis: {
        max: 35,
        labels: {
          style: {
            colors: [labelColor],
            fontFamily: 'Inter',
            fontSize: '13px'
          }
        }
      },
      tooltip: {
        enabled: true,
        style: {
          fontSize: '12px'
        },
        onDatasetHover: {
          highlightDataSeries: false
        },
        custom: function ({ series, seriesIndex, dataPointIndex, w }) {
          return '<div class="px-3 py-2">' + '<span>' + series[seriesIndex][dataPointIndex] + ' players</span>' + '</div>';
        }
      },
      legend: {
        show: false
      }
    };
  if (typeof horizontalBarChartEl !== undefined && horizontalBarChartEl !== null) {
    const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
    horizontalBarChart.render();
  }

  // datatable

  // Variable declaration for table
  var dt_academy_course = $('.datatables-academy-course'),
    logoObj = {
      angular:
        '<div class="avatar"><div class="avatar-initial bg-label-danger rounded"><i class="ri-angularjs-line ri-28px"></i></div></div>',
      figma:
        '<div class="avatar"><div class="avatar-initial bg-label-warning rounded"><i class="ri-pencil-line ri-28px"></i></div></div>',
      react:
        '<div class="avatar"><div class="avatar-initial bg-label-info rounded"><i class="ri-reactjs-line ri-28px"></i></div></div>',
      art: '<div class="avatar"><div class="avatar-initial bg-label-success rounded"><i class="ri-palette-line ri-28px"></i></div></div>',
      fundamentals:
        '<div class="avatar"><div class="avatar-initial bg-label-primary rounded"><i class="ri-star-smile-line ri-28px"></i></div></div>'
    };

  // orders datatable
  if (dt_academy_course.length) {
    var dt_course = dt_academy_course.DataTable({
      ajax: assetsPath + 'json/app-academy-dashboard.json', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'course name' },
        { data: 'time' },
        { data: 'progress' },
        { data: 'status' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          searchable: false,
          checkboxes: true,
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
          },
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          }
        },
        {
          // order number
          targets: 2,
          responsivePriority: 2,
          render: function (data, type, full, meta) {
            var $logo = full['logo'];
            var $course = full['course'];
            var $user = full['user'];
            var $image = full['image'];
            if ($image) {
              // For Avatar image
              var $output =
                '<img src="' + assetsPath + 'img/avatars/' + $image + '" alt="Avatar" class="rounded-circle">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $name = full['user'],
                $initials = $name.match(/\b\w/g) || [];
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            }
            // Creates full output for row
            var $row_output =
              '<div class="d-flex align-items-center">' +
              '<span class="me-4">' +
              logoObj[$logo] +
              '</span>' +
              '<div>' +
              '<a href="' +
              baseUrl +
              'app/academy/course-details' +
              '" class="text-heading"><span class="text-wrap fw-medium">' +
              $course +
              '</span></a>' +
              '<div class="d-flex align-items-center">' +
              '<div class="avatar-wrapper me-2">' +
              '<div class="avatar avatar-xs">' +
              $output +
              '</div>' +
              '</div>' +
              '<small class="text-nowrap text-heading">' +
              $user +
              '</small>' +
              '</div>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          targets: 3,
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            var duration = moment.duration(data);
            var Hs = Math.floor(duration.asHours());
            var minutes = Math.floor(duration.asMinutes()) - Hs * 60;
            var formattedTime = Hs + 'h ' + minutes + 'm';
            return '<h6 class="mb-0 text-nowrap">' + formattedTime + '</h6>';
          }
        },
        {
          // progress
          targets: 4,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $average_number = full['number'];

            return (
              '<div class="d-flex align-items-center gap-4">' +
              '<h6 class="mb-0">' +
              $status_number +
              '</h6>' +
              '<div class="progress w-100 rounded-pill" style="height: 8px;">' +
              '<div class="progress-bar" style="width: ' +
              $status_number +
              '" aria-valuenow="' +
              $status_number +
              '" aria-valuemin="0" aria-valuemax="100"></div>' +
              '</div>' +
              '<small>' +
              $average_number +
              '</small></div>'
            );
          }
        },
        {
          // status
          targets: 5,
          render: function (data, type, full, meta) {
            var $user_number = full['user_number'];
            var $note = full['note'];
            var $view = full['view'];

            return (
              '<div class="d-flex align-items-center justify-content-between">' +
              '<div class="w-px-50 d-flex align-items-center">' +
              '<i class="ri-group-line ri-24px me-1_5 text-primary"></i>' +
              $user_number +
              'k' +
              '</div>' +
              '<div class="w-px-50 d-flex align-items-center">' +
              '<i class="ri-computer-line ri-24px me-1_5 text-info" ></i>' +
              $note +
              '</div>' +
              '<div class="w-px-50 d-flex align-items-center">' +
              '<i class="ri-video-upload-line ri-24px me-1_5 text-danger scaleX-n1-rtl" ></i>' +
              $view +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      dom:
        '<"card-header pt-sm-0 pb-0 flex-column flex-sm-row"<"head-label text-center">f' +
        '>t' +
        '<"row mx-4"' +
        '<"col-md-6 col-12 text-center text-md-start pb-2 pb-xl-0 px-0"i>' +
        '<"col-md-6 col-12 d-flex justify-content-center justify-content-md-end px-0"p>' +
        '>',
      lengthMenu: [5],
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Course',
        paginate: {
          next: '<i class="ri-arrow-right-s-line"></i>',
          previous: '<i class="ri-arrow-left-s-line"></i>'
        }
      },
      // Buttons with Dropdown

      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['user_number'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
    $('div.head-label').html('<h5 class="card-title mb-0 text-nowrap">Course you are taking</h5>');
  }

  // Delete Record
  $('.datatables-orders tbody').on('click', '.delete-record', function () {
    dt_course.row($(this).parents('tr')).remove().draw();
  });


  $(document).ready(function() {
    $('.datatables-players').DataTable({
        // Configuraciones adicionales de DataTables, si necesitas
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Configuración en español
        },
        pageLength: 10, // Número de filas por página
        ordering: true, // Permite ordenar columnas
        searching: true, // Incluye un cuadro de búsqueda
    });
});

})();
