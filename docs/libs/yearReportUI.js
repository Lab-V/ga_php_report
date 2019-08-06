(function($){
    jQuery.fn.yearReportUI = function() 
    {
        var _container = this;
        var _chartData;
        var chart;
        var _chart = _container.find(".yearReportChart");
        
        var options = {
            bar: {groupWidth: "95%"},
            fontSize: 18,
            fontName: "Arial, Verdana, sans-serif",
            hAxis: {
                titleTextStyle: {
                    fontName: "Arial, Verdana, sans-serif",
                    fontSize: 18,
                    bold: false,
                    italic: false
                },
                textStyle: {
                    fontName: "Arial, Verdana, sans-serif",
                    fontSize: 18,
                    bold: false,
                    italic: false
                }
            },
            vAxis: {
                format: "decimal",
                titleTextStyle: {
                    fontName: "Arial, Verdana, sans-serif",
                    fontSize: 18,
                    bold: false,
                    italic: false
                },
                textStyle: {
                    fontName: "Arial, Verdana, sans-serif",
                    fontSize: 18,
                    bold: false,
                    italic: false
                }
            },
            legend: {
                textStyle: {
                    //color: "#0000FF",
                    fontName: "Arial, Verdana, sans-serif",
                    fontSize: 16,
                    bold: false,
                    italic: false
                }
            }
        };
        
        var drawChart = function() {
            chart.draw(_chartData, options);
        };
        
        var reportResult = function(event){
            var _jsonResponseObj = jQuery.parseJSON(event.target.responseText);
            
            // CHECK FOR RESPONSE STATUS
            var _status = _jsonResponseObj.status;
            
            // OVERRIDE LABEL
            _jsonResponseObj.data.cols[1].label = "Unique page views";
            
            _chartData = new google.visualization.DataTable(_jsonResponseObj.data);
            
            chart = new google.visualization.ColumnChart($(_chart)[0]);
            
            drawChart();
        };
        
        
        var resizeChart = function() {
            if (chart) {
                drawChart();
            }
        };
        
        var getReport = function(){
            event.stopPropagation();
            
            // SELECT REPORT BY DOMAIN KEY: DOMAIN_ONE, DOMAIN_TWO
            var domainKey = "YOUR_DOMAIN_KEY";

            var _requestData = new FormData();
            _requestData.append("domainKey", domainKey);

            var _getReport_XHR = new XMLHttpRequest();
            _getReport_XHR.addEventListener("load", reportResult, false);
            _getReport_XHR.open("POST", "YearReport.php", true);
            _getReport_XHR.send(_requestData);
        };
        
        return {
            getReport   :   getReport,
            resizeChart :   resizeChart
        };
    };
})(jQuery);
