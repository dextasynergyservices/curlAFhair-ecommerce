@extends('layouts.app')

@section('content')
<div class="relative h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/hero.png') }}');">
    <div class="absolute inset-0 bg-opacity-50 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-white text-5xl md:text-6xl font-bold mb-4">Welcome to curlAFhair</h1>
        <p class="text-gray-200 text-lg md:text-xl max-w-xl">Your go-to destination for premium hair & beauty products.</p>
        <a href="{{ url('/shop') }}" class="mt-6 inline-block bg-pink-600 text-white px-8 py-3 rounded-full hover:bg-pink-700 transition">Shop Now</a>
    </div>
</div>
@endsection
