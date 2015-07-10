@extends('search::layouts.master')

@section('content')
<div class="row">
    <div id="container1" style="height:200px;width:450px;"></div>
    <div id="container2" style="height:200px;width:450px;"></div>
    <div id="container3" style="height:200px;width:450px;"></div>
</div>
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
var graf;
var data1=[],
    data2=[],
    data3=[];
var chart1;
var chart2;
var chart3;
var pop;
$(function () {
    $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        function addPoint(pop){
            $.post(
                null,
                {"pop":pop},
                function(data){
                    pop = data['pop'];
                    
                    graf = data['state'];
                    (function(){
                        $(graf).each(function(k,val){
                            var x = (new Date(val['time_s'])).getTime();
                            var y1 = val['cnt'];
                            var y2 = val['time'];
                            var y3 = parseFloat(val['size']);
                            if(val['action'] == 'state'){
                                $('#container1').highcharts().series[0].addPoint([x, y1], true, true);
                                $('#container2').highcharts().series[0].addPoint([x, y2], true, true);
                                $('#container3').highcharts().series[0].addPoint([x, y3], true, true);
                            }
                            if(val['action'] == 'result'){
                                $('#container1').highcharts().series[1].addPoint([x, y1], true, true);
                                $('#container2').highcharts().series[1].addPoint([x, y2], true, true);
                                $('#container3').highcharts().series[1].addPoint([x, y3], true, true);
                            }
                        });
                        //console.log(chart1);
                    }());
                },
                'json'
            ).always(function(){
                setTimeout(function(){
                    addPoint(pop);
                },1000);
            });
        };
        function chart(container, name, data){
            var series;
            return $(container).highcharts({
                credits: false, //убрать линк на hightchars.com
                chart: {
                    marginRight: 10,
                    events: {
                        load: function () {
                        }
                    }
                },
                title: {
                    text: name
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
                },
                yAxis: {
                    title: {
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
                series: [
                    {
                        name: 'State',
                        data: data
                    },
                    {
                        name: 'Result',
                        data: data
                    }
                ]
            });
        }
        var dataline = (function () {
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
        }());
        (function(){
            chart('#container1','cUrl запросы',dataline);
            chart('#container2','суммарное время запросов',dataline);
            chart('#container3','объем данных (kB)',dataline);
            addPoint();
        }());
    });
});
</script>
@stop
