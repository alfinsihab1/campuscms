<script type="text/javascript" src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>

<script type="text/javascript">
    // Chart Doughnut
    class ChartDoughnut {
        // Constructor
        constructor(selectorId, data, rows = null, moneyFormat = false){
            this.selectorId = selectorId;
            this.data = data; // Has attributes: data, labels, colors
            this.rows = rows;
            this.moneyFormat = moneyFormat;
        }

        // Initialize chart
        init(){
            this.chart();
            this.legend();
            this.legendHeight();
            this.total();
        }

        // Generate chart
        chart(){
            var moneyFormat = this.moneyFormat;
            var ctx = document.getElementById(this.selectorId);
            var chart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: this.data.labels,
                    datasets: [{
                        data: this.data.data,
                        backgroundColor: this.data.colors,
                        borderWidth: 0
                    }],
                },
                options: {
                    responsive: true,
                    cutoutPercentage: 75,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function(tooltipItem, data) {
                                return moneyFormat == true ? thousand_format(data['datasets'][0]['data'][tooltipItem['index']], 'Rp ') : thousand_format(data['datasets'][0]['data'][tooltipItem['index']]);
                            }
                        }
                    }
                },
            });
            return chart;
        }

        // Add legend
        legend(){
            var html = '';
            html += '<ul class="list-group list-group-flush px-2">';
            for(var i=0; i<this.data.colors.length; i++){
                html += '<li class="list-group-item d-flex justify-content-between py-1 px-0">';
                html += '<div><i class="fa fa-circle mr-2" style="color: ' + this.data.colors[i] + '"></i>' + this.data.labels[i] + '</div>';
                html += '<div>' + thousand_format(this.data.data[i]) + '</div>';
                html += '</li>';
            }
            html += '</ul>';
            $('#'+this.selectorId).parents(".tile").find(".tile-footer").html(html);
        }

        // Set legend height
        legendHeight(){
            if(this.rows != null){
                var height = (this.rows * 30) - 1;
                $(".tile").each(function(key,elem){
                    $(elem).find(".list-group").css("height",height);
                });
            }
        }

        // Total
        total(){
            this.moneyFormat == true ? $("#"+this.selectorId).parents(".tile-body").find(".total").text(thousand_format(this.data.total, 'Rp ')) : $("#"+this.selectorId).parents(".tile-body").find(".total").text(thousand_format(this.data.total));
        }
    }

    // Chart Line
    class ChartLine {
        // Constructor
        constructor(selectorId, data, moneyFormat = false){
            this.selectorId = selectorId;
            this.data = data; // Has attributes: labels, datasets
            this.moneyFormat = moneyFormat;
        }

        // Initialize chart
        init(){
            return this.chart();
        }

        // Generate chart
        chart(){
            var moneyFormat = this.moneyFormat;
            var ctx = document.getElementById(this.selectorId);
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: this.data.labels,
                    datasets: this.datasets()
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                // min: 0,
                                beginAtZero: true,
                                callback: function(value, index, values){
                                    if(moneyFormat == true){
                                        return thousand_format(value.toString(), 'Rp ');
                                    }
                                    else{
                                        if(Math.floor(value) === value){
                                            return thousand_format(value.toString());
                                        }   
                                    }
                                }
                            }
                        }]
                    }
                }
            });
            $("#"+this.selectorId).siblings(".text-loading").remove(); // Remove loading
            return chart;
        }

        // Configure datasets
        datasets(){
            var datasets = this.data.datasets;
            for(var i=0; i<datasets.length; i++){
                datasets[i].backgroundColor = datasets[i].color;
                datasets[i].borderColor = datasets[i].color;
                datasets[i].borderWidth = 1;
                datasets[i].fill = false;
            }
            return datasets;
        }
    }

    // Chart Bar
    class ChartBar {
        // Constructor
        constructor(selectorId, data, moneyFormat = false){
            this.selectorId = selectorId;
            this.data = data; // Has attributes: labels, datasets
            this.moneyFormat = moneyFormat;
        }

        // Initialize chart
        init(){
            return this.chart();
        }

        // Generate chart
        chart(){
            var moneyFormat = this.moneyFormat;
            var ctx = document.getElementById(this.selectorId);
            var chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: this.data.labels,
                    datasets: this.datasets()
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                // min: 0,
                                beginAtZero: true,
                                callback: function(value, index, values){
                                    if(moneyFormat == true){
                                        if(Math.floor(value) === value){
                                            return thousand_format(value.toString(), 'Rp ');
                                        } 
                                    }
                                    else{
                                        if(Math.floor(value) === value){
                                            return thousand_format(value.toString());
                                        }   
                                    }
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                              return tooltipItem[0].label;
                            },
                            label: function(tooltipItem, data) {
                              return moneyFormat == true ? thousand_format(tooltipItem.yLabel.toString(), 'Rp ') : thousand_format(tooltipItem.yLabel.toString());
                            }
                        }
                    }
                }
            });
            $("#"+this.selectorId).siblings(".text-loading").remove(); // Remove loading
            return chart;
        }

        // Configure datasets
        datasets(){
            var datasets = this.data.datasets;
            for(var i=0; i<datasets.length; i++){
                datasets[i].backgroundColor = datasets[i].color;
                datasets[i].borderColor = datasets[i].color;
                datasets[i].borderWidth = 1;
                datasets[i].fill = false;
            }
            return datasets;
        }
    }
</script>

<style type="text/css">
    .tile > .tile-footer > .list-group {overflow-y: auto;}
    .tile > .tile-footer > .list-group::-webkit-scrollbar {width: 6px;}
    .tile > .tile-footer > .list-group::-webkit-scrollbar-thumb {background: rgba(0, 0, 0, 0.2); border-radius: 10px;}
</style>