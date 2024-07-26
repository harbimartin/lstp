<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <title>E-Budgeting PT. KBS</title>
    <style>
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
    </style>
</head>
<body>
    <section class="md:flex w-full h-screen bg-gray-200">
        <div class="md:px-6 mx-auto my-auto">
            <div class="rounded-lg shadow md:px-24 py-16 text-center bg-white">
                <div class="md:inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="mx-auto md:mx-0" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <h1 class="text-xl md:text-2xl font-bold pb-2 pl-3 border-gray-200 capitalize">
                        Mohon Maaf, karena kami sedang melakukan maintenance.
                    </h1>
                </div>
                <h1 class="border-b md:text-xl border-gray-200 capitalize text-gray-600">
                    Mohon tunggu beberapa menit kedepan untuk dapat menggunakan E-Budgeting
                </h1>
            </div>
        </div>
    </section>
</body>
