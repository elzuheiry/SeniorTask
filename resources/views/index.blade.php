<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config("app.name") }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body>
        {{-- Header --}}
        <header class="fixed top-0 left-0 w-full h-[5rem] bg-[#344E41] flex items-center px-[4rem] justify-end">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ route("dashboard") }}" class="text-sm text-white underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-white underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-white underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        {{-- Side Bar --}}
        <div class="fixed w-[20rem] h-[85vh] bg-[#344E41] top-[6rem] left-[1rem] rounded-[1rem] p-[1rem]">
            <div class="mb-[3rem]">
                <input class=" bg-white outline-none rounded-[0.2rem] w-full text-[0.9rem] border-0" type="text" placeholder="Searching for What..." id="search">
            </div>

            {{-- Categories --}}
            <div class="mb-[1.5rem]" id="categories">
                <h2 class="text-[#f1f1f1] font-[600] text-[1.1rem] mb-[0.5rem]">Categories</h2>

                @foreach ($categories as $category)
                    <label for="{{ "category_" . $category->id }}" id="category" class="flex items-center mb-[0.5rem]">
                        <input id="{{ "category_" . $category->id }}" value="{{ $category->id }}" name="category" type="checkbox" class="mr-[0.5rem]">
                        <span class="capitalize text-[#f1f1f1] text-[0.9rem]">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Brands --}}
            <div class="mb-[1.5rem]">
                <h2 class="text-[#f1f1f1] font-[600] text-[1.1rem] mb-[0.5rem]">Brands</h2>

                @foreach ($brands as $brand)
                    <label for="{{ "brand_" . $brand->id }}" class="flex items-center mb-[0.5rem]">
                        <input id="{{ "brand_" . $brand->id }}" type="checkbox" name="brand" value="{{ $brand->id }}" class="mr-[0.5rem]">
                        <span class="capitalize text-[#f1f1f1] text-[0.9rem]">{{ $brand->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Main Content --}}
        <main class="ml-[22rem] mt-[1rem] mb-[2rem] flex items-center justify-center flex-col">
            <div class="pt-[5rem] grid grid-cols-2 gap-4" id="products">
                @foreach ($products as $product)
                    <div class="w-[15rem] h-[5rem] bg-[#344E41] rounded-[1rem] flex items-center justify-center">
                        <h2 class="text-[1.1rem] capitalize text-[#f1f1f1]">{{ $product->name }}</h2>
                    </div>
                @endforeach
            </div>

            <div class="my-[2rem]">
                {{ $products->links() }}
            </div>
            
        </main>

        <script type="text/javascript">
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>

        <script>
            $(function () {
                // 
                $('#search').on('keyup',function() {
                    var value = $(this).val();

                    $.ajax({
                        type : 'get',
                        url : '{{ route("filter") }}',
                        data: { 'search': value },

                        success:function(response){
                            console.log(value);
                            $("#products").html(response);
                        }
                    });
                })

                // 
                $('input[name="category"]').on('click', function (e) {
                    var categories = [];
                    
                    $('input[name="category"]').each(function()
                    {
                        if($(this).is(":checked")){
                            categories.push($(this).val());
                        }
                    });
                    var finalcategory = categories.toString();

                    $.ajax({
                        type : 'get',
                        url : '{{ route("filter") }}',
                        data: { 'category': finalcategory  },

                        success:function(response){
                            $("#products").html(response);
                        }
                    });
                });

                // 
                $('input[name="brand"]').on('click', function (e) {
                    var brands = [];

                    $('input[name="brand"]').each(function()
                    {
                        if($(this).is(":checked")){
                            brands.push($(this).val());
                        }
                    });
                    var finalbrands = brands.toString();

                    $.ajax({
                        type : 'get',
                        url : '{{ route("filter") }}',
                        data: { 'brand': finalbrands  },

                        success:function(response){
                            $("#products").html(response);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
