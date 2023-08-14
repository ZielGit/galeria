<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Subir Imagenes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="">
            <div class="bg-white">
                <h1>Subir Imagenes</h1>
                <form action="{{ route('admin.files.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" value="" accept="image/*">
                    @error('file')
                        <small>{{ $message }}</small>
                    @enderror
                    <br><br>
                    <button type="submit" class="btn btn-primary">
                        Subir Imagen
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>