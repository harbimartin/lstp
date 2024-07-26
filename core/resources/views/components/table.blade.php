<div class="md:px-6">
    <div class="md:rounded-lg shadow mt-4 mb-8 py-4 px-2 md:px-6 bg-white">
        @isset($title)
            <div class="border-b text-lg md:text-2xl pb-2 border-gray-200 mb-2 md:mb-5">{{$title}}</div>
        @endif
        @if($tool)
            <div class="md:flex text-xs md:text-sm">
                @if($lim)
                    <?php
                        if (isset(request()->el))
                            $cel = request()->el;
                        else
                            $cel = 10;
                    ?>
                    <div class="flex mb-1 md:mb-0">
                        <div class="my-auto md:w-auto w-16 ">Show</div>
                        <select
                            v-on:change="updateParam('el', $event.target.value, 'page');"
                            class="md:ml-1 mr-1 rounded border border-gray-300 col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition">
                            @for ($i = 5; $i <= 100; $i+=($i<30)?($i<10?5:10):($i<50?20:50))
                                <option value={{$i}} @if($cel == $i) selected @endif> {{$i}} </option>
                            @endfor
                        </select>
                        <div class="my-auto">Entries</div>
                    </div>
                @endif
                {{ $slot }}
                @if($datef)
                    <div class="md:ml-5 flex">
                        <div class="md:w-auto w-16 my-auto">From&nbsp;</div><input v-on:change="updateParam('df', $event.target.value);" type="date" id="date-from" name="from" value="@isset(request()->df){{request()->df}}@else{{'2021-01-01'}}@endisset" class="rounded-lg border border-gray-300 col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                    </div>
                    <div class="md:ml-3 flex mt-1 md:mt-0">
                        <div class="md:w-auto w-16 my-auto">To&nbsp;</div><input v-on:change="updateParam('dt', $event.target.value);" type="date" id="date-to" name="to" value="@isset(request()->dt){{request()->dt}}@else{{(new DateTime())->format('Y-m-d')}}@endisset"  class="rounded-lg border border-gray-300 col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"/>
                    </div>
                @endif
                @if($filter)
                <div class="md:mx-2 inline-flex mt-1 md:my-0">
                    <div class="my-auto mr-1 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                        </svg>
                    </div>
                    @foreach(json_decode($filter) as $flt)
                    <div
                        <?php $selected = (request()->fl==$flt->key && request()->tfl==$flt->type); ?>
                        v-on:click="updateParamArray([{k:'fl',v:'{{$flt->key}}'},{k:'tfl',v:'{{$flt->type}}'}]);"
                        class="
                            inline-flex
                            {{$selected ? 'bg-'.$flt->col.'-600 text-white hover:bg-'.$flt->col.'-500 border-'.$flt->col.'-600 ':'hover:bg-'.$flt->col.'-300 border-gray-300 '}}
                            {{$loop->first ? 'rounded-tl-xl rounded-bl-xl':'border-l-0'}}
                            @if($loop->last) rounded-tr-xl rounded-br-xl @endif
                            border col-start-2 col-end-7 px-2 hover:shadow-inner hover:outline-none hover:ring-1 hover:border-transparent transition cursor-pointer py-0.5"
                    >
                        <div class="my-auto">{{$flt->name}}</div>
                        @isset($flt->count)
                            <div class="mx-2 my-auto rounded-xl {{$selected ? 'bg-white text-'.$flt->col.'-600':'bg-'.$flt->col.'-600 text-white'}} text-sm font-semibold px-2.5 pb-0.5">
                                <small>{{$flt->count}}</small>
                            </div>
                        @endisset
                    </div>
                    @endforeach
                </div>
                @endif
                @if($import || $export || $search)
                        @if($import)
                        <div class="md:mx-2 mt-1 md:my-0">
                            <input
                                v-on:click="onImport = true"
                                class="flex rounded border border-gray-300 px-4 py-1 md:py-2 md:mx-2 bg-green-500 hover:bg-green-600 cursor-pointer text-white font-semibold"
                                type="button"
                                value="Import Excel"
                            />
                        </div>
                        @endif
                        @if($export)
                        <div class="md:mx-2 mt-1 md:my-0">
                            <input
                                v-on:click="exportExcels('{{request()->url()}}','{{request()->fullUrl()}}')"
                                class="md:float-right rounded border border-green-600 px-4 py-1 md:py-2 bg-green-500 hover:bg-green-600 mr-2 cursor-pointer text-white font-semibold"
                                type="button"
                                value="Export Excel"
                            />
                        </div>
                        @endif
                        @if($search)
                        <div class="w-full md:w-auto flex md:ml-auto mt-1">
                            <input
                                type="search"
                                id="{{$sign?$sign.'_':''}}searchs"
                                class="w-full rounded-lg border border-gray-300 col-start-2 col-end-7 px-2 py-1 focus:shadow-inner focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-transparent transition"
                                placeholder="Type for search..."
                                value="{{request()->sc}}"
                            />
                            <button class="ml-2 px-2 rounded-lg border border-blue-800 transition bg-blue-700 hover:bg-blue-800 text-white font-semibold" v-on:click="updateParamById('sc', '{{$sign ? $sign."_":""}}searchs');">Search</button>
                        </div>
                        @endif
                @endif
            </div>
        @endif
        @if($import)
        <div v-if="onImport" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <form method="post" action="?mode=import" enctype="multipart/form-data" class="inline-block align-bottom bg-gray-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-700 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-200" id="modal-title">
                                Import Data
                            </h3>
                            <div class="mt-2">
                                <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <label>Pilih file excel</label>
                                                    <div class="form-group">
                                                        <input type="file" name="file" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button v-on:click="onImport = false" type="submit" class="w-full inline-flex justify-center rounded-md border border-blue-800 border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Upload
                </button>
                <button v-on:click="onImport = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
                </div>
            </form>
            </div>
        </div>
        @endif
        <div class="flex flex-col mt-4 ">
            <div class="-my-2 overflow-x-auto md:mx-0 max-w-6xl min-w-full">
              <div class="py-2 align-middle inline-block lg:px-1 min-w-full">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="divide-y divide-gray-200 min-w-full">
                    <thead class="bg-gray-50 text-xs md:text-xs">
                      <tr>
                        @foreach (json_decode($column) as $key => $param)
                            <th scope="col">
                                <div class="flex px-2 py-3 text-left font-medium text-gray-500 uppercase md:tracking-wider {{isset($param->align) ? 'text-'.$param->align : ($param->type=='Boolean'  ||  $param->type=='Edit' ? 'text-center':'') }}">
                                    <div class="flex-auto">{!! $param->name !!}</div>
                                    @if(!isset($param->sort) && $sort)
                                        @if(request()->asort == $key)
                                            <div class="flex-none my-auto ml-1 text-blue-700 hover:text-blue-500 cursor-pointer" v-on:click="updateParam('dsort', '{{$key}}', 'asort');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                                </svg>
                                            </div>
                                        @elseif(request()->dsort == $key)
                                            <div class="flex-none my-auto ml-1 text-blue-700 hover:text-blue-500 cursor-pointer" v-on:click="updateParam('asort', '{{$key}}', 'dsort');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                                  </svg>
                                            </div>
                                        @else
                                            <div class="flex-none my-auto ml-1 hover:text-blue-400 text-gray-400 cursor-pointer" v-on:click="updateParam('asort', '{{$key}}', 'dsort');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" fill="currentColor" height="12" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </th>
                        @endforeach
                        {{-- <th scope="col" class="relative px-6 py-3">
                          <span class="sr-only">Edit</span>
                        </th> --}}
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(sizeof($datas)==0)
                        <tr>
                            <td colspan="100%" height="50" class="text-center bg-gray-50 text-gray-400">
                                <div class="inline-block  py-5">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-inbox" viewBox="0 0 16 16">
                                        <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z"/>
                                    </svg>
                                    <div>Tidak Ada Data</div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @foreach ($datas as $iind=>$item)
                        <tr class="text-gray-900 text-xs md:text-sm">
                            @foreach (json_decode($column) as $key => $param)
                                <td class="@if(!isset($param->sort) && $sort) pr-3 @endisset py-4 px-2 whitespace-nowrap {{isset($param->align) ? 'text-'.$param->align : ($param->type=='State' || $param->type=='Boolean' ||  $param->type=='Edit' ? 'text-center':'') }} @isset($param->if){{($item[$param->if[0]] == $param->if[1]) == $param->if[2] ? '':'hidden'}}@endisset">
                                    @if($param->type == 'Multi')
                                        @foreach($param->children as $ckey => $cparam)
                                            <x-tswitch :key="$ckey" :param="$cparam" :item="$item" :idk="$idk" :iind="$iind"></x-tswitch>
                                        @endforeach
                                    @else
                                        <x-tswitch :key="$key" :param="$param" :item="$item" :idk="$idk" :iind="$iind"></x-tswitch>
                                    @endif
                                </td>
                            @endforeach
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            @if($tool && $lim)
            <div class="md:inline-flex mt-3 md:mt-6 mb-2 text-center">
                <div class="text-xs md:text-sm text-gray-600 md:mr-3 md:ml-auto md:my-auto">
                    Show {{$prop['count']}} of {{$prop['total']}}
                </div>
                <div class="mt-2 md:mt-0 mx-auto md:mr-6 md:ml-0 inline-flex text-sm md:text-base">
                    <svg
                        @if($prop['current_page']>1)
                            v-on:click="updateParam('page', 1);"
                            class="mt-0.5 text-gray-800 hover:text-blue-500 cursor-pointer"
                        @else
                            class="mt-0.5 text-gray-300 cursor-not-allowed"
                        @endif
                        xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"
                    >
                        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <svg
                        @if($prop['current_page']>1)
                            v-on:click="updateParam('page', {{$prop['current_page']-1}});"
                            class="mt-0.5 text-gray-800 hover:text-blue-500 cursor-pointer"
                        @else
                            class="mt-0.5 text-gray-300 cursor-not-allowed"
                        @endif
                        xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"
                    >
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <ul class="mx-1.5 my-auto" style="list-style-type: none;">
                        @if($prop['total_pages']<10)
                            @for ($i=1; $i<=$prop['total_pages']; $i++)
                                <li
                                    @if($i == $prop['current_page'])
                                        class="font-semibold float-left mx-1.5 text-blue-500 cursor-not-allowed"
                                    @else
                                        v-on:click="updateParam('page', {{$i}});"
                                        class="font-semibold float-left mx-1.5 cursor-pointer text-gray-800 hover:text-blue-500"
                                    @endif
                                >
                                    {{$i}}
                                </li>
                            @endfor
                        @else
                            <?php
                                $ilf = max($prop['current_page']-4, 1);
                                $ill = min($ilf+8, $prop['total_pages']);
                                $ilf = max($ill-8, 1);
                            ?>
                            @if($ilf>1)
                                <li class="font-semibold float-left ml-1.5 text-gray-800">...</li>
                            @endif
                            @for($i=$ilf; $i<=$ill; $i++)
                                <li
                                    @if($i == $prop['current_page'])
                                        class="font-semibold float-left mx-1.5 text-blue-600 cursor-not-allowed"
                                    @else
                                        v-on:click="updateParam('page', {{$i}});"
                                        class="font-semibold float-left mx-1.5 cursor-pointer hover:text-gray-800"
                                    @endif
                                >
                                    {{$i}}
                                </li>
                            @endfor
                            @if($ilf<$prop['total_pages'])
                                <li class="font-semibold float-left mr-1.5 text-gray-300">...</li>
                            @endif
                        @endif
                    </ul>
                    <svg
                        @if($prop['current_page']<$prop['total_pages'])
                            v-on:click="updateParam('page', {{$prop['current_page']+1}});"
                            class="mt-0.5 text-gray-800 hover:text-blue-500 cursor-pointer"
                        @else
                            class="mt-0.5 text-gray-300 cursor-not-allowed"
                        @endif
                        xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"
                    >
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <svg
                        @if($prop['current_page']<$prop['total_pages']-1)
                            v-on:click="updateParam('page', {{$prop['total_pages']}});"
                            class="mt-0.5 text-gray-800 hover:text-blue-500 cursor-pointer"
                        @else
                            class="mt-0.5 text-gray-300 cursor-not-allowed"
                        @endif
                        xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"
                    >
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
