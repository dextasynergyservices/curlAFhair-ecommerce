@extends('layouts.app')

@section('content')
<div class="relative h-[20vh] bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}');bg-black bg-opacity-30">
    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-center md:px-10 px-10"></div>
</div>

<section class="grid grid-cols-1 lg:grid-cols-2 gap-12 px-4 py-12 max-w-6xl w-full mx-auto">
    <div>
      <img src="/images/product1.jpg" alt="product" class="rounded-lg w-[600px] h-[500px] mx-auto object-cover">
    </div>
    <div class="flex flex-col space-y-4">
      <h2 class="text-2xl font-bold">Product name</h2>
      <h3 class="text-lg text-gray-600 mb-3">Subheading</h3>

      <p class="text-xl font-semibold text-gray-900 mb-4">$10.99</p>

      <p class="text-gray-700 mb-6">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos velit repellat, repellendus animi cum inventore vel atque odio quod enim explicabo possimus, quasi in itaque qui sapiente ab assumenda similique?
    </p>
    <button class="w-full bg-black hover:bg-pink-400 text-white font-bold py-2 px-4 rounded mb-4">
      Add to cart
    </button>
    
    <div class="text-xs text-gray-500 border-t pt-4">
      Text box for additional details or fine print
    </div>

    </div>
  </div>
</div>
</section>

<section class="px-4 py-12 max-w-6xl w-full mx-auto">
    <h2 class="text-2xl font-bold pb-4">Related Products</h2>
    <!-- first card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12  ">
        <div>
            <div>
                <img src="/images/related1.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>

        <!-- second card -->
        <div>
            <div>
                <img src="/images/related2.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>

        <!-- third card -->
        <div>
            <div>
                <img src="/images/related3.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>

        <!-- fourth card -->
        <div>
            <div>
                <img src="/images/related4.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>

        <!-- fifht card -->
        <div>
            <div>
                <img src="/images/related5.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>

        <!-- sixth card -->
        <div>
            <div>
                <img src="/images/related6.jpg" alt="product" class="rounded-lg w-[400px] h-[350px] mx-auto object-cover">
            </div>
            <p class='mt-4 mb-1'>Product</p>
            <p class='mb-1 text-gray-500'>Description of product</p>
            <p>$10.99</p>
        </div>
    </div>
</section>

<hr>
@endsection