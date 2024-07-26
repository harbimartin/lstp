@extends('index', ['on'=>'persetujuan'])
@section('content')
    <?php
        $column_table = json_encode([
            'id'=>[ 'name'=>"No", 'type'=>"Index"],
            'lphp_id'=>[ 'name'=>"LPHP ID", 'type'=>"String"],
            'job_order'=>[ 'name'=>"Job Order", 'type'=>"String"],
            'vendor'=>[ 'name'=>"Vendor", 'type'=>"String"],
            'status'=>[ 'name'=>"Approval Status", 'type'=>"String"],
            'kl3h'=>[ 'name'=>"Approval KL3H", 'type'=>"String"],
            'catatan'=>[ 'name'=>"Catatan Penanggung Jawab", 'type'=>"TextArea"],
            // 'action'=>[ 'name'=>"Action", "type"=>"Multi", "children"=>[
            'act'=>[ 'name'=>"Action", 'type' => 'Edit', 'switch'=>['status', 'Draft', true], 'then'=>['Edit','View'], 'align'=>'center', 'sort'=>false],
            // ]],
        ]);
    ?>
    <x-table
        :datef="true"
        :column="$column_table"
        :datas="$data"
        :lim="false"
    >
    </x-table>
@endsection
