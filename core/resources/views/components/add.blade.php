<div class="md:px-6">
    <?php
        if (isset($error['data'])){
            $datas = $error['data'];
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
        }else{
            $columns = json_decode($column);
        }
    ?>
    <form class="container md:rounded-lg shadow my-3 md:my-8 py-2 md:py-4 px-3 md:px-6 bg-white text-xs md:text-base" action="{{request()->fullUrl()}}" method="POST" enctype="multipart/form-data">
        <input hidden name="_last_" value="{{request()->_last_ ? request()->_last_ : request()->fullUrl()}}">
        <h1 class="border-b text-lg md:text-2xl pb-2 border-gray-200 mb-2">
            @if($title!="Verifikasi")
                {{$title}}
            @endif
        </h1>
        @if($error)
            <div class="col-span-2">
                <div class="rounded-md bg-red-100 text-red-800 md:flex p-3">
                    <div class="inline-flex mb-auto">
                        <svg class="my-auto h-3 w-3 md:h-4 md:w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <div class="ml-1 md:ml-2" style="min-width:110px;">Error Message : </div>
                    </div>
                    <div class="md:ml-2">{{$error['msg']}}</div>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 md:gap-4 md:p-5">
            @csrf
            @foreach ($columns as $key => $param)
                <div @isset($param->if)if="{{json_encode($param->if)}}"@endisset class="grid @isset($param->class){{$param->class}}@endisset {{ isset($param->full) ? 'md:col-span-2 grid-cols-6':'grid-cols-3'}}">
                    @isset($param->name)
                        <label for="{{$key}}" class="my-1 md:mb-0 col-span-6 md:col-span-1">{{$param->name}}</label>
                    @endisset
                    @switch($param->type)
                        @case('Info')
                            <div class="col-end-7 col-start-1 md:col-start-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                <span class="hidden md:inline">:</span>
                                <span class="border p-1 rounded-md flex md:border-0 md:p-0 md:inline md:ml-2">
                                    <?php
                                        if ($param->type == 'Info')
                                            $value = isset($param->val) ? $param->val : 0;
                                        else
                                            $value = isset($param->val) ? $param->val : 0;
                                    ?>
                                    @isset($param->format)
                                        @switch($param->format)
                                            @case('Money')
                                                {{"Rp " . number_format($value,2,',','.')}}
                                            @break
                                        @endswitch
                                    @else
                                        {{$value}}
                                    @endisset
                                </span>
                            </div>
                        @break
                        @case('Reference')
                            <input readonly
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
                            <textarea readonly
                                id="{{$key}}"
                                name="{{$key}}"
                                value-from="{{$param->key}}"
                                based="{{$param->val}}"
                                type="text"
                                rows="4"
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
                                    id="{{$key}}"
                                    @isset($param->max)
                                        maxlength="{{$param->max}}"
                                        v-on:input="refMax($event,'{{$key}}_v_',{{$param->max}})"
                                    @endisset
                                    name="{{$key}}"
                                    type="text"
                                    @isset($error['data'][$key])
                                        value="{{$error['data'][$key]}}"
                                    @endisset
                                    class="w-full h-full rounded border px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                />
                                @isset($param->max)
                                    <div id="{{$key}}_v_" class="pointer-events-none absolute top-1 right-2 h-full">
                                        <span >0</span>/{{$param->max}}
                                    </div>
                                @endisset
                            </div>
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
                                @isset($error['data'][$key])
                                    value="{{$error['data'][$key]}}"
                                @elseif(isset($param->def))
                                    value="{{$param->def}}"
                                @endisset
                                @isset($param->float)
                                    step="{{$param->float}}"
                                @endisset
                                placeholder="0"
                                type="number"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('Total')
                            <input
                                readonly
                                from="{{json_encode($param->from)}}"
                                @isset($error['data'][$key])
                                    value="{{$error['data'][$key]}}"
                                @endisset
                                id="{{$key}}"
                                name="{{$key}}"
                                class="bg-gray-100 rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @case('TextSel')
                            <datalist id="datalist_{{$key}}">
                                <?php
                                    $cid = isset($param->id) ? $param->id : 'id';
                                    $base_value='';
                                    $tsdef = isset($error['data'][$key]) ? $error['data'][$key] : (isset($param->def) ? $param->def : null);
                                ?>
                                @foreach ($select[$param->api] as $item)
                                    <option
                                        <?php
                                            $samerr = isset($error['data'][$key]) && $item[$cid] == $tsdef;
                                            $txt='';
                                            if (isset($param->format)){
                                                foreach($param->val as $kk => $val){
                                                    $txt = $txt.$param->format[$kk*2].$item[$val].$param->format[$kk*2+1];
                                                }
                                            }else{
                                                foreach($param->val as $kk => $val){
                                                    $str = $item[$val];
                                                    if ($kk == 0)
                                                        $txt = $txt.($str == '' ? '(Blank)':$str);
                                                    else
                                                        $txt = $txt.' - '.$str;
                                                }
                                            }
                                            if ($item[$cid] == $tsdef)
                                                $base_value = $txt;
                                            if ($samerr){
                                                if (isset($param->share)){
                                                    $vshare = (array) $param->share;
                                                    foreach($columns as $kk => $vv){
                                                        if (($vv->type == 'Reference' || $vv->type=="RefArea") && $vv->key == $key){
                                                            $vkey = $vshare[$vv->val];
                                                            if ($vkey == 0){
                                                                $vv->def = $item[$vv->val];
                                                            }else{
                                                                $vv->def = '';
                                                                foreach($vkey as $vkk => $vki){
                                                                    $vv->def = $vv->def.($vkk == 0? '':' - ').$item[$vv->val][$vki];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                        @isset($param->share)
                                            <?php
                                                $otxt = '{';
                                                $i = 0;
                                                // $br =
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
                                        data-value="{{$item[$cid]}}"
                                        value="{{$txt}}"
                                        >
                                    </option>
                                @endforeach
                            </datalist>
                            <div class="col-end-7 col-start-1 md:col-start-2 relative block">
                                <input
                                    v-on:input="inputSetUp('{{$key}}',$event, {{isset($param->share)}})"
                                    type="text"
                                    value="{{$base_value}}"
                                    list="datalist_{{$key}}"
                                    @isset($param->lock)
                                        disabled
                                    @endisset
                                    @isset($param->null)
                                        placeholder="(Blank)"
                                        onblank
                                    @else
                                        placeholder="Pilih {{$param->name}}"
                                    @endisset
                                    class="hide-ico w-full h-full rounded border px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                >
                                <div class="pointer-events-none absolute top-0 right-2 h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full" width="16" height="16" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <input id="{{$key}}" name="{{$key}}"
                                @if($tsdef)
                                    value="{{$tsdef}}"
                                @endif
                                hidden
                            >
                        @break
                        @case('Disable')
                            <?php
                                $txt = '';
                                foreach($param->val as $kk => $val){
                                    $txt = $txt.($kk?' - ':'').$select[$param->api][$val];
                                }
                            ?>
                            <input disabled id="{{$key}}" name="{{$key}}" value="{{$txt}}" type="text" class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                        @break
                        @case('Select')
                            <?php
                                $tsdef = isset($error['data'][$key]) ? $error['data'][$key] : (isset($param->def) ? $param->def : null);
                            ?>
                            <select
                                id="{{$key}}"
                                name="{{$key}}"
                                @isset($param->direct)
                                    onchange="location = '?{{$param->direct}}='+this.options[this.selectedIndex].value;"
                                @endisset
                                {{-- @isset($param->direct)v-on:change="inputDirect('{{$param->direct}}')"@endisset --}}
                                @if($tsdef)
                                    value="{{$tsdef}}"
                                @endif
                                @isset($param->share)v-on:change="inputSetIf('{{$key}}',$event)"@endisset
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                                @isset($param->null)
                                    <option selected value="" class="text-gray-400">(Blank)</option>
                                @endisset
                                @foreach ($select[$param->api] as $item)
                                    <option
                                        @if($tsdef && $tsdef == $item['id'])selected @endif
                                        @isset($param->share)
                                            share="{{$item[$param->share]}}"
                                        @endisset
                                        value={{$item['id']}}
                                        >
                                            @foreach($param->val as $vkey => $val)
                                                @if($vkey == 0)
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
                        @case('TextArea')
                            <textarea
                                id="{{$key}}"
                                name="{{$key}}"
                                type="textarea"
                                rows="4"
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">@isset($error['data'][$key]){{$error['data'][$key]}}@endisset</textarea>
                        @break
                        @case('Upload')
                            <div class="col-end-7 col-start-1 md:col-start-2 md:flex">
                                <div class="my-1">
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
                                <div v-if="files['{{$param->key}}'] && files['{{$param->key}}'].length>0" class="md:ml-2 w-full">
                                    <div v-for="(file, index) in files['{{$param->key}}']" class="flex w-full py-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" v-bind:class="file.delete ? 'text-red-800':''"  width="25" height="25" fill="currentColor" class="my-auto mr-0.5" viewBox="0 0 16 16">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                        </svg>
                                        <input
                                            v-bind:disabled="file.delete"
                                            v-bind:class="file.delete ? 'line-through text-red-800 bg-red-50':''"
                                            class="w-full py-0.5 mr-2 rounded border col-end-7 col-start-1 md:col-start-2 px-2 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                            type="text"
                                            class="border"
                                            v-model="file.name"
                                        >
                                        <label v-if="file.delete" v-on:click="deleteFile('{{$param->key}}',index)" class="w-24 inline-flex bg-yellow-500 hover:bg-yellow-600 text-white cursor-pointer rounded border px-2 focus:shadow-inner focus:ring-1 focus:ring-red-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto my-auto mr-1" width="14" height="14" fill="#fff" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                            </svg>
                                            <span class="text-sm my-auto mr-auto font-semibold">Undo</span>
                                        </label>
                                        <label v-else v-on:click="deleteFile('{{$param->key}}',index)" class="w-24 inline-flex bg-red-500 hover:bg-red-600 text-white cursor-pointer rounded border px-2 focus:shadow-inner focus:ring-1 focus:ring-red-300 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto my-auto mr-1" width="14" height="14" fill="#fff" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                            </svg>
                                            <span class="text-sm my-auto mr-auto font-semibold">Delete</span>
                                        </label>
                                    </div>
                                </div>
                                <span v-else class="my-auto ml-2">No file chosen</span>
                            </div>
                        @break
                        @case('Date')
                            <?php
                                if (!$tsdef = isset($error['data'][$key]) ? $error['data'][$key] : null)
                                    if (isset($param->def)){
                                        $date = new DateTime();
                                        $date->modify("+".$param->def." day");
                                        $tsdef = $date->format("Y-m-d");
                                    }
                            ?>
                            <input
                                id="{{$key}}"
                                name="{{$key}}"
                                type="date"
                                @if($tsdef)
                                    value="{{$tsdef}}"
                                @endif
                                @isset($param->off)
                                    readonly
                                @endisset
                                class="rounded border col-end-7 col-start-1 md:col-start-2 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                            />
                        @break
                        @default
                    @endswitch
                </div>
            @endforeach
        </div>
        <?php
            $butt = "Add ".$title;
            switch($title){
                case 'Propose':
                    $butt = "Propose";
                break;
                case 'Verification':
                    $butt = "Verification";
                break;
                case 'Verification - Proposed':
                    $butt = "Verification - Proposed";
                break;
            }
        ?>
        <input
            type="button"
            class="flex rounded border mt-5 md:mt-2 px-4 py-2 bg-green-500 hover:bg-green-600 ml-auto md:mr-5 cursor-pointer text-white font-semibold"
            value="{{$butt}}"
            v-on:click="uploadRefresh('_subad_{{$unique}}_')"
        >
        <button
            type="submit"
            hidden
            id="_subad_{{$unique}}_"
        ></button>
    </form>
</div>
