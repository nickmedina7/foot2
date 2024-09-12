@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Producto
        </h1>
   </section>
   <div class="content">
       @if ($errors->any())
           <div class="alert alert-danger">
               <ul>
                   @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           </div>
       @endif
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       @method('PATCH')

                       @include('products.fields')

                       <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                       <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection
