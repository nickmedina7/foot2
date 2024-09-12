<div class="col-sm-8">
    <!-- Categoria Field -->
    <div class="form-group col-sm-12">
        <label for="categoria">Categoría: *</label>
        <select name="categoria" class="form-control" required>
            @foreach(\App\Patrones\Fachada::categoriasProducto() as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <!-- Nombre Field -->
    <div class="form-group col-sm-8">
        <label for="nombre">Nombre: *</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <!-- Precio Field -->
    <div class="form-group col-sm-4">
        <label for="precio">Precio: [Bs] *</label>
        <input type="number" name="precio" class="form-control" required min="1" max="5000" step="any">
    </div>
</div>

<div class="col-sm-4">
    <!-- Imagen Field -->
    <div class="thumbnail">
        @if(isset($product) && isset($product->fotografia))
            <img id="img_destino" src="{{ asset('/images_products/'.$product->fotografia) }}" alt="foto">
        @else
            <img id="img_destino" src="{{ asset('/images_products/imagen_base.png') }}" alt="foto">
        @endif

        <div class="caption text-center">
            <div class="foto_boton file btn btn-lg btn-primary">
                <i class="glyphicon glyphicon-paperclip"></i> Cargar Imagen
                <input id="foto_input" class="foto_input" type="file" name="foto_input" accept="image/*"/>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
</div>
