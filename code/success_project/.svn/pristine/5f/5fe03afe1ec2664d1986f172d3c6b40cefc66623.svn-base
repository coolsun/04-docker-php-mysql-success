/*
 2014/01/18

 Accoding to Demo Web site.

 1. piechart();
    costbarchart();
 2. assetsbarchart();
 3. twicebarchart();
 4. depositchart();
 5. twicelinechart();
 6. profitchart();
 7. weightchart();
 8. linechart();
*/


/*
 Get random color code
*/
function randomHexColorCode() {
     return '#' + Math.floor(Math.random()*16777215).toString(16);
}

/*
 Pie Chart

 [Dependencies]
 jquery.js
 highchart.js/highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id, such as 'piechart'
 datasetName: the name shows when cursor move on piechart, such as 'Cost'
 dataset: 2 dimension array data structure, such as
 		  [ [ itemName1, itemValue1 ], [ itemName2, itemValue2 ], [ itemName3, itemValue3 ], ... ]
 sumName: such as '總計' or 'Sum' ... for different language
 isMoney: true or false, format the itemValue to Money formation, example: 20000 -> 20,000.00.
          This need Plugin - accounting.min.js
titleName
titleXshift: shift of tile at x axis, default is -108

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/22
*/
function piechart( chartDivId, datasetName, dataset, sumName, isMoney, titleXshift ) {
	titleXshift = typeof titleXshift !== 'undefined' ? titleXshift : -108;

	//Default 10 Colors
	var sliceColors = ['#DE5314', '#E9C018', '#8BC200', '#397DC8', '#BF54C3',
        	    	   '#ABABAC', '#953329', '#50AF72', '#E17D14', '#7D7D7D'];
    //If data items more than 10, random create not repeated colors
    if( dataset.length > 10 ) {
    	for( var i = 0 ; i < dataset.length - 10 ; i++ ) {
    		var tempColorCode = randomHexColorCode();
    		//alert(tempColorCode + ' => ' + sliceColors.indexOf( tempColorCode ));
    		if( $.inArray( tempColorCode, sliceColors ) > -1 ) {2
    			i--;
    		}
    		else {
    			sliceColors.push( tempColorCode );
    		}
    	}
    }
    //Transform to gradient color data structure
    var chartColors = [];
    for( var i in sliceColors ) {
    	chartColors.push(
    		{
    		        radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
    		        stops: [
    		            [0, Highcharts.Color( sliceColors[i] ).brighten(  0.3 ).get('rgb')],
    		            [1, Highcharts.Color( sliceColors[i] ).brighten( -0.2 ).get('rgb')] // darken
    		        ]
    		}
    	);
    }

    /*
     Sum of dataset
    */
    var sum = 0;
    for( var i in dataset ) {
    	sum += dataset[i][1];
    }
    dataset.push( {name: sumName, y: 0.0, color: '#CCCCCC'} );

    /*
     Highcharts Settings
    */
	chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            type: 'pie',
            events: {
                load: function(event) {
                   $('#'+chartDivId).find('.item:not(:last):odd').css('background-color', '#CDE5FF');
                   $('#'+chartDivId).find('.item:last').css('background-color', '#CCCCCC');
                   $('#'+chartDivId).find('.item:last .sumIconMask').css('border-width', parseFloat($('#'+chartDivId).find('.item:last').css('height'))/2 +'px' );
                   var valueMaxWidth = 0;
                   $('#'+chartDivId).find('.item').each(function(){
                   		if( parseInt( $(this).find('span:eq(1)').css('width') ) > valueMaxWidth ) {
                   			valueMaxWidth = parseInt( $(this).find('span:eq(1)').css('width') );
                   		}
                   });
                   $('#'+chartDivId).find('.item').each(function(){
                   			$(this).find('span:eq(1)').css('width', valueMaxWidth+'px');
                   });
                   if( navigator.userAgent.match(/Windows NT/i) || navigator.userAgent.match(/msie/i) ) {
                        //$('#'+chartDivId).find('.last-item').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-name-sum').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-value').css('padding-top', '1px');
                        $('#'+chartDivId).find('.last-item div.item-percent').css('padding-top', '1px');
                        //$('#'+chartDivId).find('div.item-name').css('padding-top', '2px');
                   }
                }
            },
            height: 320,
            //width: 640
        },
        credits:{
            enabled: false
        },
        title: {
            text: datasetName,
            verticalAlign: 'bottom',
            x: titleXshift,
        	y: -10,
        	style: { "fontSize": "14px" }
        },
        colors : chartColors,
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            y: -20,
			borderWidth: 1,
            margin: 100,
            useHTML: true,
            itemStyle: {
                "fontWeight" : "normal"
            },
			labelFormatter: function() {
                if( this.name == sumName ) {
                	var tempSum;
                	if( isMoney ) {
                		tempSum = accounting.formatMoney( sum );
                	}
                	else {
                		tempSum = sum.toFixed(2);
                	}
                    return ['<div id="sum" class="item last-item" style="width: 225px; height: 18px;">',
                                '<div class="sumIconMask" style="position: absolute; top: 0; left: -22px; height: 18px; width: 24px; background-color: #ccc;">&nbsp;</div>',
                                '<div class="item-name-sum" style="box-sizing: border-box; display: inline-block; padding-left: 5px; width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px;">',this.name,'</div>',
                                '<div class="item-value" style="box-sizing: border-box; display: inline-block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px;">',tempSum,'</div>',
                                '<div class="item-percent" style="box-sizing: border-box; display: inline-block; width: 45px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px; text-align: right; padding-right: 5px;">100%</div>',
                            '</div>'].join('');
                }
                var tempValue;
                if( isMoney ) {
                		tempValue = accounting.formatMoney( this.y );
               	}
               	else {
                		tempValue = this.y;
                }
                return ['<div id="sum" class="item last-item" style="width: 225px; height: 18px;">',
                            '<div class="item-name-sum" style="box-sizing: border-box; display: inline-block; padding-left: 5px; width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px;">',this.name,'</div>',
                            '<div class="item-value" style="box-sizing: border-box; display: inline-block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px;">',tempValue,'</div>',
                            '<div class="item-percent" style="box-sizing: border-box; display: inline-block; width: 45px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; height: 18px; line-height:18px; text-align: right; padding-right: 5px;">',Math.round( this.percentage ),'%</div>',
                        '</div>'].join('');
			}
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                borderWidth: 0,
                size: 242,
                center: [120, 110],
                dataLabels: {
                    enabled: false,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                    }
                },
                states : {
                    hover: {
                        // enabled: false,
                        halo: {
                            size: 0
                        },
                        marker: {
                            enabled: false
                        }
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: datasetName,
            data: dataset,
            startAngle: -90,
            animation: {
                duration: 2000
            }
        }],
        exporting: {
            url: 'export-chart/index.php'
        }
    });

    return chart;
}

