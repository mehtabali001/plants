var base_url=$("#base_url").val();

var ctx = document.getElementById('plant_chart_redius');
 //donut chart
        var donutChart = {
            labels: stocks_name,
           
            datasets: [
                {
                    data: stocks_data,
                    backgroundColor: [
                        "#596234",
                        "#4d79f6",
                        "#e0e7fd",
                        "#5d535e",
                        "#b7b8b6",
                        "#c99793",
                        "#7d6bd1",
                        "#66A5AD",
                        
                    ],
                    borderColor: "transparent",
                    innerRadius: "55%",
                    hoverBackgroundColor: [
                        "#596234",
                        "#4d79f6",
                        "#e0e7fd",
                        "#5d535e",
                        "#b7b8b6",
                        "#c99793",
                        "#7d6bd1",
                        "#66A5AD",
                    ],
                    hoverBorderColor: "transparent",
                    weight: 6
                   
                }],
               
        };

        var donutOpts = {
            responsive: true,
            cutoutPercentage: 50,
            legend : {
                align: "start",
                labels : {
                  fontColor : '#8997bd'  
                }
            }    
        };
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: donutChart,
    options: donutOpts
});


