<div class="table-responsive">
    <table class="table table-bordered" id="sales-table">
        <thead>
        <tr>
            <th>Número <br> de Ticket</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total [Bs]</th>
            <th>Registrado <br>por</th>
            <th>Estado</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
        @endphp
        @foreach($sales as $sale)
            <tr>
                <td><strong>{{ $sale->numero_ticket }}</strong></td>
                <td style="width:100px">{{ date('d/m/Y H:i:s', strtotime($sale->fecha)) }}</td>
                <td>
                    {{ $sale->clients->razon_social }} <br>
                    <small class="text-muted">Nit: {{ $sale->clients->nit}}</small>
                </td>
                <td class="text-right"><strong>{{ $sale->total }}</strong></td>
                <td><span class="text-muted">{{ $sale->users->email }}</span></td>
                <td>
                    @if($sale->estado)
                        <span class="label label-success">Activo</span>
                    @else
                        <span class="label label-danger">Anulado</span>
                    @endif
                </td>
                <td style="width: 230px">
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Estas seguro?')">
                        @csrf
                        @method('DELETE')
                        <div class='btn-group'>
                            <a href="{{ route('sales.show', [$sale->id]) }}" title="Detalle de la venta"
                               class='btn btn-primary btn-xs'><i class="glyphicon glyphicon-eye-open"></i> Detalle de la
                                venta</a>

                            @can('destroy', $sale)
                                @if(date('d/m/Y', strtotime($sale->fecha)) === date('d/m/Y'))
                                    @if ($sale->estado)
                                        <button type="submit" class="btn btn-danger btn-xs" title="Anular">
                                            <i class="glyphicon glyphicon-trash"></i> Anular
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-xs" title="Restablecer">
                                            <i class="glyphicon glyphicon-arrow-up"></i> Restablecer
                                        </button>
                                    @endif
                                @endif
                            @endcan
                        </div>
                    </form>
                </td>
            </tr>
            @php
                $total += $sale->total;
            @endphp
        @endforeach
        </tbody>
    </table>
</div>

<div class="col-sm-12 text-right">
    <h4><strong>Total vendido [Bs]: {{ round($total, 2) }}</strong></h4>
</div>