/*
 Cost Bar Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetName: the name of bar, such as 'Item Cost'
 dataset: such as
          [ { y : itemValue1, p: itemProportion1 }, { y : itemValue2, p: itemProportion2 }, ... ]
 xAxisNames: such as
            [ itemName1, itemName2, itemName3, ... ]
 yAxisTitle: such as '(單位: 千元)'
 chartTitle: the name of chart, such as 'Cost Status'
 costName: shows when cursor move on bar ,such as 'Cost'
 proportionName: shows when cursor move on bar ,such as '百分比'
 barMaxNum: how many bars are visible in chart, may use scroll, such as 12
 isMoney: true or false, format the itemValue to Money formation, example: 20000 -> 20,000.00.
          This need Plugin - accounting.min.js

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function costbarchart( chartDivId, datasetName, dataset, xAxisNames, yAxisTitle, chartTitle, costName, proportionName, barMaxNum, isMoney ) {

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( dataset.length == barMaxNum || dataset.length < barMaxNum ) {
        //alert(dataset.length+'x'+barMaxNum);
        barMaxNum = dataset.length;
        isScrollable = false;
        titleShift = 0;
    }
    barMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift,
            style: { "fontSize": "14px" }
        },
        scrollbar:{
                enabled:isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#5408A1'],
                  [0.4, '#9C59DE'],
                  [0.6, '#9C59DE'],
                  [1, '#5408A1']
                ]
            }
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {
                    var chart = this.chart;

                    chart.yAxis[0].update({
                        min: 0,
                        max: yMax
                    });
                }
            },
            labels: {
            	y: 20,
                style: {
                    "fontSize" : '14px'
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        tooltip: {
            formatter: function() {
                    var tempValue;
                    if( isMoney ) {
                            tempValue = accounting.formatMoney( this.y );
                    }
                    else {
                            tempValue = this.y;
                    }
                    var tip = '<b>'+ this.series.name +':</b> '+ this.x +'<br/><b>'+ costName +': </b>' + tempValue;
                    if( this.point.p ) {
                        tip += '<br><b>'+ proportionName +': </b>' + this.point.p;
                    }
                    return tip;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                pointWidth: 22,
                borderWidth: 0
            }
        },
        series: [{
            type: 'column',
            name: datasetName,
            data: dataset,
            xAxis: 0
        }]
    });

}

/*
 Assets Bar Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetNames: the name of bar, such as
            ['資產', '負債', '淨值']
 datasets: property and debt, two dimension array, first subarray is property and last one is debt, such as
          [ [ 10, 20, 30, ... ], [ -5, -3, -6, ... ] ]
 itemNames: date, such as
            [ '1/01', '2/13', '5/08', ... ]
 yAxisTitle: such as '(單位: 千元)'
 chartTitle: the name of chart, such as 'Cost Status'
 barMaxNum: how many grouping bars are visible in chart, may use scroll, such as 12
 isMoney: true or false, format the itemValue to Money formation, example: 20000 -> 20,000.00.
          This need Plugin - accounting.min.js

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function assetsbarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitle, chartTitle, barMaxNum, isMoney ) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    for( var i in datasets) {
        var maxValue = Math.max.apply(Math, datasets[i]);
        if( maxValue > initYMax ) {
            initYMax = maxValue;
        }
    }

    var datasetMaxLength = 0;
    datasets[0].length > datasets[1].length ? datasetMaxLength = datasets[0].length : datasetMaxLength = datasets[1].length;

    var nets = [];
    for( var i=0 ; i < datasetMaxLength ; i++ ) {
        nets.push( datasets[0][i] + datasets[1][i]  );
    }

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == barMaxNum || datasetMaxLength < barMaxNum ) {
        //alert(dataset.length+'x'+barMaxNum);
        barMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    barMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
                enabled:isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#1A8A52'],
                  [0.4, '#42B37A'],
                  [0.6, '#42B37A'],
                  [1, '#1A8A52']
                ]
            },
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#0000CC'],
                  [0.4, '#5555FF'],
                  [0.6, '#5555FF'],
                  [1, '#0000CC']
                ]
            },
            '#BE0200'
        ],
        tooltip: {
            formatter: function() {
                var tooltipHTML = [
                    '<div>', this.x, '</div>'
                ];
                // tooltipHTML.concat( ['<div>', '1</div>'] );
                for (var i in this.points)
                {
                    tooltipHTML.push( '<div>' );
                    tooltipHTML.push( '<span>' +this.points[i].series.name+ ': </span>' );
                    if ( isMoney )
                    {
                        tooltipHTML = tooltipHTML.concat( [
                            '<span><b>', accounting.formatMoney(this.points[i].y).replace("$", ''), '</b></span>',
                        ] );
                    }
                    else
                    {
                        tooltipHTML = tooltipHTML.concat( [
                            '<span><b>', this.points[i].y, '</b></span>',
                        ] );
                    }
                    tooltipHTML.push( '</div>' );
                }
                return tooltipHTML.join('');
            },
            // headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
            // footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            max: initYMax,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                formatter: function() {
                    var maxElement = this.axis.max;
                    if (maxElement > 1000) {
                        return (this.value / 1000) + " K";
                    }
                    else {
                        return this.value;
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 2
                }
            },
            column: {
                stacking: 'normal',
                pointWidth: 26,
                borderWidth: 0
            },
            line: {
                lineWidth: 1
            }
        },
        series: [{
            type: 'column',
            name: datasetNames[0],
            data: datasets[0],
            xAxis: 0
        }, {
            type: 'column',
            name: datasetNames[1],
            data: datasets[1],
            xAxis: 0
        }, {
            type: 'line',
            name: datasetNames[2],
            data: nets,
            xAxis: 0
        }]
    });
}

/*
 Twice Bar Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetNames: the name of bar, such as
            ['預算', '實際']
 datasets: property and debt, two dimension array, first subarray is property and last one is debt, such as
          [ [ 10, 20, 30, ... ], [ 8, 3, 5, ... ] ]
 xAxisNames: items, such as
            [ '飲食', '娛樂', '帳單', ... ]
 yAxisTitle: such as '(單位: 千元)'
 chartTitle: the name of chart, such as 'Cost Status'
 barMaxNum: how many bars are visible in chart, may use scroll, such as 12
 isMoney: true or false, format the itemValue to Money formation, example: 20000 -> 20,000.00.
          This need Plugin - accounting.min.js

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function twicebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitle, chartTitle, barMaxNum, isMoney ) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    for( var i in datasets) {
        var maxValue = Math.max.apply(Math, datasets[i]);
        if( maxValue > initYMax ) {
            initYMax = maxValue;
        }
    }

    var datasetMaxLength = 0;
    datasets[0].length > datasets[1].length ? datasetMaxLength = datasets[0].length : datasetMaxLength = datasets[1].length;
    /*
    var nets = [];
    for( var i=0 ; i < datasetMaxLength ; i++ ) {
        nets.push( datasets[0][i] + datasets[1][i]  );
    }
    */
    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == barMaxNum || datasetMaxLength < barMaxNum ) {
        barMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
        console.log(barMaxNum);
    }
    barMaxNum -= 1;

    var groupPaddings = [0.46, 0.418, 0.378, 0.334, 0.292];
    var thisGroupPadding = 0.46;
    if ( datasetMaxLength >= 5 )
    {
        thisGroupPadding = groupPaddings[4];
    }
    else
    {
        thisGroupPadding = groupPaddings[datasetMaxLength-1];
    }

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            animation:
            {
                easing: 'linear'
            },
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
            enabled: isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#3B3BFD'],
                  [0.4, '#0178FA'],
                  [0.6, '#0178FA'],
                  [1, '#3B3BFD']
                ]
            },
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#F50505'],
                  [0.4, '#FF4D4D'],
                  [0.6, '#FF4D4D'],
                  [1, '#F50505']
                ]
            }
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        min: 0,
                        max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            max: initYMax,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                formatter: function() {
                    var maxElement = this.axis.max;
                    if (maxElement > 1000) {
                        return (this.value / 1000.0) + " K";
                    }
                    else {
                        return this.value;
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            formatter: function() {
                var tooltipHTML = [
                    '<div>', this.x, '</div>'
                ];
                // tooltipHTML.concat( ['<div>', '1</div>'] );
                for (var i in this.points)
                {
                    tooltipHTML.push( '<div>' );
                    tooltipHTML.push( '<span>' +this.points[i].series.name+ ': </span>' );
                    if ( isMoney )
                    {
                        tooltipHTML = tooltipHTML.concat( [
                            '<span><b>', accounting.formatMoney(this.points[i].y).replace("$", ''), '</b></span>',
                        ] );
                    }
                    else
                    {
                        tooltipHTML = tooltipHTML.concat( [
                            '<span><b>', this.points[i].y, '</b></span>',
                        ] );
                    }
                    tooltipHTML.push( '</div>' );
                }
                return tooltipHTML.join('');
            },
            // headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            // pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
            // footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 2
                }
            },
            column: {
                pointWidth: 26,
                // 1:0.46, 2:0.418, 3:0.378, 4:0.334, 5:0.292
                groupPadding: thisGroupPadding,
                borderWidth: 0,
                pointPadding: 0
            },
            line: {
                lineWidth: 1
            }
        },
        series: [{
            type: 'column',
            name: datasetNames[0],
            data: datasets[0],
            //pointPlacement: -0.1
        }, {
            type: 'column',
            name: datasetNames[1],
            data: datasets[1],
            //pointPlacement: 0.1
        }]
    });
}

