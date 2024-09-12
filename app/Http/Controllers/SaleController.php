<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Detail;
use App\Patrones\Fachada;
use App\Repositories\SaleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SaleController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        // formateando fechas
        $dtpInicio = Carbon::now()->startOfDay(); // Usar Carbon para manejar las fechas
        $dtpFinal = Carbon::now()->endOfDay();

        if (!empty($request->txtDesde) && !empty($request->txtHasta)) {
            $dtpInicio = Carbon::createFromFormat('d/m/Y', $request->txtDesde)->startOfDay();
            $dtpFinal = Carbon::createFromFormat('d/m/Y', $request->txtHasta)->endOfDay();
        }

        if (count($input) > 0 && !is_null($request->txtEstado)) {
            $txtBuscar = $request->txtBuscar ?? '';

            $sales = Sale::where('estado', $request->txtEstado)
                ->whereBetween('fecha', [$dtpInicio, $dtpFinal])
                ->where(function ($q) use ($txtBuscar) {
                    $q->where('razon_social', 'like', '%' . $txtBuscar . '%')
                        ->orWhere('numero_ticket', 'like', '%' . $txtBuscar . '%')
                        ->orWhere('nit', 'like', '%' . $txtBuscar . '%');
                })
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $sales = Sale::where('estado', 1)
                ->whereBetween('fecha', [$dtpInicio, $dtpFinal])
                ->orderBy('id', 'desc')
                ->get();
        }

        // Formatear las fechas antes de pasarlas a la vista
        foreach ($sales as $sale) {
            $sale->fecha = Carbon::parse($sale->fecha)->format('d/m/Y H:i:s');
        }

        return view('sales.index')->with('sales', $sales);
    }

    private function ultimo_numero()
    {
        $numero = Sale::all()->max('numero');
        return is_null($numero) ? 0 : $numero;
    }

    private function ultimo_ticket()
    {
        $dtpInicio = Carbon::now()->startOfDay();
        $dtpFinal = Carbon::now()->endOfDay();

        $numero = Sale::whereBetween('fecha', [$dtpInicio, $dtpFinal])->max('numero_ticket');
        return is_null($numero) ? 0 : $numero;
    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param CreateSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleRequest $request)
{
    \DB::beginTransaction();  // Iniciar transacción
    try {
        $input = $request->all();
        $input['fecha'] = Fachada::fechaHoraControlador();
        $input['numero'] = $this->ultimo_numero() + 1;
        $input['numero_ticket'] = $this->ultimo_ticket() + 1;
        $input['estado'] = true;
        $input['nit'] = trim($request->nit);
        $input['users_id'] = \Auth::user()->id;

        Log::info('Datos de venta recibidos:', ['input' => $input]);

        // Si es cliente nuevo
        if (trim($request->clients_id) === "") {
            $input['clients_id'] = $this->save_cliente($request);
        }

        // Crear la venta
        $sale = $this->saleRepository->create($input);

        // Obtener el carrito
        $carrito = $request->input('carrito');
        Log::info('Carrito recibido:', ['carrito' => $carrito]);

        // Guardar cada detalle del carrito
        foreach ($carrito as $detalle) {
            Detail::create([
                'sales_id' => $sale->id,
                'products_id' => (int) $detalle['producto_id'],
                'precio' => (float) $detalle['precio'],
                'cantidad' => (int) $detalle['cantidad'],
            ]);
        }

        \DB::commit();  // Confirmar transacción
        return ['res' => 'Ok', 'sale' => $sale];
    } catch (\Exception $e) {
        \DB::rollBack();  // Deshacer cambios en caso de error
        Log::error('Error al guardar la venta:', ['error' => $e->getMessage()]);
        return response()->json(["error" => "Ha ocurrido un error!", 'e' => $e->getMessage()]);
    }
}


    /**
     * Display the specified Sale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Sale not found');
            return redirect(route('sales.index'));
        }

        // Formatear la fecha antes de mostrarla
        $sale->fecha = Carbon::parse($sale->fecha)->format('d/m/Y H:i:s');

        return view('sales.show')->with('sale', $sale);
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sale = $this->saleRepository->find($id);

        $this->authorize('destroy', $sale);

        if (empty($sale)) {
            Flash::error('Sale not found');
            return redirect(route('sales.index'));
        }

        $sale->estado = !$sale->estado;
        $sale->save();

        if ($sale->estado) {
            Flash::success('Venta restablecida correctamente');
        } else {
            Flash::success('Venta anulada correctamente');
        }

        return redirect(route('sales.index'));
    }

    public function sale_delete($id)
    {
        $sale = $this->saleRepository->find($id);
        $this->saleRepository->delete($id);
        return "Ok";
    }

    /**
     * @param CreateSaleRequest $request
     */
    public function save_cliente(CreateSaleRequest $request)
    {
        $input['nit'] = $request->nit;
        $input['razon_social'] = $request->razon_social;
        $client = Client::create($input);
        return $client->id;
    }
}
