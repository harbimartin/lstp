@extends('index', ['on'=>$on])

@section('content')
    {{-- <?php
        $menus = [
            [ 'tag'=>'dpt', 'nama'=> 'Approval DPT', 'color'=>'gray'],
            [ 'tag'=>'aanwijzing', 'nama'=> 'Approval Aanwijzing', 'color'=>'gray'],
            [ 'tag'=>'coq', 'nama'=> 'COQ Approval', 'color'=>'gray'],
            [ 'tag'=>'cob', 'nama'=> 'COB Approval', 'color'=>'gray'],
            [ 'tag'=>'ba_nego', 'nama'=> 'Approval Berita Acara Negosiasi', 'color'=>'gray']
        ]
    ?>
    <div class="grid gap-1 md:gap-3 px-2 md:px-4 mt-2 md:mt-5 grid-cols-1 md:grid-cols-2 lg:grid-cols-{{sizeof($menus)}}">
        @foreach ($menus as $menu)
            <a class="relative h-42 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out group cursor-pointer flex"
                href="{{url($menu['tag'])}}"
            style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');">
                <div class="absolute inset-0 bg-{{$menu['color']}}-700 group-hover:bg-{{$menu['color']}}-700 bg-opacity-60 transition duration-300 ease-in-out"></div>
                <div class="relative px-4 md:px-8 py-2 md:py-3 flex items-center text-sm md:text-xl my-auto w-full">
                        <h3 class="text-white font-semibold md:font-bold">
                            {!! $menu['nama'] !!}
                        </h3>
                        <div class="flex space-x-4 ml-auto mr-1">
                            <div class="block uppercase mx-auto shadow focus:shadow-outline focus:outline-none text-white bg-black bg-opacity-40 text-base md:text-xl py-0.5 md:py-3 px-3 md:px-5 rounded-full font-semibold md:font-bold">
                                {{$_SESSION['eproc_'.$menu['tag']]}}
                            </div>
                        </div>
                </div>
            </a>
        @endforeach
    </div>
    @yield('notif_list') --}}
@endsection
