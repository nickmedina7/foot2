<!-- Nit Field -->
<div class="form-group col-sm-12">
    <label for="nit">Nit: *</label>
    <input type="text" name="nit" id="nit" class="form-control" required>
</div>

<!-- Razon Social Field -->
<div class="form-group col-sm-12">
    <label for="razon_social">Razón Social: *</label>
    <input type="text" name="razon_social" id="razon_social" class="form-control" required>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('clients.index') }}" class="btn btn-default">Cancelar</a>
</div>
