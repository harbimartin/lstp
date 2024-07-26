<?php
    $column['seq_no'] = [ 'name'=>'Item<br>No.', 'align'=>'center', 'type'=>'Number'];
    $column['short_text'] = [ 'name'=>'Description Barang / Jasa' ];
    $column['delivery_date_exp'] = [ 'name'=>'Deliv. Date', 'align'=>'center', 'type'=>'Date'];
    $column['purchase_groups'] = [ 'name'=>'PGr.', 'align'=>'center', 'type'=>'SString', 'child'=>'purchase_group'];
    $column['qty_proposed'] = [ 'name'=>'Qty', 'align'=>'center', 'type'=>'Float'];
    $column['uom'] = [ 'name'=>'UoM', 'align'=>'center', 'type'=>'SString', 'child'=>'unit_measurement'];
    $column['currencies'] = [ 'name'=>'Cur', 'align'=>'center', 'type'=>'SString', 'child'=>'currency'];
    $column['tprice_proposed'] = [ 'name'=>'Price'.($isVerify ? '<br>Proposed':''), 'align'=>'right', 'type'=>'Float', 'bolder'=>$isVerify];
    if ($isVerify)
        $column['tprice_verified'] = [ 'name'=>'Price<br>Verified', 'align'=>'right', 'type'=>'Float', 'bolder'=>true];
    // $column['price_unit'] = [ 'name'=>'Unit<br>Price', 'align'=>'center', 'type'=>'Number'];
    $column['total_proposed'] = [ 'name'=>'Amount'.($isVerify ? '<br>Proposed':''), 'align'=>'center', 'type'=>'Float','bolder'=> $isVerify];
    if ($isVerify)
        $column['total_verified'] = [ 'name'=>'Amount<br>Verified', 'align'=>'center', 'type'=>'Float','bolder'=>true];
    $column['gl_accounts'] = [ 'name'=>'G/L. Account'];
    $column['cost_centers'] = [ 'name'=>'Cost Center'];
    $column['internal_orders'] = [ 'name'=>'IO / WO'];
    if ($dataBudget->budget_status == 'Verification - Proposed'){
        $column['revised'] = [ 'name'=>'Revised'];
    }
