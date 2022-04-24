$(window).load(function(){
    
    
    
if($("#main_chart").length > 0){
/* main page middle chart */    
    var mChartData  = new Array();
    var mChartData2 = new Array();
    var mChartData3 = new Array();
        var point = 1;
        for (var i = 1; i < 31; i += 1) {
            
            point = Math.abs((i*2) * Math.cos(i));
            
            mChartData.push(Math.round(point*2));
            mChartData2.push(Math.round(point*1));
            mChartData3.push(Math.round(point*3));
        }

        mChart = new Highcharts.Chart({
            chart: {
                renderTo: 'main_chart',                
                marginTop: 80,
                marginBottom: 30
            },
            title: {
                text: 'Users Activity',
                x: -20 //center
            },
            subtitle: {
                text: 'Statistics for the last month',
                x: -20
            },
            xAxis: {
                categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
                             '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24',
                             '25', '26', '27', '28', '29', '30']
            },
            yAxis: {
                title: {
                    text: 'Count visits'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#3E4F69'
                }]
            },
            tooltip: {                
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' visits';
                    } else {
                        s = 'Day '+ this.x  +': '+ this.y+' visits';
                    }
                    return s;
                }                
            },
            legend: {                
                align: 'top',
                verticalAlign: 'top',
                x: -10,
                y: 30,
                borderWidth: 0
            },
            series: [{
                type: 'line',
                name: 'Unique visits',
                data: mChartData
            }, {
                type: 'line',
                name: 'Returning visits',
                data: mChartData2
            },{
                type: 'line',
                name: 'Clicks',
                data: mChartData3
            },{
                type: 'pie',
                name: 'Total visits',
                data: [{
                    name: 'Unique',
                    y: 2000,
                    color: '#4572A7' // Jane's color
                }, {
                    name: 'Returning',
                    y: 1450,
                    color: '#AA4643' // John's color
                }, {
                    name: 'Not Returned',
                    y: 550,
                    color: '#89A54E' // Joe's color
                }],
                center: [100, 80],
                size: 150,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });    
/* eof main page middle chart */     
}

if($("#line_1").length > 0){    
    
 line_1 = new Highcharts.Chart({
            chart: {
                renderTo: 'line_1',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Monthly Average Temperature',
                x: -20 //center
            },
            subtitle: {
                text: 'Example of subtitle',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#3E4F69'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'New York',
                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
            }, {
                name: 'Kyiv',
                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });        
}

if($("#line_2").length > 0){
    
    
line_2 = new Highcharts.Chart({
            chart: {
                renderTo: 'line_2',
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Example of subtitle'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });    
        
}

if($("#pie_1").length > 0){
    
    
 pie_1 = new Highcharts.Chart({
            chart: {
                renderTo: 'pie_1',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Browser market shares at a specific website, 2010'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
        });    
    
    
}

if($("#pie_2").length > 0){
    
        var colors = Highcharts.getOptions().colors,
            categories = ['MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera'],
            name = 'Browser brands',
            data = [{
                    y: 55.11,
                    color: colors[0],
                    drilldown: {
                        name: 'MSIE versions',
                        categories: ['MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'],
                        data: [10.85, 7.35, 33.06, 2.81],
                        color: colors[0]
                    }
                }, {
                    y: 21.63,
                    color: colors[1],
                    drilldown: {
                        name: 'Firefox versions',
                        categories: ['Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'],
                        data: [0.20, 0.83, 1.58, 13.12, 5.43],
                        color: colors[1]
                    }
                }, {
                    y: 11.94,
                    color: colors[2],
                    drilldown: {
                        name: 'Chrome versions',
                        categories: ['Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0',
                            'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'],
                        data: [0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22],
                        color: colors[2]
                    }
                }, {
                    y: 7.15,
                    color: colors[3],
                    drilldown: {
                        name: 'Safari versions',
                        categories: ['Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon',
                            'Safari 3.1', 'Safari 4.1'],
                        data: [4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14],
                        color: colors[3]
                    }
                }, {
                    y: 2.14,
                    color: colors[4],
                    drilldown: {
                        name: 'Opera versions',
                        categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
                        data: [ 0.12, 0.37, 1.65],
                        color: colors[4]
                    }
                }];
    
    
        // Build the data arrays
        var browserData = [];
        var versionsData = [];
        for (var i = 0; i < data.length; i++) {
    
            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });
    
            // add version data
            for (var j = 0; j < data[i].drilldown.data.length; j++) {
                var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    color: Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
    
        // Create the chart
        pie_2 = new Highcharts.Chart({
            chart: {
                renderTo: 'pie_2',
                type: 'pie'
            },
            title: {
                text: 'Browser market share, April, 2011'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false
                }
            },
            tooltip: {
        	    valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function() {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: 'white',
                    distance: -30
                }
            }, {
                name: 'Versions',
                data: versionsData,
                innerSize: '60%',
                dataLabels: {
                    formatter: function() {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ this.y +'%'  : null;
                    }
                }
            }]
        });    
    
}

if($("#pie_3").length > 0){
    
    pie_3 = new Highcharts.Chart({
            chart: {
                renderTo: 'pie_3',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Browser market shares at a specific website, 2010'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
        });    
    
}

if($("#pie_4").length > 0){
    
// Radialize the colors
		Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        pie_4 = new Highcharts.Chart({
            chart: {
                renderTo: 'pie_4',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Browser market shares at a specific website, 2010'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
        });

}

if($("#column_1").length > 0){
    
 column_1 = new Highcharts.Chart({
            chart: {
                renderTo: 'column_1',
                type: 'column'
            },
            title: {
                text: 'Monthly Average Rainfall'
            },
            subtitle: {
                text: 'Subtitle line example'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' mm';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                name: 'Tokyo',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
    
            }, {
                name: 'New York',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
    
            }, {
                name: 'London',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
    
            }, {
                name: 'Kyiv',
                data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
    
            }]
        });        
    
}

if($("#column_3").length > 0){

column_3 = new Highcharts.Chart({
            chart: {
                renderTo: 'column_3',
                type: 'column'
            },
            title: {
                text: 'Stacked column chart'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total fruit consumption'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, 2, 3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, 2, 5]
            }]
        });

}
if($("#column_2").length > 0){
column_2 = new Highcharts.Chart({
            chart: {
                renderTo: 'column_2',
                type: 'column'
            },
            title: {
                text: 'Column chart with negative values'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +'';
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, -2, -3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, -2, 5]
            }]
        });    
}
if($("#column_4").length > 0){
    
column_4 = new Highcharts.Chart({
            chart: {
                renderTo: 'column_4',
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'World\'s largest cities per 2008'
            },
            xAxis: {
                categories: [
                    'Tokyo',
                    'Jakarta',
                    'New York',
                    'Seoul',
                    'Manila',
                    'Mumbai',
                    'Sao Paulo',
                    'Mexico City',
                    'Dehli',
                    'Osaka',
                    'Cairo',
                    'Kolkata',
                    'Los Angeles',
                    'Shanghai',
                    'Moscow',
                    'Beijing',
                    'Buenos Aires',
                    'Guangzhou',
                    'Shenzhen',
                    'Istanbul'
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Population (millions)'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        'Population in 2008: '+ Highcharts.numberFormat(this.y, 1) +
                        ' millions';
                }
            },
            series: [{
                name: 'Population',
                data: [34.4, 21.8, 20.1, 20, 19.6, 19.5, 19.1, 18.4, 18,
                    17.3, 16.8, 15, 14.7, 14.5, 13.3, 12.8, 12.4, 11.8,
                    11.7, 11.2],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });            
}

});


