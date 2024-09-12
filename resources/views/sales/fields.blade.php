<!-- Nit Field -->
<div class="form-group col-sm-12">
    <label for="nit">Nit: *</label>
    <input type="number" name="nit" id="nit" class="form-control" required maxlength="15" 
        @keypress.enter="getClientes($event)" @blur="getClientes($event)">
</div>

<!-- Razon Social Field -->
<div class="form-group col-sm-12">
    <label for="razon_social">Razón Social: *</label>
    <input type="text" name="razon_social" id="razon_social" class="form-control" maxlength="50" 
        required autocomplete="off">
</div>

<!-- Concepto Field -->
<div class="form-group col-sm-12 col-lg-12">
    <label for="concepto">Concepto:</label>
    <input type="text" name="concepto" id="concepto" class="form-control" required>
    <hr>
</div>

<input type="hidden" name="clients_id" id="clients_id" class="form-control">

@include('sales.carrito')

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Finalizar venta e imprimir recibo</button>
    <a href="{{ route('sales.index') }}" class="btn btn-default" onclick="return confirm('Seguro que quieres cancelar esta venta\nLos cambios realizados no se guardarán')">Cancelar</a>
</div>
