@extends('index', ['on'=>'draft'])
@section('content')
    <?php
        $column_table = json_encode([
            'id'=>[ 'name'=>"No", 'type'=>"String"],
            'code'=>[ 'name'=>"Job Order", 'type'=>"Multi", 'children'=>[
                'code'=>[ 'name'=>"LPHP ID", 'type'=>"String"],
                'item'=>['type'=>"Slot"]
            ]],
            'job_order'=>[ 'name'=>"Job Order", 'type'=>"String"],
            'vendor'=>[ 'name'=>"Vendor", 'type'=>"Multi", 'children'=>[
                'vendors'=>['type'=>"SString", 'child'=>'name'],
                'vendor'=>['type'=>"Slot"]
            ]],
            'status'=>[ 'name'=>"Approval Status", 'type'=>"String"],
            'k3lh'=>[ 'name'=>"Approval KL3H", 'type'=>"String"],
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
        :prop="$table"
    >
    </x-table>
@endsection