/*
 Deposit Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetName: the name of dataset, such as 'Deposit'
 dataset: such as [ 10, 20, 30, ... ]
 xAxisNames: dates, such as
            [ '1/13', '2/13', '3/13', ... ]
 yAxisTitle: such as '(單位: 千元)'
 chartTitle: the name of chart, such as '存款曲線'
 dateMaxNum: how many dates are visible in chart, may use scroll, such as 12
 isMoney: true or false, format the itemValue to Money formation, example: 20000 -> 20,000.00.
          This need Plugin - accounting.min.js

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function depositchart( chartDivId, datasetName, dataset, xAxisNames, yAxisTitle, chartTitle, dateMaxNum, isMoney ) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    initYMax = Math.max.apply(Math, dataset);

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };


    //Max bar numbers in view
    var datasetMaxLength = dataset.length;
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == dateMaxNum || datasetMaxLength < dateMaxNum ) {
        dateMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    dateMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
                enabled: isScrollable,
                //liveRedraw: false
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#3B3BFD'],
                  [0.4, '#0178FA'],
                  [0.6, '#0178FA'],
                  [1, '#3B3BFD']
                ]
            }
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: dateMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        min: 0,
                        //max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            max: initYMax,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 4
                }
            },
            line: {
                lineWidth: 2
            }
        },
        series: [{
            name: datasetName,
            data: dataset,
        }]
    });

}

/*
 Twice Line Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetNames: the name of dataset, such as
                ['Original', 'New']
 datasets: such as
           [[ 10, 20, 30, ... ], [0, 0, 5, ...]]
 xAxisNames: dates, such as
            [ '1/13', '2/13', '3/13', ... ]
 yAxisTitle: such as '(單位: 千元)'
 xAxisTitle: such as '(時間)'
 dateMaxNum: how many dates are visible in chart, may use scroll, such as 12

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function twicelinechart(chartDivId, datasetNames, datasets, xAxisNames, yAxisTitle, xAxisTitle, dateMaxNum) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    for( var i in datasets) {
        var maxValue = Math.max.apply(Math, datasets[i]);
        if( maxValue > initYMax ) {
            initYMax = maxValue;
        }
    }

    var yMin = Math.min.apply(null, datasets[0]);
    var yMin2 = Math.min.apply(null, datasets[1]);
    if (yMin > yMin2) {
      yMin = yMin2;
    }
    console.log(yMin);


    var datasetMaxLength = 0;
    datasets[0].length > datasets[1].length ? datasetMaxLength = datasets[0].length : datasetMaxLength = datasets[1].length;

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };


    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == dateMaxNum || datasetMaxLength < dateMaxNum ) {
        dateMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    dateMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: '',
            // verticalAlign: 'bottom',
            // y: titleShift
        },
        scrollbar:{
                enabled: isScrollable,
                //liveRedraw: false
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  // [0, '#397DC8'],
                  // [0.4, '#8797F5'],
                  // [0.6, '#8797F5'],
                  // [1, '#397DC8']
                  [0, '#666666'],
                  [0.4, '#333333'],
                  [0.6, '#333333'],
                  [1, '#666666']
                ]
            },
            {
                    linearGradient: BarGradient,
                    stops: [
                      [0, '#BE0200'],
                      [0.4, '#BF1210'],
                      [0.6, '#BF1210'],
                      [1, '#BE0200']
                    ]
            }
        ],
        xAxis: {
            // categories: xAxisNames,
            // min: 0,
            max: dateMaxNum,
            tickPosition: 'inside',
            tickmarkPlacement: 'on',
            tickInterval: 1,
            minPadding: 0,
            maxPadding: 0,
            startOnTick: true,
            endOnTick: true,
            title: {
                    text: xAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                enabled: true,
                formatter: function () {
                    return xAxisNames[this.value];
                }
            },
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        // min: 0,
                        //max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            min: yMin,
            max: initYMax,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
          enabled: false
        },
        legend: {
            enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 0,
                    states: {
                        hover: {
                            enabled: false
                        }
                    }
                },
                states: {
                    hover: {
                        enabled: false
                    }
                }
            },
            line: {
                lineWidth: 2
            }
        },
        series: [{
            type: 'spline',
            name: datasetNames[0],
            data: datasets[0],
            animation: {
                        duration: 3000
            }
        },{
            type: 'spline',
            name: datasetNames[1],
            data: datasets[1],
            animation: {
                        duration: 3000
            }
        }]
    });

}

/*
 Profit Chart

 [Dependencies]
 jquery.js
 highstock.js

 [Parameters]
 chartDivId: the target element id
 datasetNames: the name of bar, such as
            ['成本', '市值', '淨利']
 datasets: property and debt, two dimension array, first subarray is property and last one is debt, such as
          [ [ Group1_成本, Group2_成本, Group3_成本 ],
            [ Group1_市值, Group2_市值, Group3_市值 ],
            [ Group1_淨利, Group2_淨利, Group3_淨利 ] ]
 xAxisNames: items, such as
            [ 'Group1_Name', 'Group2_Name', 'Group3_Name' ]
 yAxisTitle: such as '(單位: 千元)'
 chartTitle: the name of chart, such as '獲利分析'
 barMaxNum: how many grouping bars are visible in chart, may use scroll, such as 3

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function profitchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitle, chartTitle, barMaxNum) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    for(var i in datasets) {
        var maxValue = Math.max.apply(Math, datasets[i]);
        if( maxValue > initYMax ) {
            initYMax = maxValue;
        }
    }

    for(var i in datasets) {
      if(datasets[i].length < 3) {
        var padNum = 3 - datasets[i].length;
        // console.log(padNum);
        for(var j=0; j < padNum; j++) {
          datasets[i].push(null);
        }
      }
    }

    if(xAxisNames.length < 3) {
      var padNum = 3 - xAxisNames.length;
      // console.log(padNum);
      for(var i=0; i < padNum; i++) {
        xAxisNames.push("");
      }
    }

    var datasetMaxLength = 0;
    datasets[0].length > datasets[1].length ? datasetMaxLength = datasets[0].length : datasetMaxLength = datasets[1].length;

    // var nets = [];
    // for( var i=0 ; i < datasetMaxLength ; i++ ) {
    //     nets.push( datasets[0][i] - datasets[1][i]  );
    // }

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == barMaxNum || datasetMaxLength < barMaxNum ) {
        //alert(dataset.length+'x'+barMaxNum);
        barMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    barMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
                enabled:isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#3B3BFD'],
                  [0.4, '#0178FA'],
                  [0.6, '#0178FA'],
                  [1, '#3B3BFD']
                ]
            },
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#1A8A52'],
                  [0.4, '#42B37A'],
                  [0.6, '#42B37A'],
                  [1, '#1A8A52']
                ]
            },
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#F50505'],
                  [0.4, '#FF4D4D'],
                  [0.6, '#FF4D4D'],
                  [1, '#F50505']
                ]
            }
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        max: yMax
                    });
                }
            }
        },
        yAxis: {
            lineWidth: 1,
            max: initYMax,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
          shared: true
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            margin: 60,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 2
                }
            },
            column: {
                pointPadding: 0,
                borderWidth: 0
            },
            line: {
                lineWidth: 1
            }
        },
        // series: seriesData
        series: [{
            type: 'column',
            name: datasetNames[0],
            data: datasets[0],
            // data: [1000,1000],
            xAxis: 0
        }, {
            type: 'column',
            name: datasetNames[1],
            data: datasets[1],
            // data: [1000,1000],
            xAxis: 0
        }, {
            type: 'column',
            name: datasetNames[2],
            data: datasets[2],
            // data: [1000,1000],
            xAxis: 0
        }]
    });

}

/*
 Weight Chart

 [Dependencies]
 jquery.js
 highstock.js

 [Parameters]
 chartDivId: the target element id
 datasetName: the name of dataset, such as 'Weight'
 dataset: such as [ 73, 71, 72, ... ]
 yAxisTitle: such as '體重(kg)'
 expectedTitle; such as '理想體重'
 expectedWeight: such as 65
 lastEndWeight: determine the end value of right yaxis, if set value -1, the line would stop at lastest date
 ## The starting date ##
 startDate: { year: 2014, month: 1, date: 20 }
 targetDate: { year: 2014, month: 3, date: 26 }

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function weightchart( chartDivId, datasetName, dataset, yAxisTitle, expectedTitle, expectedWeight, lastEndWeight, startDate, targetDate ) {

    /*
     Get the Highest value of yAxis
    */
    var initYMax = 0;
    initYMax = Math.max.apply(Math, dataset)+1;
    //alert(initYMax);

    /*
     Tranform the dataset & Create trend line dataset
    */
    var datasetInitialLength = dataset.length;
    var tempDataset = dataset;
    var averageWeight1 = 0;
    var averageWeight2 = 0;
    var arithmetical = 0;

    /*dataset = [];
    for( var i=0; i < tempDataset.length ; i++ ) {
        //dataset.push( { x: i ,y: tempDataset[i] } );
        dataset.push( tempDataset[i]  );
    }*/

    /*
     Padding the lastest value
    */
    //xAxisNames.push( ' ' );
    if( lastEndWeight >= 0 ) {
        dataset.push( lastEndWeight );
    }

    /*
     Trend line
    */
    /*
    var trendDataset = [];
    if( tempDataset.length > 4 ) {
        averageWeight1 = (tempDataset[tempDataset.length - 5] + tempDataset[tempDataset.length - 4]) / 2;
        averageWeight2 = (tempDataset[tempDataset.length - 3] + tempDataset[tempDataset.length - 2]) / 2;
        arithmetical = averageWeight1 - averageWeight2;
        trendDataset.push( { y: averageWeight1 } );
        trendDataset.push( { y: averageWeight1 - arithmetical*1 } );
        trendDataset.push( { y: averageWeight1 - arithmetical*2 } );
        var paddingTrendLineDates = dataset.length - tempDataset.length+6;
        for(var i = 1 ; i < paddingTrendLineDates ; i++ ){
            trendDataset.push( { y: averageWeight1 - arithmetical*(i+2) } );
        }
    }*/
    /*
    for( var i=0; i < tempDataset.length + 1 ; i++ ) {
        trendDataset.push( tempDataset[0] + (arithmetical * i) );

    }
    */

    /* Highcharts Settings */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };


    //Max bar numbers in view
    /*var datasetMaxLength = dataset.length;
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == dateMaxNum || datasetMaxLength < dateMaxNum ) {
        dateMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    dateMaxNum -= 1;
    */

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginRight: 100,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                    for ( var i in this.series )
                    {
                        if ( this.series[i].name == 'trend' )
                        {
                            if ( !this.series[i].data.length > 0 )
                            {
                                break;
                            }
                            var lastIndex = this.series[i].data.length - 1;
                            var diff = this.series[i].data[ lastIndex ].y - this.series[i].data[ lastIndex -1 ].y;
                            var lastDate = this.xAxis[0].max;
                            this.series[i].addPoint({ x: lastDate, y: this.series[i].data[ lastIndex ].y + diff });
                            break;
                        }
                    }
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: ''
        },
        scrollbar:{
                //enabled: isScrollable,
                //liveRedraw: false
        },
        colors: [
            '#397DC8',
            'green'
        ],
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%m / %d',
                week: '%m / %d',
                month:'%m / %d',
                year:'%m / %d'
            },
            //categories: xAxisNames,
            //max: dateMaxNum,
            //max: xAxisNames.length - 2,
            min: Date.UTC(startDate.year, startDate.month-1, startDate.date),
            max: Date.UTC(targetDate.year, targetDate.month-1, targetDate.date),
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        min: 0
                    });
                }
            },
            minPadding: 0,
            maxPadding: 0,
            startOnTick:true,
            endOnTick:true,
            gridLineColor: '#E3E3E3',
            gridLineWidth: 1,
            tickWidth: 3,
            tickPosition: 'inside',
            //tickmarkPlacement: 'on',
            /*labels: {
                //useHTML: true,
                align: 'right'
            }*/
        },
        yAxis: [{
            lineWidth: 1,
            title: {
                    text: yAxisTitle,
                    rotation: 0,
                    align: 'high'
            },
            max: initYMax,
            min: 0,
            tickWidth: 3,
            tickPosition: 'inside',
            gridLineColor: '#E3E3E3'
        },{
            lineWidth: 1,
            title: {
                text: ''
            },
            labels: {
                enabled: false
            },
            plotBands: [{ // mark the expected weight
                from: expectedWeight,
                to: expectedWeight,
                label: {
                    text: '<div style="position: absolute; left: -5px;" ><div style=" display: inline-block; border: 3px solid green; margin-right: 7px;"></div><font style="color: #CC0000;">'+ expectedWeight +'</font>&nbsp;&nbsp;'+ expectedTitle +'</div>',
                    //'<div class="ideaWeightPoint" style="display: inline-block; border: 3px solid green;"></div><div class="ideaWeightValue" style="display: inline-block;"><font style="color: #333;">'+ expectedWeight +'</font>&nbsp;&nbsp;'+ expectedTitle +'</div>',
                    useHTML: true,
                    align: 'right',
                    x: 0,
                    style: {
                        color: 'green',
                        fontWeight: 'bold'
                    }
                }
            }],
            opposite: true,
            max: initYMax,
            min: 0,
            tickWidth: 3,
            tickPosition: 'inside',
            gridLineWidth: 0
        }],
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                marker: {
                        enabled: false,
                        radius: 0
                },
                connectNulls: true
            },
            line:{
                pointPlacement: -0.5,
                lineWidth: 1
            },
            spline: {
                pointPlacement: -0.5,
                lineWidth: 2
            }
        },
        tooltip: {
            formatter: function() {
                if( this.series.name == 'trend' ) {
                    return false;
                }
                else {
                    var tday = new Date(this.x);
                    return tday.getFullYear() + ' / ' + ("0"+(tday.getMonth()+1)).slice(-2) + ' / ' + ("0"+(tday.getDate())).slice(-2) + '<br/>'+
                           this.series.name + ': ' + '<b>' + this.y + '<b> kg';
                }
            }
        },
        series: [{
            type: 'spline',
            name: datasetName,
            data: dataset,
            animation: {
                duration: 2000
            },
            yAxis: 0,
            zIndex: 2,
            pointStart: Date.UTC(startDate.year, startDate.month-1, startDate.date),
            pointInterval: 24 * 3600 * 1000 // one day
        },{
            type: 'line',
            dashStyle: 'dash',
            name: 'trend',
            //data: trendDataset,
            data: (function(){
                if ( dataset.length < 10 )
                {
                    return null;
                }
                var count_value = 0;
                var back_key_diff = 0;
                for ( var i=1 ; i <= dataset.length ; i++ )
                {
                    if ( dataset[ dataset.length - i ] != null )
                    {
                        count_value += 1;

                        if ( count_value <= 10 )
                        {
                            back_key_diff = dataset.length - i;
                        }
                    }
                }
                if ( count_value < 10 )
                {
                    return null;
                }

                var sdate = new Date(startDate.year, startDate.month, startDate.date);
                var edate = new Date(targetDate.year, targetDate.month, targetDate.date);
                var timeDiff = Math.abs(edate.getTime() - sdate.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                /*
                var temp = fitData(dataset).data;
                var trend = [];
                var diff = (temp[0][1] - temp[temp.length-1][1]) / (dataset.length - 1);

                for(var i=0; i < diffDays+3 ; i++) {
                    trend.push(temp[0][1] + diff*i);
                }
                */

                var tsum1 = 0;
                var avg1 = 0;
                var count1 = 1;
                var stop = 1;
                for ( var i=1 ; i <= dataset.length ; i++ )
                {
                    if ( dataset[ dataset.length - i ] != null )
                    {
                        tsum1 += dataset[ dataset.length - i ];
                        count1 += 1;
                        //console.log(dataset[ dataset.length - i ]);
                    }

                    if ( count1 <= 6 )
                    {
                        //console.log( count1 );
                        stop += 1;
                    }

                    if ( count1 == 6 )
                    {
                        break;
                    }
                }
                avg1 = tsum1 / 5.0;

                var tsum2 = 0;
                var avg2 = 0;
                var count2 = 1;
                for ( var i=stop ; i <= dataset.length ; i++ )
                {
                    if ( dataset[ dataset.length - i ] != null )
                    {
                        tsum2 += dataset[ dataset.length - i ];
                        count2 += 1;
                    }

                    if ( count2 == 6 )
                    {
                        break;
                    }
                }
                avg2 = tsum2 / 5.0;

                var diff = (avg1 - avg2) / 5.0;
                var diff_multi = 0;
                var trend = [];
                var start = back_key_diff;

                for(var i=0; i < diffDays+3 ; i++) {
                    if ( (i < start || dataset[i] == null) && i <= diffDays )
                    {
                        trend.push(null);
                    }
                    else
                    {
                        trend.push(dataset[start] + diff*diff_multi);
                        diff_multi += 1;
                    }
                    //console.log( trend[i] );
                }

                return trend;
            })(),
            animation: {
                duration: 2000
            },
            yAxis: 0,
            index: -1,
            //pointStart: Date.UTC(startDate.year, startDate.month-1, startDate.date) + (dataset.length - 5) * 24 * 3600 * 1000,
            pointStart: Date.UTC(startDate.year, startDate.month-1, startDate.date),
            pointInterval: 24 * 3600 * 1000 // one day
        }]
    });

}

