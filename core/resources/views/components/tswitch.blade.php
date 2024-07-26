@switch($param->type)
    @case('Check')
        <input type="checkbox" name="{{$key}}[]" value="{{$item[$param->key]}}"/>
        @break
    @case('Number')
            <div class="{{isset($param->align) ? 'text-'.$param->align : 'text-right mr-3'}}">@isset($param->format){{$param->format }}@endisset{{number_format($item[$key],$param->decimal ?? 0,',','.')}}</div>
        @break
    @case('SString')
        <?php
            $pkey = isset($param->by) ? $param->by : $key;
            $txt = '';
            if (is_array($param->child)){
                foreach($param->child as $kk => $val){
                    $str = $item[$pkey][$val];
                    if ($kk == 0)
                        $txt = $txt.($str == '' ? '(Blank)':$str);
                    else
                        $txt = $txt.' - '.$str;
                }
            }else {
                $txt = $item[$pkey][$param->child];
            }
        ?>
            <div class="@isset($param->iclass){{$param->iclass}}@endisset @isset($param->wrap) whitespace-normal @endisset">{{$txt}}</div>
        @break
    @case('String')
            <div class="@isset($param->iclass){{$param->iclass}}@endisset @isset($param->wrap) whitespace-normal @endisset" @isset($param->wrap)style="min-width:200px;"@endisset>{{$item[$key]}}</div>
        @break
    @case('TextArea')
        @if($item[$key])
            <p class="text-ellipsis whitespace-normal">{{$item[$key]}}</p>
        @else
            <p class="text-gray-400 text-ellipsis whitespace-normal" style="min-width:200px;">@isset($param->empty) {{$param->empty}} @else (Tidak ada) @endisset</p>
        @endif
    @break
    @case('Date')
            <div class="text-gray-900">{{date('j F, Y', strtotime($item[$key]))}}</div>
        @break
    @case('DateTime')
            @isset($param->wrap)
                <div class="whitespace-nowrap">{{date('j F, Y H:i:s', strtotime($item[$key]))}}</div>
            @else
                @if($item[$key])
                    <div class="text-gray-900">{{date('j F, Y', strtotime($item[$key]))}}</div>
                    <div class="text-gray-900">{{date('H:i:s', strtotime($item[$key]))}}</div>
                @else
                    <div class="text-gray-900">-</div>
                @endif
            @endisset
        @break
    @case('Boolean')
        <div class="flex">
            <div class="px-2 inline-flex mx-auto text-xs leading-5 font-semibold rounded-full {{$item[$key] ? 'bg-green-100 text-green-800':'bg-red-100 text-red-800'}}">
                {{$param->val[$item[$key]]}}
            </div>
        </div>
        @break
    @case('SState')
        <?php
            $val = 0;
            foreach($param->switch as $i=>$sw){
                if ($sw == $item[$key]){
                    $val = $i;
                }
            }
        ?>
            <small class="px-2 inline-flex mx-auto leading-5 font-semibold rounded-full bg-{{$param->col[$val]}}-100 text-{{$param->col[$val]}}-800">
                {{$param->val[$val]}}
            </small>
        @break
    @case('State')
        {{-- <small class="flex"> --}}
            @if($item[$key]=='AKTIF')
                <small class="px-2 inline-flex mx-auto leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{$item[$key]}}
                </small>
            @else
                <small class="px-2 inline-flex mx-auto leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    {{$item[$key]}}
                </small>
            @endif
        {{-- </div> --}}
        @break
    @case('Edit')
    <div>
        <?php
            $val = "Edit";
            if (isset($param->switch))
                $val = $param->then[($item[$param->switch[0]] != $param->switch[1]) == $param->switch[2]];
            if (isset($param->txt))
                $val = $param->txt;
        ?>
        @isset($param->header)
            <a href="{{$param->header[0].'?'.$param->header[1].'='.$item[$idk].(sizeof($param->header)==3? $param->header[2] : '')}}" class="text-indigo-600 hover:text-indigo-900">
                {{$val}}
            </a>
        @else
            <a href="{{Request::url().'?id='.$item[$idk]}}" class="text-indigo-600 hover:text-indigo-900">
                {{$val}}
            </a>
    </div>
        @endisset
        @break
    @case('Delete')
        <form action="{{Request::url().'/'.$item[(isset($param->id) ? $param->id : 'id')]}}" method="POST">
            @csrf
            @method('DELETE')
            <input id="url" name="url" value="{{Request::fullUrl()}}" hidden>
            <button type="submit" class="text-indigo-600 hover:text-indigo-900">Delete</button>
        </form>
        @break
    @case('Direct')
            <a href="{{$param->url.'/view'}}" class="text-indigo-600 hover:text-indigo-900">View</a>
        @break
    @case('Post')
        <form action="{{(isset($param->header) ? url('/'.$param->header) : Request::url()).'/'.$item['id']}}" method="POST">
            @csrf
            @method('PUT')
            <input hidden name="_last_" value="{{request()->fullUrl()}}">
            <button type="submit" name="type" value="{{$param->for}}" class="text-blue-600 hover:text-blue-900">{{$param->then[0]}}</button>
        </form>
        @break
    @case('Toggle')
        <form action="{{Request::url().'/'.$item['id']}}" method="POST">
            @csrf
            @method('PUT')
            <input id="{{$key}}" name="{{$key}}" value="{{$item[$key]?0:1}}" hidden>
            <button type="submit" class="text-indigo-600 hover:text-indigo-900">{{$item[$key] ? 'Nonaktifkan' : 'Aktifkan'}}</button>
        </form>
        @break
    @case('No')
        <div class="text-gray-900">{{$iind + 1}}</div>
    @break
    @case('Slot')
            @switch($key)
                @case('vendor')
                    <?php
                        $vendors = $item['vendors'];
                    ?>
                    Nama : {{$vendors['contact']}}<br>
                    Email : {{$vendors['email']}}<br>
                    Posisi : {{$vendors['posisi']}}<br>
                @break;
                @case('item')
                    <?php
                        $items = $item['item'];
                    ?>
                    @foreach($items as $item)
                        - {{$item['name']}}<br>
                    @endforeach
                @break;
                @case('file')
                    @if(sizeof($item->vfile)==0)
                        <div class="text-gray-400 ml-6 mt-1">(Tidak ada)</div>
                    @else
                        <ol class="mt-2 ml-4 list-decimal">
                            @foreach ($item->vfile as $vkey => $vfile)
                                <li class="w-full text-gray-600 group cursor-pointer hover:bg-blue-100 px-1" v-on:click="downloadFileOn({{$vfile->id}}, '{{$vfile->file_desc}}', 'file_verify')">
                                    <div class="mr-2 truncate flex">
                                        <div class="my-auto mr-3">{{$vfile->file_desc}}</div>
                                        <div class="text-blue-300 ml-auto group-hover:bg-blue-500 group-hover:text-white p-1 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                                <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                @break
                @case('waiting')
                    @if($item->lastw)
                    <div class="mr-auto leading-5 rounded-full text-gray-800">
                            <span class="font-gray-500">{{$item->lastw[0]}} :</span>
                            <span class="font-medium">{{$item->lastw[1]}}</span>
                        </div>
                    @endif
                @break
                @case('argo')
                    <?php
                        $approved = new DateTime($item['approved']);
                        $now = new DateTime('NOW');
                        $between = $approved->diff($now);
                    ?>
                    <div class="mx-auto">
                        {{ $between->format("%d Hari") }}
                    </div>
                @break
            @endswitch
        @break
    @default
        @break
@endswitch
