// REV. 20190806

var _rootDocumentObj;
var _windowObj;
var _delay = -1;
var _controlUI, _getStatBtn, _yearReportUI;

var performYearReport = function() {
    _controlUI = _rootDocumentObj.find(".controlUI");
    $(_controlUI).css("display", "block");

    _getStatBtn = _rootDocumentObj.find(".getStatBtn");

    _yearReportUI = _rootDocumentObj.find(".yearReportUI").yearReportUI(103);

    _getStatBtn.on("click", function(event){
        event.stopPropagation();

        _yearReportUI.getReport();

        // HIDE BUTTON
        $(this).off("click");
        $(_controlUI).css("display", "none");
    });
};

$(document).ready( function() 
{
    _rootDocumentObj = $(this);

    _windowObj = $(window);

    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(performYearReport);

    _windowObj.on("resize", function(event)
    {
        event.stopPropagation();
        clearTimeout(_delay);

        _delay = setTimeout(function()
        {
            if (_yearReportUI) {
                _yearReportUI.resizeChart();
            }
         }, 500);
    });
});
