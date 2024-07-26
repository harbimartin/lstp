@extends($parent)
@section($child)
    @isset(request()->id)
        <?php
            $column = json_encode([
                'name'=>[ 'name'=>"Receiver", 'type'=>'String', 'full'=>true],
                'receiver'=>[ 'name'=>"Email", 'type'=>'String', 'full'=>true],
                'title'=>[ 'name'=>"Title", 'type'=>'String', 'full'=>true],
                'error'=>[ 'name'=>"Error", 'type'=>'String', 'full'=>true],
                'view'=>[ 'name'=>"View", 'type'=>'String'],
                'status'=>[ 'name'=>"Status", 'type'=>'Boolean', 'val'=>['Gagal', 'Berhasil']],
                'created_at'=>[ 'name'=>"Created", 'type'=>'DateTime'],
                'updated_at'=>[ 'name'=>"Update", 'type'=>'DateTime']
            ]);
            // foreach(json_decode($data['body']) as $object){
            //     $arrays[] =  (array) $object;
            // }
        ?>
        <x-update
            unique="email"
            title="Email Detail"
            :column="$column"
            :data="$data"
            :detail="true"
        >
        <div class="ml-8 text-gray-600 font-semibold">Email Content :</div>
        <div class="mx-8 border rounded-xl mt-5 bg-white">
            <?php
                echo view($data->view, json_decode($data['body'],true));
            ?>
        </div>
    </x-update>
    @else
        <?php
            $column_table = json_encode([
                'id'=>[ 'name'=>"ID", 'type'=>'String', 'full'=>true],
                'created_at'=>[ 'name'=>"Date", 'type'=>'DateTime'],
                'receiver'=>[ 'name'=>"Receiver", 'type'=>'Multi', 'children'=>[
                    'name'=>[ 'name'=>"Receiver", 'type'=>'String'],
                    'receiver'=>[ 'name'=>"Email", 'type'=>'String', 'iclass'=>'border-b border-blue-500'],
                    'title'=>[ 'name'=>"Title", 'type'=>'String']
                ]],
                'error'=>[ 'name'=>"Error", 'type'=>'String'],
                'status'=>[ 'name'=>"Status", 'type'=>'Boolean', 'val'=>['Gagal', 'Berhasil']],
                'act'=>[ 'name'=>"Action", 'type'=>'Edit']
            ]);
            $filter = json_encode([
                [ 'name'=>"Error" , 'key'=>'view', 'type'=>'error', 'col'=>'red', 'count'=>$total['Error']],
                [ 'name'=>"User" , 'key'=>'view', 'type'=>'mails', 'col'=>'green', 'count'=>$total['User']],
                [ 'name'=>"SAP" , 'key'=>'view', 'type'=>'xmls', 'col'=>'blue', 'count'=>$total['SAP']]
            ]);
        ?>
        <x-table
            :column="$column_table"
            :datas="$data"
            :prop="$table"
            :filter="$filter"
        >
        </x-table>
    @endisset
@endsection
