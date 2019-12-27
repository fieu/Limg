@extends('layouts.app')

@section('content')

@isNotPublic($image)

<div class="container mx-auto lg:w-1/3 w-1/2">
  <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1 pr-3">
        <i class="fas fa-info-circle fa-2x"></i>
      </div>
      <div>
        <p class="font-bold">This image is private</p>
        <p class="text-sm">The user has chosen to put his image in private.</p>
      </div>
    </div>
  </div>
</div>
@else 

<div class="sm:container sm:mx-auto bg-white shadow-md rounded-lg sm:w-full max-w-6xl px-8 pt-6 pb-8 mx-4">
  @if ($image->title != null)
      <h3 class="text-4xl mb-4">{{ $image->title }}</h3>
  @endif
  @ownsImage($image)
    <form role="form" method="POST" action="{{ route('image.infos', ['image' => $image->name]) }}">
      @csrf
      <div class="sm:flex sm:items-center my-6">
        <label class="mr-4">
          <input type="text" name="title" value="{{ $image->title }}" placeholder="Give a title to your image" 
          class="appearance-none block w-64 text-gray-700 py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        </label>
        <label class="custom-label flex sm:mx-4">
          <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
            <input type="checkbox" class="hidden" name="is_public" value="{{ $image->is_public ? '1' : '0' }}" {{ $image->is_public ? 'checked' : '' }}>
            <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
          </div>
          <span class="text-gray-700"> {{ __('Public') }}</span>
        </label>  
        <button class="shadow bg-indigo-700 hover:bg-indigo-800 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 sm:mx-4 sm:mt-0 mt-4 rounded" type="submit">
          <i class="fas fa-save"></i> Save
        </button>
        <a href="#" class="shadow bg-red-700 hover:bg-red-800 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 sm:mx-4 sm:mt-0 mt-4 rounded" onclick="deleteImage()">
          <i class="fas fa-trash-alt"></i> Delete
        </a>
      </div>
    </form>

  @endownsImage

  <div class="sm:flex sm:flex-row">
    <div class="sm:w-3/4">
      <div class="relative flex items-center justify-center sm:min-h-12 max-w-full overflow-hidden bg-gray-100 rounded shadow">
        <img src="{{ route('image.show', ['image' => $image->fullname]) }}">
      </div>
    </div>
    <div class="sm:ml-16 sm:my-0 my-6">
      <h3 class="text-gray-900 text-2xl font-medium font-firacode pb-3">Image Tools</h3>
      <a href="{{ route('image.download', ['image' => $image->name]) }}">
        <button class="bg-transparent hover:bg-gray-600 text-gray-900 font-semibold hover:text-white w-36 block py-2 px-4 mb-4 border border-grey hover:border-transparent rounded">
          <i class="fa fa-download"></i> Download
        </button>
      </a>
      <button class="modal-open-embed bg-transparent hover:bg-gray-600 text-gray-900 font-semibold hover:text-white w-36 block py-2 px-4 my-4 border border-grey hover:border-transparent rounded">
        <i class="fas fa-code"></i> Embed
      </button>
      <button class="bg-transparent hover:bg-gray-600 text-gray-900 font-semibold hover:text-white w-36 block py-2 px-4 my-4 border border-grey hover:border-transparent rounded">
        <i class="fas fa-globe-europe"></i> BBCode
      </button>
    </div>
  </div>

</div>
@include('image.modal')
@endisNotPublic
@endsection

@section('javascripts')
<script>
function deleteImage() {
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this imaginary file!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      window.location = "{{ route('image.delete', ['image' => $image->name]) }}";
    }
  });
}
</script>
@endsection