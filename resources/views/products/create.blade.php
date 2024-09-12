@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nuevo Producto
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
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('products.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
