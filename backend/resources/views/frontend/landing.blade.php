@extends('layouts.app')

@section('content')
<div class="relative h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/hero.png') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-start text-left md:px-10 px-10">
        <h1 class="text-white text-5xl md:text-6xl font-bold mb-4 animate-slideInRight">Dry curls?</h1>
        <p class="text-gray-200 text-lg max-w-xl animate-slideInLeft">We say no to having hair that’s not moisturized. Our products are uniquely formulated to tackle the 3 ingredients of a bad Hair day:

        Dry Hair - leads to breakage, split ends, unmanageable hair and rough hair
        Frizz - leads to hair that can be out of control
        Tangles - leads to fairy knots and breakage .</p>
        <a href="{{ url('/shop') }}" class="mt-6 inline-block bg-pink-600 text-white px-8 py-3 rounded-full hover:bg-pink-700" id="shopButton">Shop Now</a>
    </div>
</div>


<!-- shop items section -->
<section class="py-12 px-4 md:px-20 bg-white">
  <div class="container mx-auto">
    <!-- Header -->
    <h1 class="text-2xl font-semibold mb-8 md:mt-12">
      <span class="font-bold text-black">Shop</span> <span class="text-gray-600">| buy our moisturising solution</span>
    </h1>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Product Card 1-->
      <div class="bg-white overflow-hidden md:w-[400px]">
        <img src="/images/card1.png" alt="Deep Conditioner" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Deep Conditioner</h3>
          <p class="text-gray-600 text-sm">NGN12,000 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN20,000 / 500ml</p>
        </div>
      </div>

      <!-- Product Card 2-->
      <div class="bg-white rounded-lg overflow-hidden md:w-[400px">
        <img src="/images/card2.png" alt="Curl Definer" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Curl Definer</h3>
          <p class="text-gray-600 text-sm">NGN11,000 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN18,000 / 500ml</p>
        </div>
      </div>

      <!-- Product Card 3-->
      <div class="bg-white rounded-lg overflow-hidden md:w-[400px]">
        <img src="/images/card3.png" alt="Hair Butter" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Hair Butter</h3>
          <p class="text-gray-600 text-sm">NGN11,500 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN19,000 / 500ml</p>
        </div>
      </div>

      <!-- Product Card 4-->
      <div class="bg-white overflow-hidden md:w-[400px]">
        <img src="/images/card1.png" alt="Deep Conditioner" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Deep Conditioner</h3>
          <p class="text-gray-600 text-sm">NGN12,000 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN20,000 / 500ml</p>
        </div>
      </div>

      <!-- Product Card 5-->
      <div class="bg-white rounded-lg overflow-hidden md:w-[400px">
        <img src="/images/card2.png" alt="Curl Definer" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Curl Definer</h3>
          <p class="text-gray-600 text-sm">NGN11,000 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN18,000 / 500ml</p>
        </div>
      </div>

      <!-- Product Card 6-->
      <div class="bg-white rounded-lg overflow-hidden md:w-[400px]">
        <img src="/images/card3.png" alt="Hair Butter" class="w-full h-[400px] object-cover rounded-lg ">
        <div class="p-4">
          <h3 class="text-lg font-semibold">Hair Butter</h3>
          <p class="text-gray-600 text-sm">NGN11,500 / 300ml</p>
          <p class="text-gray-600 text-sm ">NGN19,000 / 500ml</p>
        </div>
      </div>


    </div>
  </div>
</section> <!-- End Of Shop item section -->

<!-- About Section -->
<section class="w-full min-h-screen bg-[#FFEBEA] py-12 px-4 md:px-20 ">
  <div class=" max-w-none w-full mx-auto">
  <h1 class="text-2xl font-semibold mb-8 md:mt-12">
      <span class="font-bold text-black">Citizenship</span> <span class="text-gray-600">| join planet af solution</span>
    </h1>
    <h2 class="text-center text-lg mb-8">First Things First, Who are We?</h2>
    <h2 class="text-xl font-semibold italic  mb-8">About Us</h2>

    <div class="text-lg mx-auto">
      <p class="mb-6">A young woman decided to stop relaxing her hair. At the age of 17, she noticed her hair was browning and suffering from breakage. The last time she saw her natural hair was when she was only 5. She wanted to remember what her hair looked like.</p>

      <p class="mb-6">This was 2010, when it seemed as if there was a movement against relaxers towards natural hair. Chris Rock had also recently come out with his "Good Hair" movie. The timing felt right.</p>

      <p class="mb-6">This product is for the women who want curly and fabulous hair. Who want to enjoy their God-given hair without wondering if our hair is just "bad". No, your hair is not bad. You've just not found the right moisturiser yet!</p>
    </div>
    <p class="text-center font-bold text-lg">what’s PLANET AF?</p>
  </div>
</section> <!-- End of About Section -->

<section
  class="w-full min-h-screen h-screen py-12 px-4 md:px-20"
  style="background-image: url({{ asset('images/galaxy.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center;"
>
</section>

<!-- Planet Section -->
<section class="w-full min-h-screen bg-[#FFEBEA] py-12 px-4 md:px-20 relative overflow-hidden">
  <h2 class="uppercase font-bold italic text-xl md:text-lg mb-8 md:mt-12">Be a citizen of a unique planet</h2>
  <p class="italic text-xl md:text-lg mx-auto mb-8">In a galaxy where we are building a community of people who love their hair. This is a whole civilisation where we build a virtual planet just for us!</p>
  <button class="bg-[#FF7A76] text-white px-4 py-2 rounded-lg hover:bg-sky-700">join</button>

  <img
    src="/images/space.png"
    alt="space man"
    class="absolute w-[150px] w-[600px] md:w-[700px] lg:w-[900px] xl:w-[1080px] "
    style="bottom: -10%; left: 30%;"
  >
</section> <!--End of Planet Section -->

<!-- Review section -->
<section class="w-full min-h-screen bg-white py-12 px-4 md:px-20 relative overflow-hidden">
<h2 class=" text-2xl font-semibold mb-8 md:mt-12">Review</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

<!-- Card 1 -->
<div class="bg-white overflow-hidden w-[400px] h-[200px] rounded border py-5 px-10">
  <h3 class="text-lg my-8">“A terrific piece of praise”</h3>
  <div class="flex flex-row items-center gap-x-4">
    <img src="/images/review1.png" alt="review" class="w-[45px] h-[45px] rounded-full">
    <div>
      <h5 class="font-semibold">Name</h5>
      <p class="text-sm text-gray-500">Description</p>
    </div>
  </div>
</div>

<!-- Card 2 -->
<div class="bg-white overflow-hidden w-[400px] h-[200px] rounded border py-5 px-10">
  <h3 class="text-lg my-8">“A terrific piece of praise”</h3>
  <div class="flex flex-row items-center gap-x-4">
    <img src="/images/review2.png" alt="review" class="w-[45px] h-[45px] rounded-full">
    <div>
      <h5 class="font-semibold">Name</h5>
      <p class="text-sm text-gray-500">Description</p>
    </div>
  </div>
</div>

<!-- Card 3 -->
<div class="bg-white overflow-hidden w-[400px] h-[200px] rounded border py-5 px-10">
  <h3 class="text-lg my-8">“A terrific piece of praise”</h3>
  <div class="flex flex-row items-center gap-x-4">
    <img src="/images/review3.jpg" alt="review" class="w-[45px] h-[45px] rounded-full">
    <div>
      <h5 class="font-semibold">Name</h5>
      <p class="text-sm text-gray-500">Description</p>
    </div>
  </div>
</div>

</div>
</section>

<hr>
@endsection
