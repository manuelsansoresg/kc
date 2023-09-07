<script>
    
    let titulo        = '{{ $chart1 != null? $chart1->commercial_name: 'Crediplus' }}'
    </script>
    @if ($status_id == 10)
    <script>
     const labels_options = [
            titulo+'(Tu crédito)',
            'Consupago (Mejor opción)',
        ];

        const data_options = {
            labels: labels_options,
            datasets: [{
                    label: 'Prestamo',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 0.5)',
                    data: [{{ $get_chart['prestamo'] }},20000],
                    borderWidth: 1,

                },
                {
                    label: 'Interés',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 0.5)', 
                    data: [{{ $get_chart['interes'] }}, 1000],
                    borderWidth: 1,
                },
                {
                    label: 'Comisión por apertura',
                    backgroundColor: 'rgba(255, 205, 86, 0.5)',
                    borderColor:'rgba(255, 205, 86, 0.5)',
                    data: [{{ $get_chart['comision_apertura'] }}, 0],
                    borderWidth: 1,
                },
            ] 
        };
         /* option */
       
       

         const config_options = {
            type: 'bar',
            data: data_options,
            options: {
                responsive: true,
                animation: {
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data') {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                indexAxis: 'y',
                plugins: {
                    legend: {
                            display: true,
                            labels: {
                                color: "white",
                                font: {
                                    weight: 'bold',
                                    size: '13'
                                },
                            }
                        },
                        title: {
                            display: false,
                        },
                        datalabels: {
                            display: false,
                            
                        },
                },
                scales: {
                    x: {
            stacked: true,
            ticks: {
                color: 'white',
                
                font: {
                    weight: 'bold',
                },
                display: true
            }
        },
        y: {
            stacked: true,
            ticks: {
                color: [color_financiera1, color_financiera2],
                
                font: {
                    weight: 'bold',
                    size: '13'
                },
                
            }
        }
                }
            },
        };
        /* option */
    </script>
    @endif
    <script>
        let inView        = false;
        let inViewPlazo   = false;
        let inViewInteres = false;
        let inViewOption  = false;
        
        let color_financiera1 = (titulo == 'Crediplus')? 'white' : 'white';
        let color_financiera2 = (titulo == 'Consupago')? 'white' : 'white';
        let color_financiera3 = (titulo == 'Ommsa')? 'white' : 'white';
        let color_financiera4 = (titulo == 'Financiera 4')? 'white' : 'white';
        let color_financiera5 = (titulo == 'Financiera 5')? 'white' : 'white';

        function isScrolledIntoView(elem)
        {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemTop <= docViewBottom) && (elemBottom >= docViewTop));
        }

        document.body.classList.add("dark-mode");
        sessionStorage.setItem("mode", "dark");

        var swiper = new Swiper(".swiper-partners", {
            slidesPerView: 3,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            breakpoints: {
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 32
                }
            }

        })
    </script>
    <script>
        const labels = [
            '{{ $chart1->commercial_name }}',
            '{{ $chart2->commercial_name }}',
            '{{ $chart3->commercial_name }}',
        ];

        const data = {
            labels: labels,
            datasets: [{
                    label: 'Financiera1',
                    data: [{{ $chart1->chart_costo_anual_total == null ? 0 : $chart1->chart_costo_anual_total }}, {{ $chart2->chart_costo_anual_total == null ? 0 : $chart2->chart_costo_anual_total }}, {{ $chart3->chart_costo_anual_total == null ? 0 : $chart3->chart_costo_anual_total }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)', //rojo
                        'rgba(255, 159, 64, 0.5)',// cafe
                        'rgba(255, 205, 86, 0.5)', // marron
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                    ],
                    color: ['#fff'],
                    borderWidth: 1,
                    borderRadius: 2,
                },

            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                animation: {
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data') {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },

                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            return value + '%';
                        }
                    },
                    

                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: [color_financiera1, color_financiera2, color_financiera3, color_financiera4, color_financiera5],
                            font: {
                                weight: 'bold',
                                size: '13'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            color: 'white',
                            font: {
                                weight: 'bold',
                            },
                            display: false
                        }
                    }
                },

            },
        };
        Chart.register(ChartDataLabels);
        Chart.defaults.set('plugins.datalabels', {
            color: '#FFF',
            font: {
                weight: 'bold',
            }
        });

        

        
        /*  intereses */
        const labels_interes = [
            '{{ $chart1->commercial_name }}',
            '{{ $chart2->commercial_name }}',
            '{{ $chart3->commercial_name }}',
        ];

        const data_interes = {
            labels: labels_interes,
            datasets: [{
                    label: 'Capital',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 0.5)',
                    data: [{{ $chart1->chart_capital == null ? 0 : $chart1->chart_capital }},{{ $chart2->chart_capital == null ? 0 : $chart2->chart_capital }}, {{ $chart3->chart_capital == null ? 0 : $chart3->chart_capital }}],

                },
                {
                    label: 'Interés',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 0.5)',
                    data: [{{ $chart1->chart_interes == null ? 0 : $chart1->chart_interes }}, {{ $chart2->chart_interes == null ? 0 : $chart2->chart_interes }} , {{ $chart3->chart_interes == null ? 0 : $chart3->chart_interes }}],
                },
                {
                    label: 'Comisiónes',
                    backgroundColor: 'rgba(255, 205, 86, 0.5)',
                    borderColor: 'rgba(255, 205, 86, 0.5)',
                    data: [{{ $chart1->chart_comision == null ? 0 : $chart1->chart_comision }}, {{ $chart2->chart_comision == null ? 0 : $chart2->chart_comision }} , {{ $chart3->chart_comision == null ? 0 : $chart3->chart_comision }}],
                },
                {
                    label: 'IVA',
                    backgroundColor: 'rgb(45,99, 141)',
                    borderColor: 'rgb(45,99, 141)',
                    data: [{{ $chart1->chart_iva == null ? 0 : $chart1->chart_iva }}, {{ $chart2->chart_iva == null ? 0 : $chart2->chart_iva }} , {{ $chart3->chart_iva == null ? 0 : $chart3->chart_iva }}],
                },
            ] 
        };

        const config_interes = {
            type: 'bar',
            data: data_interes,
            options: {
                responsive: true,
                animation: {
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data') {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                indexAxis: 'y',
                plugins: {
                    legend: {
                            display: true,
                            labels: {
                                color: "white",
                                font: {
                                    weight: 'bold',
                                },
                            }
                        },
                        title: {
                            display: false,
                        },
                        datalabels: {
                            display: false,
                            
                        },
                },
                scales: {
                    x: {
            stacked: true,
            ticks: {
                color: 'white',
                font: {
                    weight: 'bold',
                },
                display: true
            }
        },
        y: {
            stacked: true,
            ticks: {
                color: [color_financiera1, color_financiera2, color_financiera3, color_financiera4, color_financiera5],
                font: {
                    weight: 'bold',
                    size: '13'
                },
                
            }
        }
                }
            },
        };
        
        /* plazo */
        const labels_plazo = [
            '{{ $chart1->commercial_name }}',
            '{{ $chart2->commercial_name }}',
            '{{ $chart3->commercial_name }}',
        ];

        const data_plazo = {
            labels: labels_plazo,
            datasets: [{
                    label: 'Años',
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    borderColor:   ['rgba(255, 99, 132, 2)', 'rgba(255, 159, 64, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    data: [{{ isset($chart1->chart_plazo_maximo) ? $chart1->chart_plazo_maximo : 0 }}, {{ isset($chart2->chart_plazo_maximo) ? $chart2->chart_plazo_maximo : 0 }} , {{ isset($chart3->chart_plazo_maximo) ? $chart3->chart_plazo_maximo : 0 }}],
                    borderWidth: 2,

                },

            ]
        };

        const config_plazo = {
            type: 'bar',
            data: data_plazo,
            options: {
                responsive: true,
                animation: {
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data') {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                indexAxis: 'y',
                plugins: {
                    legend: {
                            display: false,
                        },
                        title: {
                            display: false,
                        },
                        datalabels: {
                            formatter: function(value, context) {
                                return value + ' años';
                            }
                        },
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: 'white',
                            font: {
                                weight: 'bold',
                            },
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            color: [color_financiera1, color_financiera2, color_financiera3, color_financiera4, color_financiera5],
                            font: {
                                weight: 'bold',
                                size: '13'
                            },
                            
                        }
                    }
                }
            },
        };

       
        
        function scrollToAnchor(aid){
            $('#content-hide').show();
            var aTag = $("a[name='"+ aid +"']");
            $('html,body').animate({scrollTop: aTag.offset().top},'slow');
        }

        $(window).scroll(function() {

            if (isScrolledIntoView('#myChartInteres')) {
                
                if (inViewInteres == false) {
                    inViewInteres = true;
                    const myChart_interes = new Chart(
                        document.getElementById('myChartInteres'),
                        config_interes
                    );
                }
                
            } else {
                inViewInteres = false;  
            }
            
            if (isScrolledIntoView('#myChart')) {
                if (inView) { return; }
                inView = true;
                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            } else {
                inView = false;  
            }
            
            if (isScrolledIntoView('#myChartPlazo')) {
                if (inView) { return; }
                inViewPlazo = true;
                const myChart_plazo = new Chart(
                    document.getElementById('myChartPlazo'),
                    config_plazo
                );
            } else {
                inViewPlazo = false;  
            }
            
            
            if (isScrolledIntoView('#chartOption')) {
                if (inView) { return; }
                inViewOption = true;
                const myChart_option = new Chart(
                    document.getElementById('chartOption'),
                    config_options
                );
            } else {
                inViewOption = false;  
            }
        });

        window.showFinalFinancial = function() {
            $('#final-financials').show('slow');
        }
    </script>