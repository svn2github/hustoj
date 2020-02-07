(function ($) {
    "use strict";

    //Team chart
    var ctx = document.getElementById("team-chart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["2014", "2015", "2016", "2017", "2018"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [{
                data: [0, 7, 9, 7 ,4],
                label: "Expense",
                backgroundColor: 'rgba(249, 99, 50,.75)', 
                borderColor: 'rgba(249, 99, 50,.85)',
                borderWidth: 0.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#f96332',
                    },{
                label: "Target",
                data: [0, 11, 4, 5 ,12],
                backgroundColor: 'rgba(60, 213, 29, 0.75)',
                borderColor: 'rgba(60, 213, 29, 0.75)',
                borderWidth: 0.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#3cd51d',
                    }, {
                label: "Income",
                data: [0, 14, 5, 8 ,16],
                backgroundColor: 'rgba(135,222,117,.75)',
                borderColor: 'rgba(135,222,117,.75)',
                borderWidth: 0.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#87de75',
                    }]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },


            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                        }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                        }]
            },
            title: {
                display: false,
            }
        }
    });


    //Sales chart
    var ctx = document.getElementById("sales-chart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [{
                label: "Clothes",
                data: [0, 10, 20, 10, 25, 15, 150],
                backgroundColor: 'transparent',
                borderColor: '#e6a1f2',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#e6a1f2',

                    }, {
                label: "Foods",
                data: [0, 30, 10, 60, 50, 63, 10],
                backgroundColor: 'transparent',
                borderColor: '#ed7f7e',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ed7f7e',
                    }, {
                label: "Electronics",
                data: [0, 50, 40, 20, 40, 79, 20],
                backgroundColor: 'transparent',
                borderColor: '#87de75',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#87de75',
                    }]
        },
        options: {
            responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                        }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                        }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });



    



    //line chart
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    borderColor: "rgba(0,0,0,.09)",
                    borderWidth: "1",
                    backgroundColor: "rgba(0,0,0,.07)",
                    data: [22, 44, 67, 43, 76, 45, 12]
                            },
                {
                    label: "My Second dataset",
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.5)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [16, 32, 18, 26, 42, 33, 44]
                            }
                        ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    });


    //bar chart
    var ctx = document.getElementById("barChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(55, 160, 0, 0.5)"
                            },
                {
                    label: "My Second dataset",
                    data: [28, 48, 40, 19, 86, 27, 90],
                    borderColor: "rgba(0,0,0,0.09)",
                    borderWidth: "0",
                    backgroundColor: "rgba(0,0,0,0.07)"
                            }
                        ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                                }]
            }
        }
    });

    //radar chart
    var ctx = document.getElementById("radarChart");
    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [["Eating", "Dinner"], ["Drinking", "Water"], "Sleeping", ["Designing", "Graphics"], "Coding", "Cycling", "Running"],
            datasets: [
                {
                    label: "My First dataset",
                    data: [65, 59, 66, 45, 56, 55, 40],
                    borderColor: "rgba(55, 160, 0, 0.6)",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.4)"
                            },
                {
                    label: "My Second dataset",
                    data: [28, 12, 40, 19, 63, 27, 87],
                    borderColor: "rgba(55, 160, 0, 0.7",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.5)"
                            }
                        ]
        },
        options: {
            legend: {
                position: 'top'
            },
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });


    //pie chart
    var ctx = document.getElementById("pieChart");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: [
                                    "rgba(55,160,0,0.9)",
                                    "rgba(55,160,0,0.7)",
                                    "rgba(55,160,0,0.5)",
                                    "rgba(0,0,0,0.07)"
                                ],
                hoverBackgroundColor: [
                                    "rgba(55,160,0,0.9)",
                                    "rgba(55,160,0,0.7)",
                                    "rgba(55,160,0,0.5)",
                                    "rgba(0,0,0,0.07)"
                                ]

                            }],
            labels: [
                            "green",
                            "green",
                            "green"
                        ]
        },
        options: {
            responsive: true
        }
    });

    //doughut chart
    var ctx = document.getElementById("doughutChart");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: [
                                    "rgba(55,160,0,0.9)",
                                    "rgba(55,160,0,0.7)",
                                    "rgba(55,160,0,0.5)",
                                    "rgba(0,0,0,0.07)"
                                ],
                hoverBackgroundColor: [
                                    "rgba(55,160,0,0.9)",
                                    "rgba(55,160,0,0.7)",
                                    "rgba(55,160,0,0.5)",
                                    "rgba(0,0,0,0.07)"
                                ]

                            }],
            labels: [
                            "green",
                            "green",
                            "green",
                            "green"
                        ]
        },
        options: {
            responsive: true
        }
    });

    //polar chart
    var ctx = document.getElementById("polarChart");
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            datasets: [{
                data: [15, 18, 9, 6, 19],
                backgroundColor: [
                                    "rgba(55,160,0,0.9)",
                                    "rgba(55,160,0,0.8)",
                                    "rgba(55,160,0,0.7)",
                                    "rgba(0,0,0,0.2)",
                                    "rgba(55,160,0,0.5)"
                                ]

                            }],
            labels: [
                            "green",
                            "green",
                            "green",
                            "green"
                        ]
        },
        options: {
            responsive: true
        }
    });

    // single bar chart
    var ctx = document.getElementById("singelBarChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
            datasets: [
                {
                    label: "My First dataset",
                    data: [40, 55, 75, 81, 56, 55, 40],
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(55, 160, 0, 0.5)"
                            }
                        ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                                }]
            }
        }
    });




})(jQuery);