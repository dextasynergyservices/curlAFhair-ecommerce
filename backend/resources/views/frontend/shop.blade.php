@extends('layouts.app')

@section('content')
<div class="relative h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-center md:px-10 px-10">
        <h1 class="text-white text-5xl md:text-6xl font-bold mb-4 animate-slideInRight">Dry curls?</h1>
        <p class="text-gray-200 text-lg max-w-xl animate-slideInLeft ">We say no to having hair that’s not moisturized. Our products are uniquely formulated to tackle the 3 ingredients of a bad Hair day.</p>
        <a href="{{ url('/shop') }}" class="mt-6 inline-block bg-[#000000] text-white px-8 py-3 rounded-full hover:bg-pink-700" id="shopButton">Shop Now</a>
    </div>
</div>

<!-- Header Section-->
<div class="flex justify-center">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 px-4 py-12 max-w-6xl w-full items-center">
    <!-- Text on left, image on right -->
    <div class="flex flex-col justify-center space-y-4">
      <h2 class="text-2xl font-bold">Heading</h2>
      <p class="text-gray-600">A subheading for this section, as long or as short as you like</p>
      <div class="flex space-x-4">
        <button class="bg-black text-white px-4 py-2 rounded">Button</button>
        <button class="bg-gray-100 text-black px-4 py-2 rounded">Secondary button</button>
      </div>
    </div>
    <div>
      <img src="/images/heading-1.png" alt="pears" class="rounded-lg w-full mx-auto object-cover">
    </div>

    <!-- Image on left, text on right -->
    <div>
      <img src="/images/heading-2.png" alt="watermelon" class="rounded-lg w-full mx-auto object-cover">
    </div>
    <div class="flex flex-col justify-center space-y-4">
      <h2 class="text-2xl font-bold">Heading</h2>
      <p class="text-gray-600">A subheading for this section, as long or as short as you like</p>
      <div class="flex space-x-4">
        <button class="bg-black text-white px-4 py-2 rounded">Button</button>
        <button class="bg-gray-100 text-black px-4 py-2 rounded">Secondary button</button>
      </div>
    </div>
  </div>
</div> <!-- End Of Header Section -->

<!-- Section Heading -->
<section class="max-w-6xl mx-auto px-6 py-12">
  <h2 class="text-3xl font-bold mb-8">Section heading</h2>
  
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Featured product -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-lg overflow-hidden">
      <img src="/images/featured.jpeg" alt="Featured product" class="w-full h-[500px] object-cover rounded-lg">
        <div class="mt-4">
          <h3 class="font-semibold text-lg">Featured product</h3>
          <p class="text-gray-500 text-sm">Description of featured product</p>
          <p class="mt-1 font-bold">$10.99</p>
        </div>
      </div>
    </div>

    <!-- Right stacked products -->
    <div class="space-y-8">
      <div class="bg-white rounded-lg overflow-hidden">
        <img src="/images/top.jpeg" alt="Product" class="w-full h-[160px] object-cover rounded-lg">
        <div class="mt-3">
          <h4 class="font-semibold">Product</h4>
          <p class="text-gray-500 text-sm">Description of top product</p>
          <p class="mt-1 font-bold">$10.99</p>
        </div>
      </div>

      <div class="bg-white rounded-lg overflow-hidden">
        <img src="/images/bottom.jpeg" alt="Product" class="w-full h-[160px] object-cover rounded-lg">
        <div class="mt-3">
          <h4 class="font-semibold">Product</h4>
          <p class="text-gray-500 text-sm">Description of lower product</p>
          <p class="mt-1 font-bold">$10.99</p>
        </div>
      </div>
    </div>
  </div>
</section> <!-- End Of Header Section -->

<!--  Header Section -->
<section class="max-w-6xl mx-auto px-6 py-12">
  <h2 class="text-3xl font-bold mb-10">Section heading</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- Item -->
    <div class=" items-start">
        
            <i class="fas fa-globe text-black-100 text-xl mt-1"></i>
        
        <div>
        <h3 class="font-semibold text-lg">Subheading</h3>
        <p class="text-gray-500 text-sm">Body text for whatever you'd like to say. Add main takeaway points, quotes, anecdotes, or even a very very short story.</p>
      </div>
    </div>

    <!-- Item -->
    <div class="items-start ">
      <i class="fas fa-user-circle text-black text-xl mt-1"></i>
      <div>
        <h3 class="font-semibold text-lg">Subheading</h3>
        <p class="text-gray-500 text-sm">Body text for whatever you'd like to suggest. Add main takeaway points, quotes, anecdotes, or even a very very short story.</p>
      </div>
    </div>

    <!-- Item -->
    <div class="items-start">
      <i class="fas fa-lock text-black text-xl mt-1"></i>
      <div>
        <h3 class="font-semibold text-lg">Subheading</h3>
        <p class="text-gray-500 text-sm">Body text for whatever you'd like to claim. Add main takeaway points, quotes, anecdotes, or even a very very short story.</p>
      </div>
    </div>

    <!-- Item -->
    <div class="items-start">
    <i class="fas fa-calendar-alt text-black text-xl mt-1"></i>
      <div>
        <h3 class="font-semibold text-lg">Subheading</h3>
        <p class="text-gray-500 text-sm">Body text for whatever you'd like to type. Add main takeaway points, quotes, anecdotes, or even a very very short story.</p>
      </div>
    </div>
  </div>
</section>



@endsection