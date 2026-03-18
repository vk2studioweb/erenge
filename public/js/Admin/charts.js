$(document).ready(function() {
    // var canvasvisitors = $("#charts-visitor");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function drawingCharts(chart, config){
        $.ajax({
            url: '/chart/'+chart,
            dataType: 'json',
            error: function (request, error) {
                console.log(error);
                console.log(request);
            },
            success: function(response){
                config['data']['labels'] = response['labels'];
                if(chart == 'visitor' || chart == 'total'){
                    config['data']['datasets'][0]['data'] = response['pageViews'];
                    config['data']['datasets'][0]['label']= 'Visualizações';
                    config['data']['datasets'][1]['data']= response['visitors'];
                    config['data']['datasets'][1]['label'] = 'Visitantes';
                }
                if(chart == 'most' || chart == 'top' || chart == 'browsers'){
                    config['data']['datasets'][0]['data'] = response['pageViews'];
                }
                var chartoptions = {'chartId': chart, 'options': config};
                createCharts(chartoptions);
            }
        });
    }
    function createCharts(chartoptions){
        var canvasvisitorsCharts = new Chart($('#charts-'+chartoptions['chartId']), chartoptions['options']);
    }
    if($('.visitor').length > 0){
        var config = {
            type: 'line',
            data: {
                labels: "",
                datasets: [
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#28beef",
                        yAxisID: 'y',
                    },
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#135970",
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            },
        };
        drawingCharts('visitor', config);
    }
    if($('.total').length > 0){
        var config = {
            type: 'line',
            data: {
                labels: "",
                datasets: [
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#28beef",
                        yAxisID: 'y',
                    },
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#135970",
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            },
        };
        drawingCharts('total', config)    }
    if($('.most').length > 0){
        var config = {
            type: 'bar',
            data: {
                labels: "",
                datasets: [
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#28beef",
                    }
                ]
            },
            options: {
                elements: {
                  bar: {
                    borderWidth: 2,
                  }
                },
                responsive: true,
                plugins: {
                  legend: {
                    display: false,
                  },
                  title: {
                    display: false,
                  }
                }
            },
        };
        drawingCharts('most', config)    }
    if($('.top').length > 0){
        var config = {
            type: 'bar',
            data: {
                labels: "",
                datasets: [
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#28beef",
                    }
                ]
            },
            options: {
                elements: {
                  bar: {
                    borderWidth: 2,
                  }
                },
                responsive: true,
                plugins: {
                  legend: {
                    display: false,
                  },
                  title: {
                    display: false,
                  }
                }
            },
        };
        drawingCharts('top', config)    }
    if($('.browsers').length > 0){
        var config = {
            type: 'bar',
            data: {
                labels: "",
                datasets: [
                    {
                        label: '',
                        data: "",
                        backgroundColor: "#28beef",
                    }
                ]
            },
            options: {
                elements: {
                  bar: {
                    borderWidth: 2,
                  }
                },
                responsive: true,
                plugins: {
                  legend: {
                    display: false,
                  },
                  title: {
                    display: false,
                  }
                }
            },
        };
        drawingCharts('browsers', config)    }
});