/*
 Line Bar Chart

 [Dependencies]
 jquery.js
 highstock.js
 accounting.min.js

 [Parameters]
 chartDivId: the target element id
 datasetNames: the name of bar, such as
            ['資產', '負債', '淨值']
 datasets: property and debt, two dimension array, first subarray is property and last one is debt, such as
          [ [ 10, 20, 30, ... ], [ -5, -3, -6, ... ] ]
 itemNames: date, such as
            [ '1/01', '2/13', '5/08', ... ]
 yAxisTitles: such as ['Min', 'kcal']
 chartTitle: the name of chart, such as 'Cost Status'
 barMaxNum: how many grouping bars are visible in chart, may use scroll, such as 12
 rightTitleMargin: margin of right title

 [Coder]
 JHENG,JHIH-WUN
 Last motified: 2013/10/30
*/
function linebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitles, chartTitle, barMaxNum, rightTitleMargin ) {

    /*
     Get the Highest value of yAxis
    */
    var initY1Max = Math.max.apply(Math, datasets[0]);
    var initY2Max = Math.max.apply(Math, datasets[1]);

    var datasetMaxLength = 0;
    datasets[0].length > datasets[1].length ? datasetMaxLength = datasets[0].length : datasetMaxLength = datasets[1].length;

    /*
     Highcharts Settings
    */
    //Gradient color direction of bar
    var BarGradient = { x1: 0, y1: 0, x2: 1, y2: 0 };

    //Max bar numbers in view
    var isScrollable = true;
    var titleShift = -30;
    if( datasetMaxLength == barMaxNum || datasetMaxLength < barMaxNum ) {
        //alert(dataset.length+'x'+barMaxNum);
        barMaxNum = datasetMaxLength;
        isScrollable = false;
        titleShift = 0;
    }
    barMaxNum -= 1;

    var yMax = 0;
    chart = new Highcharts.Chart({
        chart: {
            renderTo: chartDivId,
            height: 300,
            //width: 640,
            marginTop: 20,
            marginBottom: 70,
            events: {
                load: function() {
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                },
                redraw: function() {
                    this.yAxis[0].removePlotLine('top-line-mask');
                    yMax = this.yAxis[0].max;
                    this.yAxis[0].addPlotLine({
                        id: 'top-line-mask',
                        color: 'white',
                        value: yMax,
                        width: 2,
                        zIndex: 2
                    });
                }
            }
        },
        title: {
            text: chartTitle,
            verticalAlign: 'bottom',
            y: titleShift
        },
        scrollbar:{
                enabled:isScrollable
        },
        colors: [
            {
                linearGradient: BarGradient,
                stops: [
                  [0, '#F57D05'],
                  [0.4, '#FFAC55'],
                  [0.6, '#FFAC55'],
                  [1, '#F57D05']
                ]
            },
            '#BE0200'
        ],
        xAxis: {
            categories: xAxisNames,
            min: 0,
            max: barMaxNum,
            events:{
                afterSetExtremes:function() {

                    var chart = this.chart;

                    chart.yAxis[0].update({
                        max: initY1Max
                    });
                    chart.yAxis[1].update({
                        max: initY2Max
                    });
                }
            }
        },
        yAxis: [{
            lineWidth: 1,
            max: initY1Max,
            title: {
                    text: yAxisTitles[0],
                    rotation: 0,
                    align: 'high'
            }
        },{
            lineWidth: 1,
            max: initY2Max,
            title: {
                    text: yAxisTitles[1],
                    rotation: 0,
                    align: 'high',
                    margin: rightTitleMargin
            },
            labels: {
                formatter: function() {
                    return '<font style="color: #BE0200;">' +
                        this.value +'</font>';
                }
            },
            opposite: true
        }],
        credits: {
            enabled: false
        },
        legend: {
            enabled: true,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            borderWidth: 1,
            //margin: 0,
            itemStyle: {
                "fontWeight" : "normal"
            },
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 2
                }
            },
            column: {
                stacking: 'normal',
                pointWidth: 26,
                borderWidth: 0
            },
            line: {
                lineWidth: 1
            }
        },
        series: [{
            type: 'column',
            name: datasetNames[0],
            data: datasets[0],
            yAxis: 0
        }, {
            type: 'spline',
            name: datasetNames[1],
            data: datasets[1],
            yAxis: 1
        }]
    });
}
