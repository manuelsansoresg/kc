<script>
    
    let titulo        = '{{ $chart1 != null? $chart1->commercial_name: 'Crediplus' }}'
    </script>
    @if ($status_id == 10)
    <script>
     const labels_options = [
            titulo+'(Tu crédito)',
            'Consupago (Mejor opción)',
        ];

       
        /* option */
    </script>
    @endif
    @php
        $color_financiera2 = ($my_product_financial!= null && $chart2 != null && $my_product_financial->id == $chart2->id) || ($chart2 != null &&$credit->financial_product_id == $chart2->id) ? '#644EF3' : 'white';
        $color_financiera3 = ($my_product_financial!= null && $chart3 != null  && $my_product_financial->id == $chart3->id) || ($chart3 != null && $credit->financial_product_id == $chart3->id ) ? '#644EF3' : 'white';
        $color_financiera4 = $my_product_financial!= null && $chart4 != null && $my_product_financial->id == $chart4->id ? '#644EF3' : 'white';
    @endphp
    {{-- {{ dd($my_product_financial,$chart1, $chart2, $chart3, $chart4 ) }} --}}
    <script>
        let inView        = false;
        let inViewPlazo   = false;
        let inViewInteres = false;
        let inViewOption  = false;
        
        let color_financiera1 = '#F9662E';
        let color_financiera2 = '<?php echo $color_financiera2 ?>';
        let color_financiera3 = '<?php echo $color_financiera3 ?>';
        let color_financiera4 = '<?php echo $color_financiera4 ?>';
        let color_financiera5 = 'white';

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
         <?php if($chart4 == null){ ?>
            const labels = [
            '{{ isset($chart1->commercial_name) ? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name) ? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name) ? $chart3->commercial_name : null }}',
        ];
        <?php } else { ?>
            const labels = [
            '{{ isset($chart1->commercial_name)? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name)? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name)? $chart3->commercial_name : null }}',
            '{{ isset($chart4->commercial_name)? $chart4->commercial_name : null }}',
        ];
        <?php } ?>
        

        const data = {
            labels: labels,
            datasets: [{
                    label: 'Financiera1',
                    <?php if($chart4 == null){ ?>
                        data: [{{ !isset($chart1->chart_costo_anual_total) ? 0 : $chart1->chart_costo_anual_total }}, {{ !isset($chart2->chart_costo_anual_total) ? 0 : $chart2->chart_costo_anual_total }}, {{ !isset( $chart3->chart_costo_anual_total) ? 0 : $chart3->chart_costo_anual_total }}],
                        <?php } else { ?>
                            data: [{{ !isset($chart4->chart_costo_anual_total) ? 0 : $chart4->chart_costo_anual_total }},{{ !isset($chart1->chart_costo_anual_total) ? 0 : $chart1->chart_costo_anual_total }}, {{ !isset($chart2->chart_costo_anual_total) ? 0 : $chart2->chart_costo_anual_total }}, {{ !isset($chart3->chart_costo_anual_total) ? 0 : $chart3->chart_costo_anual_total }}],
                        <?php } ?>
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
        <?php if($chart4 == null){ ?>
            const labels_interes = [
            '{{ isset($chart1->commercial_name)? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name)? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name)? $chart3->commercial_name : null }}',
            ];
        <?php } else { ?>
            const labels_interes = [
           '{{ isset($chart1->commercial_name)? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name)? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name)? $chart3->commercial_name : null }}',
            '{{ isset($chart4->commercial_name)? $chart4->commercial_name : null }}',
            ];
        <?php } ?>
       

        const data_interes = {
            labels: labels_interes,
            <?php if($chart4 == null){ ?>
                datasets: [{
                    label: 'Capital',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 0.5)',
                    data: [{{ !isset($chart1->chart_capital) ? 0 : $chart1->chart_capital }},{{ !isset($chart2->chart_capital) ? 0 : $chart2->chart_capital }}, {{ !isset($chart3->chart_capital) ? 0 : $chart3->chart_capital }}],

                },
                {
                    label: 'Interés',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 0.5)',
                    data: [{{ !isset($chart1->chart_interes) ? 0 : $chart1->chart_interes }}, {{ !isset($chart2->chart_interes) ? 0 : $chart2->chart_interes }} , {{ !isset($chart3->chart_interes) ? 0 : $chart3->chart_interes }}],
                },
                {
                    label: 'Comisiónes',
                    backgroundColor: 'rgba(255, 205, 86, 0.5)',
                    borderColor: 'rgba(255, 205, 86, 0.5)',
                    data: [{{ !isset($chart1->chart_comision)  ? 0 : $chart1->chart_comision }}, {{ !isset($chart2->chart_comision)  ? 0 : $chart2->chart_comision }} , {{ !isset($chart3->chart_comision)  ? 0 : $chart3->chart_comision }}],
                },
                {
                    label: 'IVA',
                    backgroundColor: 'rgb(45,99, 141)',
                    borderColor: 'rgb(45,99, 141)',
                    data: [{{ !isset($chart1->chart_iva) ? 0 : $chart1->chart_iva }}, {{ !isset($chart2->chart_iva) ? 0 : $chart2->chart_iva }} , {{ !isset($chart3->chart_iva) ? 0 : $chart3->chart_iva }}],
                },
            ] 
                <?php } else { ?>
                    datasets: [{
                    label: 'Capital',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 0.5)',
                    data: [{{ !isset($chart4->chart_capital) ? 0 : $chart4->chart_capital }}, {{ !isset($chart1->chart_capital) ? 0 : $chart1->chart_capital }},{{ !isset($chart2->chart_capital) ? 0 : $chart2->chart_capital }}, {{ !isset($chart3->chart_capital) ? 0 : $chart3->chart_capital }}],

                },
                {
                    label: 'Interés',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 0.5)',
                    data: [{{ !isset($chart4->chart_interes) ? 0 : $chart4->chart_interes }},{{ !isset($chart1->chart_interes) ? 0 : $chart1->chart_interes }}, {{ !isset($chart2->chart_interes) ? 0 : $chart2->chart_interes }} , {{ !isset($chart3->chart_interes) ? 0 : $chart3->chart_interes }}],
                },
                {
                    label: 'Comisiónes',
                    backgroundColor: 'rgba(255, 205, 86, 0.5)',
                    borderColor: 'rgba(255, 205, 86, 0.5)',
                    data: [{{ !isset($chart4->chart_comision) ? 0 : $chart4->chart_comision }},{{ !isset($chart1->chart_comision) ? 0 : $chart1->chart_comision }}, {{ !isset($chart2->chart_comision) ? 0 : $chart2->chart_comision }} , {{ !isset($chart3->chart_comision) ? 0 : $chart3->chart_comision }}],
                },
                {
                    label: 'IVA',
                    backgroundColor: 'rgb(45,99, 141)',
                    borderColor: 'rgb(45,99, 141)',
                    data: [{{ !isset($chart4->chart_iva) ? 0 : $chart4->chart_iva }},{{ !isset($chart1->chart_iva) ? 0 : $chart1->chart_iva }}, {{ !isset($chart2->chart_iva) ? 0 : $chart2->chart_iva }} , {{ !isset($chart3->chart_iva) ? 0 : $chart3->chart_iva }}],
                },
            ] 
                    <?php } ?>
            
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
        <?php if($chart4 == null){ ?>
            const labels_plazo = [
            '{{ isset($chart1->commercial_name)? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name)? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name)? $chart3->commercial_name : null }}',
        ];
        <?php } else { ?>
            const labels_plazo = [
            '{{ isset($chart1->commercial_name)? $chart1->commercial_name : null }}',
            '{{ isset($chart2->commercial_name)? $chart2->commercial_name : null }}',
            '{{ isset($chart3->commercial_name)? $chart3->commercial_name : null }}',
            '{{ isset($chart4->commercial_name)? $chart4->commercial_name : null }}',
        ];
        <?php } ?>
        

        const data_plazo = {
            labels: labels_plazo,
            
            datasets: [{
                    label: 'Años',
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    borderColor:   ['rgba(255, 99, 132, 2)', 'rgba(255, 159, 64, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    <?php if($chart4 == null){ ?>
                        data: [{{ isset($chart1->chart_plazo_maximo) ? $chart1->chart_plazo_maximo : 0 }}, {{ isset($chart2->chart_plazo_maximo) ? $chart2->chart_plazo_maximo : 0 }} , {{ isset($chart3->chart_plazo_maximo) ? $chart3->chart_plazo_maximo : 0 }}],
                        <?php } else { ?>
                            data: [{{ isset($chart4->chart_plazo_maximo) ? $chart4->chart_plazo_maximo : 0 }},{{ isset($chart1->chart_plazo_maximo) ? $chart1->chart_plazo_maximo : 0 }}, {{ isset($chart2->chart_plazo_maximo) ? $chart2->chart_plazo_maximo : 0 }} , {{ isset($chart3->chart_plazo_maximo) ? $chart3->chart_plazo_maximo : 0 }}],
                        <?php } ?>
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
                                return value + ' meses';
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
            
            
            /* if (isScrolledIntoView('#chartOption')) {
                if (inView) { return; }
                inViewOption = true;
                const myChart_option = new Chart(
                    document.getElementById('chartOption'),
                    config_options
                );
            } else {
                inViewOption = false;  
            } */
        });

        window.showFinalFinancial = function() {
            $('#final-financials').show('slow');
        }
    </script>