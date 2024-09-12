@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Cliente
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
                   <form action="{{ route('clients.update', $client->id) }}" method="POST">
                       @csrf
                       @method('PATCH')

                       @include('clients.fields')

                       <button type="submit" class="btn btn-primary">Guardar</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection
