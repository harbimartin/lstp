
<style>
    td.th{
        text-align: left;
        min-width:100px;
    }
</style>
<div style="max-width:720px; margin-left:auto; margin-right:auto;">
    Yang Terhormat,<br> <strong>{{ $name }}</strong>,
    <br>
    <p>{!! nl2br(e($intro)) !!}</p>
    @isset($table)
        <table style="margin-left:15%;">
            @foreach ($table as $key => $tab)
            <tr>
                <td class="th">{{$key}}</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$tab}}</td>
            </tr>
            @endforeach
        </table>
    @endisset
    <br>
    {{$close}}<br>
    @isset($link)
        <a href="{{$link}}">Klik disini untuk menuju Web E-Budgeting</a>
    @endisset
    <div style="text-align:right">
        @isset($pemohon)
        <br>
        Pemohon,
        <br> <strong>{{ $pemohon }}</strong>
        @endisset
        <br>
        @isset($admin)
        <br>
        Admin,
        <br> <strong>{{ $admin }}</strong>
        @endisset
        @isset($penyetuju)
        <br>
        Penyetuju,
        <br> <strong>{{ $penyetuju }}</strong>
        @endisset
    </div>
</div>
