<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FormName;
use App\Models\Driver;
use App\Models\VehicleItem;
use App\Models\User;

class FormCommunicationController extends Controller
{
    // LISTA plana (já usado pela app)
    public function index()
    {
        $userRoles = auth()->user()->roles->pluck('id')->toArray();

        $forms = FormName::whereHas('roles', fn($q) => $q->whereIn('id', $userRoles))
            ->with(['form_inputs' => fn($q) => $q->orderBy('position')])
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $forms]);
    }

    // DETALHE + opções (drivers, matrículas, técnicos), conforme os flags do form
    public function show($id)
    {
        $form = FormName::with(['form_inputs' => fn($q) => $q->orderBy('position')])->findOrFail($id);

        $out = ['data' => $form];

        if ($form->has_driver) {
            $out['drivers'] = Driver::where('state_id', 1)->orderBy('name')->get(['id', 'name']);
        }
        if ($form->has_license) {
            $out['vehicle_items'] = VehicleItem::orderBy('license_plate')->get(['id', 'license_plate']);
        }
        if ($form->has_technician) {
            $out['technicians'] = User::whereHas('roles', fn($q) => $q->where('title', 'Técnico'))
                ->orderBy('name')->get(['id', 'name']);
        }

        return response()->json($out);
    }

    // UPLOAD (equivalente ao route('admin.form-assemblies.store-media')) — devolve { name }
    public function storeMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,heic,avif|max:10240', // 10MB
        ]);

        $path = $request->file('file')->store('tmp/uploads'); // storage/app/tmp/uploads/xxxx
        return response()->json([
            'name' => basename($path),
            'path' => $path, // opcional
        ]);
    }

    // SUBMISSÃO (sem criar nada novo): delega para o método que já tens no BO
    public function submit(Request $request)
    {
        $data = $request->validate([
            'form_name_id'    => 'required|exists:form_names,id',
            'driver_id'       => 'nullable|exists:drivers,id',
            'vehicle_item_id' => 'nullable|exists:vehicle_items,id',
            'user_id'         => 'nullable|exists:users,id',
            'inputs'          => 'required|array', // { "Matricula do carro?": "AA-00-BB", ... } ou com 'name'
            'photos'          => 'nullable|array', // { [form_input_id]: [ "filename1","filename2" ] }
            'photos.*'        => 'array',
        ]);

        // 1) Converter o payload para o MESMO formato que o formulário do BO envia
        //    - campos dinâmicos pelo "label" (ou 'name' se for o que o BO espera)
        //    - campos hidden 'photos-<form_input_id>' com nomes separados por vírgula
        $forward = [
            'form_name_id'    => $data['form_name_id'],
            'driver_id'       => $data['driver_id']       ?? null,
            'vehicle_item_id' => $data['vehicle_item_id'] ?? null,
            'user_id'         => $data['user_id']         ?? null,
        ];

        // Inputs dinâmicos: chaves iguais às usadas no Blade (lá usas o label como "name")
        // Se preferires, troca para o 'name' do input; fica alinhado com o teu Blade atual.
        foreach ($data['inputs'] as $key => $value) {
            $forward[$key] = $value;
        }

        // Photos: transformar em "photos-<id>" = "file1,file2"
        if (!empty($data['photos'])) {
            foreach ($data['photos'] as $formInputId => $files) {
                $forward['photos-' . $formInputId] = implode(',', array_filter($files));
            }
        }

        // 2) Chamar o MESMO método do BO (já existente em /admin/form-assemblies/send-form-data)
        //    Ajusta a classe/método abaixo para o teu Controller real (ex.: Admin\FormAssemblyController@sendFormData)
        $fake = Request::create('/admin/form-assemblies/send-form-data', 'POST', $forward);
        $fake->setUserResolver(fn() => $request->user()); // preservar auth

        // Usa o Kernel HTTP para despachar internamente sem HTTP externo
        $response = app()->handle($fake);

        // Se o método do BO fizer redirect, devolvemos JSON OK
        if (in_array($response->getStatusCode(), [200, 201, 302])) {
            return response()->json(['ok' => true], 201);
        }

        // Caso devolva erro, propagamos
        return response()->json([
            'ok' => false,
            'status' => $response->getStatusCode(),
            'body' => $response->getContent(),
        ], 422);
    }
}
