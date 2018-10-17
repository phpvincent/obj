<style type="text/css">
    table {
        border-collapse: collapse!important;

    }

    td {
        word-break: break-word!important;
        min-width: 130px!important;
    }
</style>
<table  class="table table-border table-bordered table-bg" >
    <thead >
    <tr  style="border-top: 1px solid #fff">
        <th style="background-color: #fff;border:1px solid #fff" scope="col">花费金额使用情况</th>
    </tr>
    <tr class="text-c">
        <th>花费日期</th>
        @foreach($time as $item)
            <th>{{$item}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr class="text-c">
        <td>花费金额</td>
        @foreach($data['pay'] as $val)
            <td>{{$val}}</td>
        @endforeach
    </tr>
    </tbody>
</table>
<div id="charthigh"></div>