@extends('pages.monitor')

@section('md_content')
    <?php
        $column_table = json_encode([
            'budget_code'=>[ 'name'=>"No. MRA", "type"=>"Multi", "children"=>[
                'budget_date'=>[ 'name'=>"Date", 'type'=>"Date"],
                'budget_code'=>[ 'name'=>"Code", 'type'=>"String"],
                'budget_status'=>['name'=>'Status', 'type'=>'State', 'align'=>'left'],
                'waiting'=>['name'=>'Waiting', 'type'=>'Slot']
            ]],
            'status'=>[ 'name'=>"No. PR/Status", "type"=>"Multi", "children"=>[
                'banfn'=>[ 'type'=>"String"],
                'pr_type'=>[ 'type'=>"String"],
                'result'=>[ 'type'=>"String"],
            ]],
            'budget_versions'=>[ 'name'=>"Type/<br>Version", "type"=>"Multi", "children"=>[
                'doc_types'=>[ 'name'=>"Document Type", 'type'=>"SString", 'child'=>'doc_type_desc', 'iclass'=>'font-medium text-gray-700'],
                'budget_versions'=>[ 'name'=>"Budget Version", 'type'=>'SString', 'child'=>'budget_version_code'],
            ]],
            'divnote'=>[ 'name'=>"Text Header", "type"=>"Multi", "children"=>[
                'divisions'=>[ 'name'=>"Divisi", 'type'=>'SString', 'child'=>'NAME', 'wrap'=>true, 'iclass'=>'font-medium text-gray-700 border-b border-blue-500'],
                'note_header'=>[ 'name'=>"Text Header", 'type'=>'String', 'wrap'=>true]
            ]],
            'total_proposed'=>['name'=>'Total Proposed', 'type'=>'Money', 'align'=>'center', 'sort'=>'none'],
            'total_verified'=>['name'=>'Total Verified', 'type'=>'Money', 'align'=>'center', 'sort'=>'none'],
            'send'=>[ 'name'=>"Send to SAP", 'type' => 'Post', 'header'=> 'persetujuan', 'then'=>['Send'], 'for'=>'send', 'align'=>'center', 'sort'=>false]
        ]);
    ?>
    <x-table
        :datef="true"
        title="Budget Approve yang belum terbentuk PR"
        :column="$column_table"
        :datas="$data"
        sign="ba"
        :lim="false"
    >
    </x-table>
@endsection
