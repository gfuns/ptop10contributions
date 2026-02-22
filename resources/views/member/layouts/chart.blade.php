<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">
    let barLabels = @json($chartStats['period']);
    var options = {
        series: [{
                name: 'Sales',
                data: [{{ $chartStats['saleStats'] }}]
            },
            {
                name: 'Expenditure',
                data: [{{ $chartStats['expStats']}}]
            }
        ],
        chart: {
            type: 'bar',
            height: 380,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#28a745', '#dc3545'], // Green for Sales, Red for Expenditure
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: barLabels,
            title: {
                text: 'Day of The Month'
            }
        },
        yaxis: {
            title: {
                text: 'Amount (₦)'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "₦" + val.toLocaleString();
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
