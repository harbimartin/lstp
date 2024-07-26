<div class="md:px-6">
    <?php
        $query = $_GET;
        $id = request()->{$idk};
        unset($query[$idk]);
        $back_query = (isset($burl) ? url('/').$burl : request()->url()).($query ? '?'.http_build_query($query):'');

        $columns = json_decode($column);
        foreach($columns as $k => $v){
            if (!isset($v->by))
                $v->by = $k;
            if (isset($v->if)){
                $final = true;
                for($i = 0; $i < sizeof($v->if); $i+=3){
                    if (($datas[$v->if[$i]] == $v->if[$i+1]) != $v->if[$i+2]){
                        $final = false;
                        break;
                    }
                }
                if (!$final){
                    $v->class="hidden";
                }else{
                    $v->class='';
                }
            }
        }
    ?>
    @if($burl != 'none')
        <a
        class="text-xs md:text-base inline-flex rounded-full md:rounded border px-3 my-2 md:my-4 bg-gray-500 hover:bg-gray-600 mr-5 cursor-pointer text-white"
        type="button"
        href="{{$back_query}}">
            <svg class="my-auto mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-7.08z"/>
            </svg>
        <span class="my-2 font-semibold"> Kembali</span>
        </a>
    @endif
    <form class="container md:rounded-lg shadow my-1 md:my-4 py-2 md:py-4 px-3 md:px-6 bg-white text-xs md:text-base" action="{{(isset($url) ? url('/').$url : request()->url()).'/'.$id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input hidden name="_last_" value="{{request()->fullUrl()}}">
        @isset($url)
        @else
            <input hidden name="_next" value="{{$back_query}}">
        @endisset
        @switch($title)
            @case('LSTP')
                <h1 class="border-b text-lg md:text-2xl pb-2 border-gray-200 mb-2">No. LSTP : {{$datas['code']}} ({{$datas['status']}})</h1>
            @break
            @default
            <h1 class="border-b text-lg md:text-2xl pb-2 border-gray-200 mb-2">{{$detail ? '':'Update :'}} {{$title}}</h1>
        @endswitch
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 md:gap-4 md:p-5">
            @if($error)
                <div class="col-span-2">
                    <div class="rounded-md bg-red-100 text-red-800 flex p-3">
                        <div>
                        </div>
                        <div class="inline-flex mb-auto">
                            <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <div class="ml-2">Error Message : </div>
                        </div>
                        <div class="ml-2">{{$error['msg']}}</div>
                    </div>
                </div>
            @endif
            @foreach ($columns as $key => $param)
                <div @isset($param->if)if="{{json_encode($param->if)}}"@endisset class="grid @isset($param->class){{$param->class}}@endisset {{ isset($param->full) ? 'grid-cols-6 col-span-2':'grid-cols-3'}}">
                    @isset($param->name)
                        <label for="{{$key}}" class="my-1 md:mb-0 col-span-6 md:col-span-1">{{$param->name}}
                            {{-- ({{$key}}) --}}
                        </label>
                    @endisset
                    @switch($param->type)
                        @case('Info')@case('Infos')
                            <div class="col-end-7 col-start-1 md:col-start-2 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                <span class="hidden md:inline">:</span>
                                <span class="border pl-1 rounded-md flex md:border-0 md:p-0 md:inline md:ml-2">
                                    <?php
                                        if ($param->type == 'Info')
                                            $value = isset($param->val) ? $param->val : $datas[isset($param->by)?$param->by : $key];
                                        else
                                            $value = isset($param->val) ? $param->val : $datas[isset($param->by)?$param->by : $key][$param->child];
                                    ?>
                                    @isset($param->format)
                                        @switch($param->format)
                                            @case('Money')
                                                {{"Rp " . number_format($value,2,',','.')}}
                                            @break
                                        @endswitch
                                    @else
                                        {{$value}}
                                    @endif
                                </span>
                            </div>
                        @break
                        @case('Reference')
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value-from="{{$param->key}}"
                                based="{{$param->val}}"
                                @isset($param->def)
                                    value="{{$param->def}}"
                                @endisset
                                type="text"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('RefArea')
                            <textarea
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value-from="{{$param->key}}"
                                based="{{$param->val}}"
                                type="text"
                                rows="{{$param->row ?? 4}}"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            >@isset($param->def){{$param->def}}@endisset</textarea>
                        @break
                        @case('Static')
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                type="text"
                                value="{{$param->def}}"
                            />
                        @break
                        @case('String')
                            <div class="col-end-7 col-start-1 md:col-start-2 relative block p-0">
                                <input
                                    @if($detail)readonly @endif
                                    id="{{$key}}"
                                    @isset($param->max)
                                        maxlength="{{$param->max}}"
                                        v-on:input="refMax($event,'{{$key}}_v_',{{$param->max}})"
                                    @endisset
                                    name="{{$key}}"
                                    value="{{$datas[$param->by]}}"
                                    type="text"
                                    class="w-full h-full rounded border px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition @isset($param->iclass){{$param->iclass}}@endisset"/>
                                @isset($param->max)
                                    <div id="{{$key}}_v_" class="pointer-events-none absolute top-1 right-2 h-full">
                                        <span>{{strlen($datas[$param->by])}}</span>/{{$param->max}}
                                    </div>
                                @endisset
                            </div>
                        @break
                        @case('SString')
                            <?php
                                $blank = isset($param->noblank) ? '':'(Blank)';
                                $txt = '';
                                $by = isset($param->by) ? $param->by : $key;
                                if ($datas[$by])
                                    foreach($param->child as $on => $child){
                                        $str = $datas[$by][$child];
                                        if ($on == 0)
                                            $txt = ($str=='' ? $blank:$str);
                                        else
                                            $txt = $txt.' - '.$str;
                                    }
                            ?>
                            <input
                                readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$txt}}"
                                type="text"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition @isset($param->iclass){{$param->iclass}}@endisset"/>
                        @break
                        @case('Number')
                            <input
                                @isset($param->count)
                                    v-on:input="onCount($event, '{{$param->count}}')"
                                @endisset
                                @isset($param->lock)
                                    disabled
                                @endisset
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{$datas[$param->by]}}"
                                @isset($param->float)
                                    step="{{$param->float}}"
                                @else
                                    step="0.1"
                                @endisset
                                placeholder="0"
                                @if($detail && !(isset($param->force) && $param->force))readonly @endif
                                type="number"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('Boolean')
                        <select
                            id="{{$key}}"
                            name="{{$key}}"
                            type="number"
                            @if($detail)disabled @endif
                            class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                            >
                                @foreach ($param->val as $ikey=>$item)
                                    <option value={{$ikey}} {{$datas[$param->by] == $ikey ? 'selected': ''}}>
                                        {{$item}}
                                    </option>
                                @endforeach
                        </select>
                        @break
                        @case('Select')
                        {{-- {{$select[$param->api]}} --}}
                            <select
                                id="{{$key}}"
                                name="{{$key}}"
                                type="number"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                                >
                                @isset($param->null)
                                    <option selected value="" class="text-gray-400">(Blank)</option>
                                @endisset
                                @foreach ($select[$param->api] as $item)
                                    <option value={{$item['id']}} {{$datas[$param->by]==$item['id'] ? 'selected': ''}}>
                                        @foreach($param->val as $on => $val)
                                            @if($on == 0)
                                                {{$item[$val] ? $item[$val] : '(Blank)'}}
                                            @else
                                                - {{$item[$val]}}
                                            @endif
                                        @endforeach
                                        @isset($param->info)
                                            @foreach($param->info as $vkey=>$val)
                                                @switch($val)
                                                    @case('Money')
                                                        (Sisa Budget Rp {{number_format($item[$vkey],2,',','.')}})
                                                        @break
                                                    @default
                                                        ({{ $item[$vkey]}})
                                                @endswitch
                                            @endforeach
                                        @endisset
                                    </option>
                                @endforeach
                            </select>
                        @break
                        @case('TextSel')
                            <datalist id="datalist_{{$key}}">
                                <?php
                                    $base_value='';
                                    $by = isset($param->by) ? $param->by : $key;
                                    $readonly = $detail && !(isset($param->force) && $param->force) || isset($param->lock)
                                ?>
                                @foreach ($select[$param->api] as $item)
                                    <?php
                                        $set = !$readonly;
                                        $txt='';
                                        $same = $item->id == $datas[$by];
                                        if ($set || $same){
                                            foreach($param->val as $kk => $val){
                                                $str = $item[$val];
                                                if ($kk == 0)
                                                        $txt = $txt.($str == '' ? '(Blank)':$str);
                                                else
                                                    $txt = $txt.' - '.$str;
                                            }
                                            if ($same){
                                                $set = true;
                                                $base_value = $txt;
                                                if (isset($param->share)){
                                                    $vshare = (array) $param->share;
                                                    foreach($columns as $kk => $vv){
                                                        if (($vv->type == 'Reference' || $vv->type=="RefArea") && $vv->key == $key){
                                                            $vkey = $vshare[$vv->val];
                                                            if ($vkey == 0){
                                                                $vv->def = $item[$vv->val];
                                                            }else{
                                                                $vv->def = '';
                                                                // echo json_encode($vkey);
                                                                foreach($vkey as $vkk => $vki){
                                                                    // return;
                                                                    $vv->def = $vv->def.($vkk == 0? '':' - ').$item[$vv->val][$vki];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    @if($set)
                                        <option
                                            @isset($param->share)
                                                <?php
                                                    $otxt = '{';
                                                    $i = 0;
                                                    foreach($param->share as $column => $share){
                                                        if ($share){
                                                            $otxt = $otxt.($i>0?'","':'"').$column.'":"';
                                                            foreach($share as $k => $v){
                                                                $otxt = $otxt.($k==0?'':' - ').str_replace('"',"!q",$item[$column][$v]);
                                                            }
                                                        }else
                                                            $otxt = $otxt.($i>0?'","':'"').$column.'":"'.str_replace('"',"!q",$item[$column]);
                                                        $i++;
                                                    }
                                                    $otxt = $otxt.'"}';
                                                ?>
                                                data-item="{{$otxt}}"
                                            @endisset
                                            data-value="{{$item->id}}"
                                            value="{{$txt}}">
                                        </option>
                                    @endif
                                @endforeach
                            </datalist>
                            <div class="col-end-7 col-start-1 md:col-start-2 relative block">
                                <input
                                    @if($readonly)readonly @endif
                                    v-on:change="inputSetUp('{{$key}}',$event, {{isset($param->share)}})"
                                    type="text"
                                    value="{{$base_value}}"
                                    list="datalist_{{$key}}"
                                    @isset($param->null)
                                        placeholder="(Blank)"
                                        onblank
                                    @else
                                        placeholder="Pilih {{$param->name}}"
                                    @endisset
                                    class="hide-ico w-full h-full rounded border px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                >
                                @if(!$readonly)
                                    <div class="pointer-events-none absolute top-0 right-2 h-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full" width="16" height="16" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <input id="{{$key}}" name="{{$key}}" value="{{$datas[$by]}}" hidden>
                        @break
                        @case('Total')
                            <?php
                                $def = 1;
                                foreach($param->from as $xvar){
                                    $def = $def * $datas[$xvar];
                                }
                            ?>
                            <input
                                disabled
                                from="{{json_encode($param->from)}}"
                                id="{{$key}}"
                                name="{{$key}}"
                                value="{{number_format($def,2,',','.')}}"
                                class="bg-gray-100 rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('TextArea')
                            <textarea
                                id="{{$key}}"
                                name="{{$key}}"
                                type="textarea"
                                rows="{{$param->row ?? 4}}"
                                @if($detail || isset($param->off))readonly @endif
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition @isset($param->iclass){{$param->iclass}}@endisset">{{isset($param->child) ? $datas[$param->by][$param->child] : $datas[$param->by]}}</textarea>
                        @break
                        @case('Upload')
                            <?php
                                $readonly = $detail || isset($param->off);
                                if (isset($param->force))
                                    $readonly = !$param->force;
                            ?>
                            <div class="col-end-7 col-start-1 md:col-start-2 flex">
                                @if(!$readonly)
                                    <div class="my-1 mr-1">
                                        <input
                                            class="hidden"
                                            type="file"
                                            id="{{$key}}"
                                            name="{{$key}}[]"
                                            accept="application/pdf"
                                            v-on:change="uploadChange('{{$param->key}}',$event)"
                                            multiple
                                        >
                                        <label class="bg-blue-400 hover:bg-blue-600 text-white cursor-pointer rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition" for="{{$key}}">Upload</label>
                                    </div>
                                @endif
                                <div class="loader w-full m-auto" v-bind:hidden="true"></div>
                                <div v-if="files['{{$param->key}}'] && files['{{$param->key}}'].length>0" class="w-full" v-bind:class="{block:true}" hidden>
                                    <div v-for="(file, index) in files['{{$param->key}}']" class="flex w-full py-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" v-bind:class="file.delete ? 'text-red-800':''"  width="25" height="25" fill="currentColor" class="my-auto mr-0.5" viewBox="0 0 16 16">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                        </svg>
                                        <input
                                            v-bind:disabled="file.delete"
                                            v-bind:class="file.delete ? 'line-through text-red-800 bg-red-50': file.change ? 'bg-yellow-50':''"
                                            class="w-full py-0.5 mr-2 rounded border col-end-7 col-start-1 md:col-start-2 px-2 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                            type="text"
                                            class="border"
                                            v-bind:name="file.id>0 && file.change ? 'fname['+file.id+']':false"
                                            v-model="file.name"
                                            v-on:input="file.change = file.name!=file.oname"
                                            @if($readonly)readonly @endif
                                        >
                                        <label v-on:click="file.id>0 ? downloadFileOn(file.id, file.oname, '{{$param->folder}}') : null" v-bind:class="file.id>0 ? 'bg-sky-500 hover:bg-sky-600 cursor-pointer':'bg-gray-500 text-gray-200 cursor-not-allowed'" class="mr-1 w-26 inline-flex text-white rounded border px-2 focus:shadow-inner focus:ring-1 focus:ring-red-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="my-auto" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z"/>
                                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                            </svg>
                                            <span class="text-sm my-auto mr-auto font-semibold hidden md:block ml-1">Download</span>
                                        </label>
                                        <div v-if="file.delete" v-on:click="deleteFile('{{$param->key}}',index)" class="w-24 inline-flex bg-yellow-500 hover:bg-yellow-600 text-white cursor-pointer rounded border px-2 focus:shadow-inner focus:ring-1 focus:ring-red-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto my-auto mr-1" width="14" height="14" fill="#fff" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                            </svg>
                                            <span class="text-sm my-auto mr-auto font-semibold">Undo</span>
                                            <input hidden name="_delfile_[]" v-bind:value="file.id">
                                        </div>

                                        @if(!$readonly)
                                        <label v-else v-on:click="deleteFile('{{$param->key}}',index)" class="w-24 inline-flex bg-red-500 hover:bg-red-600 text-white cursor-pointer rounded border px-2 focus:shadow-inner focus:ring-1 focus:ring-red-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto my-auto mr-1" width="14" height="14" fill="#fff" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                            </svg>
                                            <span class="text-sm my-auto mr-auto font-semibold">Delete</span>
                                        </label>
                                        @endif
                                    </div>
                                </div>
                                <span v-else class="my-auto ml-2" hidden v-bind:class="{block:true}">No file uploaded</span>
                            </div>
                        @break
                        @case('Date')
                            @if($detail || isset($param->off))
                                <input
                                    value="{{date('j F Y', strtotime($datas[$param->by]))}}"
                                    type="text"
                                    readonly
                                    class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                />
                            @else
                                <input
                                    id="{{$key}}"
                                    name="{{$key}}"
                                    value="{{$datas[$param->by]}}"
                                    type="date"
                                    @if($detail)readonly @endif
                                    v-on:change="onlyDate($event)"
                                    class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                />
                            @endif
                        @break
                        @case('DateTime')
                            <input id="{{$key}}" name="{{$key}}" value="{{date('Y-m-d\TH:i', strtotime($datas[$param->by]))}}" type="datetime-local" v-on:change="onlyDate($event)" class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('EmotionScore')
                            <div class="flex text-3xl md:text-3xl rounded mb-auto">
                                <input type="radio" id="es_awfull" name="score" value="1" @if($datas[$param->by]==1) checked @endif hidden>
                                <label title="Sangat Buruk" class="p-1 px-2 md:p-2 pb-2 bg-gray-200 rounded-tl-md rounded-l-md cursor-pointer flex" for="es_awfull">😔 <span class="hidden text-xs my-auto font-semibold text-center">Sangat Buruk</span></label>
                                <input type="radio" id="es_bad" name="score" value="2" @if($datas[$param->by]==2) checked @endif hidden>
                                <label title="Buruk" class="p-1 px-2 md:p-2 pb-2 bg-gray-200 cursor-pointer flex" for="es_bad">😕 <span class="hidden text-xs my-auto font-semibold text-center">Buruk</span></label>
                                <input type="radio" id="es_normal" name="score" value="3" @if($datas[$param->by]==3) checked @endif hidden>
                                <label title="Biasa" class="p-1 px-2 md:p-2 pb-2 bg-gray-200 cursor-pointer flex" for="es_normal">😐 <span class="hidden text-xs my-auto font-semibold text-center">Biasa</span></label>
                                <input type="radio" id="es_good" name="score" value="4" @if($datas[$param->by]==4) checked @endif hidden>
                                <label title="Baik" class="p-1 px-2 md:p-2 pb-2 bg-gray-200 cursor-pointer flex" for="es_good">🙂 <span class="hidden text-xs my-auto font-semibold text-center">Baik</span></label>
                                <input type="radio" id="es_best" name="score" value="5" @if($datas[$param->by]==5) checked @endif hidden>
                                <label title="Sangat Baik" class="p-1 px-2 md:p-2 pb-2 bg-gray-200 rounded-r-md cursor-pointer flex" for="es_best">😊 <span class="hidden text-xs my-auto font-semibold text-center">Sangat Baik</span></label>
                            </div>
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <div class="mt-4 md:mt-0">
            <div class="float-right">
                @if(!$detail)
                    <input
                        type="button"
                        class="flex rounded border px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto md:mr-5 cursor-pointer text-white font-semibold"
                        value="Update"
                        v-on:click="uploadRefresh('_subup_{{$unique}}_')"
                    >
                    <button
                        type="submit"
                        hidden
                        id="_subup_{{$unique}}_"
                        name="__type"
                        value="update"
                    ></button>
                @endif
            </div>
            {{ $slot }}
        </div>
        <div class="h-12"></div>
    </form>
</div>
