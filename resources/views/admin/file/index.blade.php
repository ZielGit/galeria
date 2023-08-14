<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Ver Imagenes') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row">
            @foreach ($files as $file)
                <div class="col-4">
                    <div class="card">
                        <img class="img-fluid" src="{{asset($file->url)}}" alt="">
                        <div class="card-footer">
                            <a href="{{route('admin.files.edit', $file)}}" class="btn btn-primary">Editar</a>
                            <form action="{{route('admin.files.destroy', $file)}}" class="d-inline frmEliminar" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" wire:click="$emit('deletePost', {{$file->id}})">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12">
                {{$files->links()}}
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- se agrego jquery para que funcione sweetalert2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.frmEliminar').submit(function(e){
            e.preventDefault();

            Swal.fire({
                title:'¿Estas Seguro?',
                text:'¡No podrás revertir esto!',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, bórralo!'
            }).then((result) =>{
                if(result.value){
                    this.submit();
                }
            })
        })
    </script>
    @endpush
</x-app-layout>
