@extends('search::layouts.master')

@section('content')
<div id="container" style="height:200px;width:450px;"></div>
<?php /*<table class="table">
    @foreach($state as $sts)
    <tr>
        @foreach($sts as $st)
        <td>{{{ $st }}}</td>
        @endforeach
    </tr>
    @endforeach
</table> */ ?>
@stop

@section('scripts')
    @parent
<!-- Charts JS -->
  <script src="http://themes.tur8.ru/absadmin/vendor/plugins/highcharts/highcharts.js"></script>
  <!--<script src="http://themes.tur8.ru/absadmin/vendor/plugins/circles/circles.js"></script>-->

@stop
@section('script')
<script type="text/javascript">
$(function () {

    var count = 0;
    $.post(null,function(data){
        count = data;
    },'html');
    function getCount(series){
        var diff = 0;
        //var series = $('#container').series;
        
        $.post(null,function(data){
            var x = (new Date()).getTime(), // current time
            y =  data - count;
            //series.addPoint([x, y], true, true);
            $('#container').highcharts().series[0].addPoint([x, y], true, true);
            //console.log(series);
            count = data;
            setTimeout(function(){
                getCount(series);
            },3000);
        },'html').fail(function(){
            setTimeout(function(){
                getCount(series);
            },3000);
        });
    }
    $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        
        $('#container').highcharts({
            credits: false, //убрать линк на hightchars.com
            chart: {
                //type: 'spline',
                //animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function () {
                        /*this.series[0].data = (function () {
                            var data = [],
                                time = (new Date()).getTime(),
                                i;
                            for (i = -149; i <= 0; i += 1) {
                                data.push({
                                    x: time + i * 3000,
                                    y: 0
                                });
                            }
                            return data;
                        }());*/
                        getCount(this.series[0]);
                    }
                }
            },
            title: {
                text: 'Статистика сервера'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    //text: 'Value'
                    text: null
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    //color: '#808080'
                    color: 'lightgray'
                }]
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                        Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'cUrl запросы',
                data: (function () {
                    var data = [],
                        time = (new Date()).getTime(),
                        i;
                    for (i = -149; i <= 0; i += 1) {
                        data.push({
                            x: time + i * 3000,
                            y: 0
                        });
                    }
                    return data;
                }())
            }]
        });
    });
});
</script>
@stop
