<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <title>Savior Game Admin</title>
</head>
<body>
    <section class="logins">
        <div class="flex justify-center items-center h-screen">
            <div class="p-4 rounded-md shadow-xl border md:w-2/6 w-full md:mx-0 mx-2">
                <h2 class="font-bold text-center text-lg">Login E-Budgeting</h2>
                <form class="w-full mt-10" action="/user/login" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="block text-gray-700 text-sm font-sans font-semibold mb-2" for="nik">NIK</label>
                        <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded pb-2 pt-1 px-2 text-gray-700 leading-tight focus:outline-none text-sm w-full focus:bg-white focus:border-blue-400 form-control" id="nik" type="text" name="nik" placeholder="Masukan nik">
                    </div>
                    @if($errors->has('nik'))
                        <span class="font-semibold -top-3 text-xs text-red-500">{{$errors->first('nik')}}</span>
                    @endif
                    <div class="mt-4 form-group">
                        <label class="block text-gray-700 text-sm font-sans font-semibold mb-2" for="password">Password</label>
                        <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded pb-2 pt-1 px-2 text-gray-700 leading-tight focus:outline-none text-sm w-full focus:bg-white focus:border-blue-500 form-control" id="password" name="password" type="password" placeholder="Masukan password">
                    </div>
                    @if($errors->has('password'))
                        <span class="font-semibold -top-3 text-xs text-red-500">{{$errors->first('password')}}</span>
                    @endif
                    <button type="submit" class="bg-blue-500 rounded-md text-white font-semibold text-md w-full py-1 mt-5">Masuk</button>
                </form>
            </div>
        </div>
        {{-- @if($message = Session::get('failure'))
        <div class="container mx-auto transition duration-500 ease-in-out fixed top-3 z-10 right-2">
            <div class="max-w-sm flex justify-start ml-auto px-5 bg-red-100 py-2 text-red-500 rounded-md font-semibold text-sm" role="alert">
                <p>{{$message}}</p>
                <i class="fa fa-times text-xs cursor-pointer ml-auto my-auto"></i>
            </div>
        </div>
        @endif --}}
    </section>
</body>
</html>
