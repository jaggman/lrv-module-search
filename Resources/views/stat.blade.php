@extends('search::layouts.master')

@section('content')
<table class="table" id="stat">
    <thead>
        <tr>
            <!--<th>Идентификатор поиска</th>-->
            <th>Начало поиска</th>
            <th>Первые результаты</th>
            <th>Время cURL</th>
            <th>Время загрузки результатов</th>
            <th>Всего запросов</th>
            <th>Объем переданных данных</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th colspan="2"><span id="bodylink">Показать/скрыть таблицу</span></th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody id="tbody"><?php
        $timef = [];
        $curltime = [];
        $usertime = [];
        $cnt = [];
        $size = [];
        ?>
        @foreach($stat as $sta)
        <tr>
            <!--<td>{{ $sta->search }}</td>-->
            <td>{{ $sta->start }}<?php $start[] = $sta->start; ?></td>
            <td>{{ $sta->timef }}<?php $timef[] = $sta->timef; ?></td>
            <td>{{ $sta->curltime }}<?php $curltime[] = $sta->curltime; ?></td>
            <td>{{ $sta->usertime }}<?php $usertime[] = $sta->usertime; ?></td>
            <td>{{ $sta->cnt }}<?php $cnt[] = $sta->cnt; ?></td>
            <td>{{ $sta->size }}<?php $size[] = $sta->size; ?></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><?php $count = count($timef); ?>
            <td><strong>Итого <?= $count ?> запросов.</strong></td>
            <td colspan="2"><?= min($start).' - '.max($start)?></td>
        </tr>
        <tr>
            <!--<th>Идентификатор поиска</th>-->
            <th>Начало поиска</th>
            <th>Первые результаты</th>
            <th>Время cURL</th>
            <th>Время загрузки результатов</th>
            <th>Всего запросов</th>
            <th>Объем переданных данных</th>
        </tr>
        <tr>
            <td><strong>Cреднее:</strong></td>
            <td><strong><?= round(array_sum($timef)/$count,2) ?></strong></td>
            <td><strong><?= round(array_sum($curltime)/$count,2) ?></strong></td>
            <td><strong><?= round(array_sum($usertime)/$count,2) ?></strong></td>
            <td><strong><?= round(array_sum($cnt)/$count,2) ?></strong></td>
            <td><strong><?= round(array_sum($size)/$count,2) ?></strong></td>
        </tr>
        <tr>
            <td><strong>MIN:</strong></td>
            <td><strong><?= round(min($timef),2) ?></strong></td>
            <td><strong><?= round(min($curltime),2) ?></strong></td>
            <td><strong><?= round(min($usertime),2) ?></strong></td>
            <td><strong><?= round(min($cnt),2) ?></strong></td>
            <td><strong><?= round(min($size),2) ?></strong></td>
        </tr>
        <tr>
            <td><strong>MAX:</strong></td>
            <td><strong><?= round(max($timef),2) ?></strong></td>
            <td><strong><?= round(max($curltime),2) ?></strong></td>
            <td><strong><?= round(max($usertime),2) ?></strong></td>
            <td><strong><?= round(max($cnt),2) ?></strong></td>
            <td><strong><?= round(max($size),2) ?></strong></td>
        </tr>
        <tr>
            <td><strong>Cуммарное:</strong></td>
            <td><strong><?= round(array_sum($timef),2) ?></strong></td>
            <td><strong><?= round(array_sum($curltime),2) ?></strong></td>
            <td><strong><?= round(array_sum($usertime),2) ?></strong></td>
            <td><strong><?= round(array_sum($cnt),2) ?></strong></td>
            <td><strong><?= round(array_sum($size),2) ?></strong></td>
        </tr>
    </tfoot>
</table>
@stop
@section('style')
<style type="text/css">
    #stat {
        width:inherit;
    }
    #bodylink {
        text-decoration: underline;
        cursor:pointer;
    }
    #tbody {
        display:none;
    }
</style>
@stop
@section('script')
<script type="text/javascript">
$(function () {
    var show = false;
    $('#bodylink').on('click', function(){
        if(show){
            show = false;
            $('#tbody').slideUp({
                duration: 1000,
                queue: false
            });
        }else{
            show = true;
            $('#tbody').slideDown({
                duration: 1000,
                queue: false
            });
        }
    });
});
</script>
@stop
