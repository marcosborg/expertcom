<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFormAssemblyRequest;
use App\Http\Requests\StoreFormAssemblyRequest;
use App\Http\Requests\UpdateFormAssemblyRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormAssemblyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('form_assembly_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.formAssemblies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('form_assembly_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.formAssemblies.create');
    }

    public function store(StoreFormAssemblyRequest $request)
    {
        $formAssembly = FormAssembly::create($request->all());

        return redirect()->route('admin.form-assemblies.index');
    }

    public function edit(FormAssembly $formAssembly)
    {
        abort_if(Gate::denies('form_assembly_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.formAssemblies.edit', compact('formAssembly'));
    }

    public function update(UpdateFormAssemblyRequest $request, FormAssembly $formAssembly)
    {
        $formAssembly->update($request->all());

        return redirect()->route('admin.form-assemblies.index');
    }

    public function show(FormAssembly $formAssembly)
    {
        abort_if(Gate::denies('form_assembly_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.formAssemblies.show', compact('formAssembly'));
    }

    public function destroy(FormAssembly $formAssembly)
    {
        abort_if(Gate::denies('form_assembly_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $formAssembly->delete();

        return back();
    }

    public function massDestroy(MassDestroyFormAssemblyRequest $request)
    {
        $formAssemblies = FormAssembly::find(request('ids'));

        foreach ($formAssemblies as $formAssembly) {
            $formAssembly->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
