<script type="text/javascript" src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
<script>
    function generate_chart_doughnut(selector, data){
        var ctx = document.getElementById(selector);
        var myChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: data.labels,
                datasets: data.datasets,
            },
            options: {
                responsive: true,
                cutoutPercentage: 75
            }
        });
        return myChart;
    }
</script>