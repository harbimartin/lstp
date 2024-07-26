@extends('index', ['on'=>'dpt'])
@section('content')
    <div class="absolute my-2 mx-6">
        <a
        class="inline-flex rounded-3xl border px-3 bg-gray-500 hover:bg-blue-400 transition mr-5 cursor-pointer text-white md:text-base"
        type="button"
        href="{{url('dpt')}}">
            <svg class="my-auto mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"/>
            </svg>
        <span class="my-2 font-semibold"> Kembali</span>
        </a>
    </div>
    <div class="h-12"></div>
    <?php
        $column = json_encode([
            'job_order' => ['name'=>'Job Order', 'type'=>'Info'],
            'date' => ['name'=>'Tgl JO / Kontrak', 'type'=>'Info'],
            'vendors'=>['name'=>'Vendor', 'type'=>'Infos', 'child'=>'name'],
            'email'=>['by'=>'vendors', 'name'=>'Email Notifikasi', 'type'=>'Infos', 'child'=>'email'],
            'safety'=>['name'=>'No Safety Work Permit', 'type'=>'Info', 'val'=>'-'],
            'file'=>['name'=>'Bukti Pekerjaan', 'key'=>'lstp', 'folder'=>'lstp', 'type'=>'Upload', 'full'=>true],
        ]);
    ?>
    <x-update
        unique="draft"
        idk="hid"
        title="LSTP"
        :column="$column"
        :data="$header"
        burl="none"
        :detail="true"
    >
        <?php
            $column_table = json_encode([
                'no'=>[ 'name'=>"Header No", 'type'=>"Number", 'align'=>'center'],
                'name'=>[ 'name'=>"Short Text", 'type'=>"TextArea"],
                'due_date'=>['by'=>'due_date', 'name'=>"Due Date", 'type'=>"Date"],
                'realisasi'=>[ 'name'=>"Nilai Realisasi", 'type'=>"Money"],
                'limit'=>[ 'name'=>"Limit", 'type'=>"Money"],
                'overlimit'=>[ 'name'=>"Over Limit", 'type'=>"Status"],
            ]);
        ?>
        <x-table
            :datef="true"
            :column="$column_table"
            :datas="$header['items']"
            :tool="false"
        >
        </x-table>
        <?php
            $service = array();
            foreach($header['items'] as $item){
                foreach($item['service'] as $serv){
                    $serv['item_no'] = $item['no'];
                    array_push($service, $serv);
                }
            }
            $column_table = json_encode([
                'item_no'=>[ 'name'=>"Header No", 'type'=>"Number", 'align'=>'center'],
                'due_date'=>[ 'name'=>"Due Date", 'type'=>"Date"],
                'no'=>[ 'name'=>"No", 'type'=>"Number", 'align'=>'center'],
                'short_text'=>[ 'name'=>"Deskripsi", 'type'=>"TextArea"],
                'qty_jo'=>[ 'name'=>"Qty JO", 'type'=>"Number", 'align'=>'center', 'decimal'=>2],
                'aktual'=>[ 'name'=>"Harga Aktual", 'type'=>"String"],
                'qty_aktual'=>[ 'name'=>"Qty Aktual", 'type'=>"Number", 'align'=>'center', 'decimal'=>2],
                'real_date'=>[ 'name'=>"Tgl Realisasi", 'type'=>"Date"],
            ]);
        ?>
        <x-table
            :datef="true"
            :column="$column_table"
            :datas="$service"
            :tool="false"
        >
        </x-table>
        @if($header['status'] == 'Prepared')
            <a href="{{url('/draft').'/propose?id='.$header['id']}}"
                class="float-right rounded border px-4 py-2 bg-indigo-500 hover:bg-indigo-600 mr-1 md:mr-2 cursor-pointer text-white font-semibold"
            >
                Propose
            </a>
        @endif
    </x-update>

    <?php
        $column_desc = json_encode([
            'nilai'=>[ 'name'=>"Nilai SLTP", 'type'=>"Info", 'format'=>'Money', 'full'=>true],
            'catatan'=>[ 'name'=>"Catatan Pengawas", 'type'=>"TextArea", 'full'=>true, 'row'=>2],
            'persentase'=>[ 'name'=>"Presentase Pembayaran", 'type'=>"Number", 'step'=>'0.1'],
            'tenorretensi'=>[ 'name'=>"Tenor / Retensi", 'type'=>'Boolean', 'val'=>['No', 'Yes']],
            'info'=>[ 'name'=>"Informasi Tambahan", 'type'=>"TextArea", 'full'=>true, 'row'=>2],
            'score'=>[ 'name'=>"Score Vendor", 'type'=>"EmotionScore"],
            'note_score'=>[ 'name'=>"Note Score Vendor", 'type'=>"TextArea", 'row'=>2],
        ]);
    ?>
    <x-update
        unique="desc"
        idk="hid"
        title="Deskripsi LSTP"
        :column="$column_desc"
        :data="$header"
        :error="$error"
        {{-- :select="$select" --}}
        burl="none"
        :detail="true"
    >
    </x-update>
@endsection
