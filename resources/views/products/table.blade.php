<div class="table-responsive">
    <table class="table table-bordered table-striped" id="products-table">
        <thead>
        <tr>
            <th>Categoría</th>
            <th>Nombre</th>
            <th>Precio [Bs]</th>
            <th>Imagen</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->categoria }}</td>
                <td>{{ $product->nombre }}</td>
                <td>{{ $product->precio }}</td>
                <td>
                    <img class="img img-thumbnail" src="{{ asset('/images_products/'. $product->fotografia) }}" alt="images" width="100px" style="max-width: 100%; max-height: 40%;">
                </td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                        @csrf
                        @method('DELETE')
                        <div class='btn-group'>
                            <a href="{{ route('products.show', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{{ route('products.edit', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            <button type="submit" class="btn btn-danger btn-xs">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
