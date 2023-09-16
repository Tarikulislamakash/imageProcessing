{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('master')

@section('content')
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Image Processing</a>
        </li>
      </ul>
      <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-primary" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>

    <div class="container mt-5">
        @if (auth()->user()->image)
            <div class="row d-flex justify-content-center mb-4">
                <div class="col-md-3">
                    <h4>Orginal Image</h4>
                    <img class="img-thumbnail" src="{{ asset('/storage/images' . '/' . auth()->user()->id . '/' . auth()->user()->image->orginal_image) }}" alt="">
                </div>
                <div class="col-md-3">
                    <h4>Small Image</h4>
                    <img class="img-thumbnail" src="{{ asset('/storage/images' . '/' . auth()->user()->id . '/' . auth()->user()->image->small_image) }}" alt="">
                </div>
                <div class="col-md-3">
                    <h4>Large Image</h4>
                    <img class="img-thumbnail" src="{{ asset('/storage/images' . '/' . auth()->user()->id . '/' . auth()->user()->image->large_image) }}" alt="">
                </div>
            </div>
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                @if (Session::has('uploadImage'))
                    <div class="text-success">
                        {{ Session::get('uploadImage') }}
                    </div>
                @endif
                <form method="post" id="imageProcess" action="{{ route('image-process') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image for image processing.</label>
                        <input type="file" name="image" class="form-control" id="image" aria-describedby="image">
                    </div>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <button type="button" class="btn btn-primary mt-3" id="imageProcessBtn" onclick="submitForm();">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function submitForm() {
            document.getElementById('imageProcess').submit();
        }
    </script>
@endsection