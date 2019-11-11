<?php

namespace Agenciafmd\Addresses\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Agenciafmd\Addresses\Address;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Address::class)
            ->defaultSorts(config('local-addresses.default_sort'))
        ->allowedFilters((($request->filter) ? array_keys($request->get('filter')) : []));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/addresses::index', $view);
    }

    public function create(Address $address)
    {
        $view['model'] = $address;

        return view('agenciafmd/addresses::form', $view);
    }

    public function store(Request $request)
    {
        if (Address::create($request->all())) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
    }

    public function show(Address $address)
    {
        $view['model'] = $address;

        return view('agenciafmd/addresses::form', $view);
    }

    public function edit(Address $address)
    {
        $view['model'] = $address;

        return view('agenciafmd/addresses::form', $view);
    }

    public function update(Address $address, Request $request)
    {
        if ($address->update($request->all())) {
            flash('Item atualizado com sucesso.', 'success');
        } else {
            flash('Falha na atualização.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
    }

    public function destroy(Address $address)
    {
        if ($address->delete()) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

            return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
        }

    public function restore($id)
    {
        $model = Address::onlyTrashed()
            ->find($id);

        if (!$model) {
            flash('Item já restaurado.', 'danger');
        } elseif ($model->restore()) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
    }

    public function batchDestroy(Request $request)
    {
        if (Address::destroy($request->get('id', []))) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
    }

    public function batchRestore(Request $request)
    {
        $model = Address::onlyTrashed()
            ->whereIn('id', $request->get('id', []))
            ->restore();

        if ($model) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.addresses.index');
    }
}
