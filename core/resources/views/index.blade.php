<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    {{-- <script src="https://unpkg.com/vue"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <title>SLPT PT.KBS</title>
    <style>
      input.hide-ico::-webkit-calendar-picker-indicator {
        display: none !important;
      }
      input[onblank]::placeholder{
          color:black;
      }
      .bg-sky-500{
        background-color: rgb(14 165 233);
      }
      .hover\:bg-sky-600:hover{
        background-color: rgb(2 132 199);
        }
        .hshow{
            display: block !important;
        }
    .loader {
        border: 4px solid #e0f2ff; /* Light grey */
        border-top: 3px solid #66abd8; /* Blue */
        border-radius: 90%;
        width: 25px;
        height: 25px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .lbar, .rbar{
        transition : width 1s;
    }
    .lbar{
        width: 16.666667%;
    }
    .rbar{
        width: 83.333333%;
    }
    .lbar.hide{
        width: 0%;
    }
    .rbar.show{
        width: 100%;
    }
    .chat{
        /* background-color:currentColor; */
        transition: background-color .25s;
    }
    .bg-emerald-100{
        background-color: rgb(231, 255, 193);
    }
    .chat.highlight{
        background-color:rgb(250, 249, 178);
        transition:0s;
    }
    .minimize{
        /* display: none; */
        /* margin:0px; */
        visibility: hidden;
        max-width: 0px;
    }

    @media (min-width: 768px) {
        .max-w-90{
            max-width: 90vw;
        }
        .fw-nav{
            min-width:14rem;
            max-width:14rem;
        }
        .group:hover .group-hover\:ml-2 {
            margin-left: 0.5rem/* 8px */;
        }
        .group:hover .group-hover\:maxim{
            visibility: visible;
            transition: max-width .75s;
            max-width:1000px;
            /* display: block; */
        }
    }
    .thidden{
        transition: max-height .5s;
        transition-timing-function: cubic-bezier(0.075, 0.82, 0.165, 1);
        max-height:0px;
        overflow:hidden;
    }
    .thidden.block{
        transition:.5s;
        max-height:250px;
    }
    input+label{
        filter: grayscale(80%);
    }
    input+label:hover{
        background-color:#bccbd4;
        filter: grayscale(40%);
    }
    input:checked+label{
        background-color:#c3dae9;
        filter: none;
    }
    input:checked+label>span{
        display: block;
    }
    /* .tshadow{
        text-shadow: rgba(0, 0, 0, 0.13) 1px 1px 1px;
    } */
    </style>
</head>
<body>
    <?php
        $lstp = $_SESSION['lstp_ta'];
        $name = 'approv';
        $menus = [
            'home'=>['name'=>'Home', 'ico'=>'home.svg'],
            // 'persetujuan'=>['name'=>'Persetujuan', 'ico'=>'parent.svg', 'children'=>[
                'persetujuan'=>['name'=>'Persetujuan', 'ico'=>'menu_data.png', 'notif'=>'lstp'],
                'draft'=>['name'=>'Draft LSTP', 'ico'=>'menu_data.png'],
                'overview'=>['name'=>'Overview LSTP', 'ico'=>'menu_data.png'],
            // ]]
        ];
        // if (!$_SESSION['eproc_admin']){
        //     unset($menus['verifikasi']);
        //     unset($menus['verif']);
        // }
        // if (!$_SESSION['eproc_pengadaan']){
        //     unset($menus['log']);
        // }
    ?>
    <section id="vue-app" class="body md:flex max-w-screen max-h-screen ">
        <section class="navigation w-full md:h-screen md:max-h-screen md:border-gray-300 md:border-r fw-nav">
            <div class="md:hidden block">
                <div class="flex justify-end py-2 px-2" v-on:click="show = !show">
                    <img src="{{url('/assets/menu.svg')}}" alt="menu">
                </div>
            </div>
            <div class="md:block top-0 left-0 bottom-0 right-0" hidden v-bind:class="{block:show}">
                <div class="avatar inline-flex md:block md:text-center md:my-5 md:mb-5 px-3">
                    <img src="{{url('/assets/avatar'.(env('DB_HOST')=='192.168.0.27' ? 'e':'s').'.svg')}}" class="rounded-full mr-4 md:mx-auto bg-black" alt="avatar" width="96" height="96">
                        <?php
                            $username = 'Unknown';
                            $nik = '';
                            if(isset($_SESSION['eproc_id']) && !empty($_SESSION['eproc_id'])){
                                $username = $_SESSION['eproc_name'];
                                $nik = $_SESSION['eproc_nik'];
                            }
                        ?>
                    <div class="my-auto md:my-2">
                        <h6 class="font-semibold">{{$username}}</h6>
                        <h6 class="">{{$nik}}</h6>
                    </div>
                </div>
                <div class="mt-4">
                    <?php $sel_tab = '' ?>
                    @foreach ($menus as $kmenu => $menu)
                        <a @isset($menu['children']) v-on:click="showTab('{{$kmenu}}')" @else href="{{ url('/') }}/{{$kmenu}}" @endisset>
                            <div class="inline-flex w-full px-3 py-2.5 cursor-pointer {{isset($on) && $on==$kmenu ? 'bg-blue-100 hover:bg-blue-200' : 'hover:bg-gray-100 '}}">
                                <img class="h-5 w-5 my-auto" src="{{url('/assets/'.$menu['ico'])}}">
                                <p class="my-auto ml-3 text-sm font-semibold">{{$menu['name']}}</p>
                                @isset($menu['notif'])
                                    <div class="rounded-xl bg-red-600 text-white text-sm font-semibold px-2.5 py-0.5 ml-auto mr-4 my-auto">
                                        <?php echo ${$menu['notif']}; ?>
                                    </div>
                                @endisset
                            </div>
                        </a>
                        @isset($menu['children'])
                        <div class="thidden" v-bind:class="{block:tmenu=='{{$kmenu}}'}">
                            @foreach($menu['children'] as $kchild => $child)
                            <a href="{{ url('/') }}/{{$kchild}}">
                                <?php
                                     if (isset($on) && $on==$kchild){
                                         $sel_tab = $kmenu;
                                         $onm = true;
                                     }else
                                        $onm = false
                                ?>
                                <div class="inline-flex w-full pl-6 pr-3 py-2.5 cursor-pointer {{$onm ? 'bg-blue-100 hover:bg-blue-200' : 'hover:bg-gray-100 '}}">
                                    <img class="h-5 w-5 mb-auto mt-1" src="{{url('/assets/'.$child['ico'])}}">
                                    <p class="my-auto ml-3 text-sm font-semibold">{{$child['name']}}</p>
                                    @isset($child['notif'])
                                        <div class="rounded-xl bg-red-600 text-white text-sm font-semibold px-2.5 py-0.5 ml-auto mr-4 mb-auto mt-0.5">
                                            <?php echo ${$child['notif']}; ?>
                                        </div>
                                    @endisset
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endisset
                    @endforeach
                    <a href="http://ss0.krakatauport.id:8086/lstp/core/public/manual-lstp-user-v1.pdf" target="_blank">
                        <div class="inline-flex w-full px-3 py-2.5 cursor-pointer hover:bg-gray-100">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_data.png')}}">
                            <p class="my-auto ml-3 text-sm font-semibold">Manual Book</p>
                        </div>
                    </a>
                    <a href="http://ss0.krakatauport.id:8086/kipsinglewindow">
                        <div class="inline-flex w-full px-3 py-2.5 cursor-pointer hover:bg-gray-100">
                            <img class="h-5 w-5 my-auto" src="{{url('/assets/menu_logout.png')}}">
                            <p class="my-auto ml-3 text-sm font-semibold">Logout</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <section class="pages w-full h-screen max-h-screen bg-gray-200">
            <div id="content-section" class="overflow-y-auto max-h-screen">
                @yield('content')
            </div>
        </section>
    </section>
    @extends('vue')
</body>
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('script')
</html> --}}
