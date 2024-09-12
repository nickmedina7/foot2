@php
    $desde = isset($_GET['txtDesde']) ?  $_GET['txtDesde'] : date("d/m/Y");
    $hasta = isset($_GET['txtHasta']) ?  $_GET['txtHasta'] : date("d/m/Y");
    $buscar = isset($_GET['txtBuscar']) ?  $_GET['txtBuscar'] : null;
    $estado = isset($_GET['txtEstado']) ?  $_GET['txtEstado'] : 1;
@endphp

<div class="row">
    <form id="frmSearch">
        <div class="form-group col-sm-3">
            <label for="txtBuscar">Buscar por:</label>
            <input type="text" name="txtBuscar" value="{{ $buscar }}" class="form-control" placeholder="Nit, Cliente, Numero">
        </div>

        <div class="form-group col-sm-2">
            <label for="txtEstado">Estado:</label>
            <select name="txtEstado" class="form-control">
                @foreach(\App\Patrones\Fachada::estadoVenta() as $key => $value)
                    <option value="{{ $key }}" {{ $estado == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-sm-2">
            <label for="txtDesde">Desde:</label>
            <input type="text" name="txtDesde" value="{{ $desde }}" class="form-control datepicker" autocomplete="off">
        </div>

        <div class="form-group col-sm-2">
            <label for="txtHasta">Hasta:</label>
            <input type="text" name="txtHasta" value="{{ $hasta }}" class="form-control datepicker" autocomplete="off">
        </div>

        <div class="form-group col-sm-3" style="margin-top: 25px">
            <button type="button" class="btn btn-success" @click="print_report('sales')">
                <i class="glyphicon glyphicon-search"></i> Buscar
            </button>
            <button type="button" class="btn btn-default" @click="print_report('reporte_economico')">
                <i class="glyphicon glyphicon-print"></i> Reporte ecónomico
            </button>
        </div>
    </form>
</div>
