@foreach ($products as $product)
    <div class="w-[15rem] h-[5rem] bg-[#344E41] rounded-[1rem] flex items-center justify-center">
        <h2 class="text-[1.1rem] capitalize text-[#f1f1f1]">{{ $product->name }}</h2>
    </div>
@endforeach