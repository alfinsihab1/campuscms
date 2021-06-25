<script type="text/javascript" src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
<script>
    function generate_chart_line(selector, data, moneyFormat = false){
        var ctx = document.getElementById(selector);
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels,
                datasets: data.datasets
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
        return myChart;
    }

    function generate_chart_bar(selector, data, moneyFormat = false){
        var ctx = document.getElementById(selector);
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels,
                datasets: data.datasets
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
        return myChart;
    }

    function generate_chart_doughnut(selector, data, moneyFormat = false){
        var ctx = document.getElementById(selector);
        var myChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: data.labels,
                datasets: data.datasets,
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
        return myChart;
    }
	
	function generate_chart_legend(colors, data, selector){
		var html = '';
		html += '<ul class="list-group list-group-flush">';
		for(i=0; i<colors.length; i++){
			html += '<li class="list-group-item d-flex justify-content-between py-1 px-0">';
			html += '<div><i class="fa fa-circle mr-2" style="color: ' + colors[i] + '"></i>' + data.labels[i] + '</div>';
			html += '<div>' + thousand_format(data.data[i]) + '</div>';
			html += '</li>';
		}
		html += '</ul>';
		$(selector).parents(".tile").find(".tile-footer").html(html);
	}
    
    function add_canvas_loading(selector){
        $("#"+selector).before('<div class="text-center text-loading">Loading...</div>');
    }
    
    function remove_canvas_loading(selector){
        $("#"+selector).siblings(".text-loading").remove();
    }
</script>