?>
<div class="flex flex-col mt-6">
    <div class="-my-2 overflow-x-auto -mx-3">
    <div class="py-2 align-middle inline-block min-w-full lg:px-1">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                <thead class="bg-gray-50 md:tracking-wider">
                <tr>
                    @foreach ($column as $key => $param)
                        <th class="px-2 py-3 text-gray-500 uppercase {{ isset($param['align']) ? "text-".$param['align'] : ''}} {{ isset($param['class']) ? $param['class'] : ''}} {{ isset($param['bolder']) ? 'font-semibold' : 'font-medium'}}">
                            {!! $param['name'] !!}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-xs md:text-sm text-gray-900">
                    @foreach ($dataBudget->items as $item)
                        <tr>
                            @foreach ($column as $key => $param)
                                <td class="px-2 pt-4 whitespace-nowrap {{ isset($param['align']) ? "text-".$param['align'] : ''}} {{isset($param['class']) ? $param['class'] : ''}} {{isset($param['bolder']) ? 'font-semibold' : ''}}">
                                    @isset($param['type'])
                                        @switch($param['type'])
                                            @case('Number')@case('String')
                                                    <div>{{ $item[$key] }}</div>
                                                @break
                                            @case('Float')
                                                    <div>{{ number_format($item[$key],2,',','.')}}</div>
                                                @break
                                            @case('SString')
                                                    <div>{{$item[$key][$param['child']]}}</div>
                                                @break
                                            @case('Date')
                                                    <div>{{date('j M Y', strtotime($item[$key]))}}</div>
                                                @break
                                            @case('State')
                                                <div class="flex">
                                                    @if($item[$key]=='AKTIF')
                                                        <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            {{$item[$key]}}
                                                        </div>
                                                    @else
                                                        <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            {{$item[$key]}}
                                                        </div>
                                                    @endif
                                                </div>
                                                @break
                                            @case('Edit')
                                                    <a href="{{Request::url().'?id='.$item['id']}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                @break
                                            @case('Direct')
                                                    <a href="{{$param->url.'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                @break
                                            @default
                                                    <div class="text-gray-900">{{$item[$key]}}</div>
                                                    <small>{{$param['type']}}</small>
                                                @break
                                        @endswitch
                                    @else
                                        @switch($key)
                                            @case('short_text')
                                                @isset($item["short_text"])
                                                    <div>{{ $item[$key] }}</div>
                                                @endisset
                                                @break
                                            @case('gl_accounts')
                                                @isset($item["gl_accounts"])
                                                <div>{{$item["gl_accounts"]['gl_account']}}</div>
                                                <div class="text-xs text-gray-900">
                                                    {{$item["gl_accounts"]["gl_account_desc"]}}
                                                </div>
                                                @endisset
                                                @break
                                            @case('cost_centers')
                                                @isset($item["cost_centers"])
                                                    <div>{{$item["cost_centers"]['cost_center']}}</div>
                                                    <div class="text-xs text-gray-900">
                                                        {{$item["cost_centers"]['cost_center_desc']}}
                                                    </div>
                                                @endisset
                                                @break
                                            @case('internal_orders')
                                                @isset($item["internal_orders"])
                                                    <div>{{$item["internal_orders"]['io_code']}}</div>
                                                    {{-- <div class="text-xs text-gray-900">
                                                        {{$item["assign"]['cc']['division']}}
                                                    </div> --}}
                                                @endisset
                                                @break
                                            @case('revised')
                                            <div class="inline-flex">
                                                <a href="{{url('persetujuan').'?id='.$dataBudget->id.'&iid='.$item['id']}}" class="rounded-md bg-yellow-600 hover:bg-yellow-700 ml-2 p-1.5 my-auto cursor-pointer"><img src="assets/edit.svg"></a>
                                            </div>
                                            @break
                                            @default
                                            SLOT[{{$key}}]
                                        @endswitch
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @foreach ($item['service'] as $serv)
                            <tr style="border-top-width: 0px;">
                                @foreach ($column as $key => $param)
                                    <td class="px-2 whitespace-nowrap text-xs text-gray-500 {{$loop->parent->last?'pb-4 ':''}} {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
                                        @isset($serv[$key])
                                            @isset($param['type'])
                                                @switch($param['type'])
                                                    @case('String')
                                                            <div>{{ $serv[$key] }}</div>
                                                        @break
                                                    @case('Float')
                                                            <div>{{ number_format($serv[$key],2,',','.')}}</div>
                                                        @break
                                                    @case('SString')
                                                            <div>{{$serv[$key][$param['child']]}}</div>
                                                        @break
                                                    @case('Date')
                                                            <div>{{date('j M Y', strtotime($serv[$key]))}}</div>
                                                        @break
                                                    @case('State')
                                                        <div class="flex">
                                                            @if($serv[$key]=='AKTIF')
                                                                <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{$serv[$key]}}
                                                                </div>
                                                            @else
                                                                <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    {{$serv[$key]}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @break
                                                    @case('Edit')
                                                            <a href="{{Request::url().'?id='.$serv['id']}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                        @break
                                                    @case('Direct')
                                                            <a href="{{$param['url'].'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                        @break
                                                    {{-- @default
                                                            <div class="text-red-500">{{$serv[$key]}}</div>
                                                            <small>{{$param['type']}}</small>
                                                        @break --}}
                                                @endswitch
                                            @endisset
                                        @endisset
                                        @switch($key)   {{-- $item[$key] --}}
                                            @case('short_text')
                                                @isset($serv["short_text"])
                                                    <div>[{{$serv['seq_no']}}] {{ $serv[$key] }}</div>
                                                @endisset
                                                @break
                                            @case('gl_accounts')
                                                @isset($serv["gl_accounts"])
                                                    <div>{{$serv["gl_accounts"]['gl_account']}}</div>
                                                    <div class="text-xs text-gray-900">
                                                        {{$serv["gl_accounts"]["gl_account_desc"]}}
                                                    </div>
                                                @endisset
                                                @break
                                            @case('cost_centers')
                                                @isset($serv["cost_centers"])
                                                    <div>{{$serv["cost_centers"]['cost_center']}}</div>
                                                    <div class="text-xs text-gray-900">
                                                        {{$serv["cost_centers"]['cost_center_desc']}}
                                                    </div>
                                                @endisset
                                                @break
                                            @case('internal_orders')
                                                @isset($serv["internal_orders"])
                                                    <div>{{$serv["internal_orders"]['io_code']}}</div>
                                                @endisset
                                                @break
                                            @default
                                        @endswitch
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                    <th colspan="{{$isVerify ? 9:8}}" class="text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
                        Total
                    </th>
                    <th class="py-3 px-2 text-xs font-medium text-gray-900 text-center">
                        {{ number_format($dataBudget->total_proposed,2,',','.')}}
                    </th>
                    @if($isVerify)
                        <th class="py-3 px-2 text-xs font-medium text-gray-900 text-center">
                            {{ number_format($dataBudget->total_verified,2,',','.')}}
                        </th>
                    @endif
                    {{-- @foreach ($column as $key => $param)
                        <th class="px-2 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider {{ isset($param['align']) ? "text-".$param['align'] : ''}}">
                            {!! $param['name'] !!}
                        </th>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<div class="mt-6 ml-2 md:ml-6 md:w-1/3">
    <span class="text-gray-500 font-semibold text-sm md:text-base">Keterangan :</span><br>
    <div class="text-xs md:text-sm text-gray-800">{{$dataBudget->note_header}}</div>
</div>
<div class="mt-6 md:w-1/3 text-xs md:text-sm ml-2 md:ml-10">
    @foreach ($dataBudget->items as $item)
        <div class="md:ml-10 inline-flex text-gray-600">
            <span class="mr-1 font-semibold">{{$item['seq_no']}}.</span>
            <div class="mr-2">Specification&nbsp;:&nbsp;</div>
            <div class="text-gray-800">
                @if($item['note_item'] || $item['material_po_text'])
                    @if($item['note_item'])
                        <div>{{$item['note_item']}}</div>
                    @endif
                    @if($item['material_po_text'])
                        <div>{{$item['material_po_text']}}</div>
                    @endif
                @else
                    <div> </div>
                @endif
            </div>
        </div><br>
    @endforeach
</div>
