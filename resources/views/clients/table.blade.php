<div class="table-responsive">
    <table class="table" id="clients-table">
        <thead>
            <tr>
                <th>Nit</th>
                <th>Razón Social</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->nit }}</td>
                <td>{{ $client->razon_social }}</td>
                <td>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                        @csrf
                        @method('DELETE')
                        <div class='btn-group'>
                            <a href="{{ route('clients.edit', [$client->id]) }}" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
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
