<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use App\Notifications\NewReceipt;
use Gate;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MyReceiptsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('my_receipt_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->hasRole('Empresas Associadas')) {
            $receipts = Receipt::whereHas('driver', function ($driver) {
                $driver->where('company_id', session()->get('company_id'));
            })
                ->get()->load('driver');
        } else {
            $driver = Driver::where('user_id', auth()->user()->id)->first();

            $receipts = Receipt::where([
                'driver_id' => $driver->id
            ])
                ->get()->load('driver');
        }

        return view('admin.myReceipts.index')->with([
            'receipts' => $receipts,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'file' => 'required',
        ]);

        $driver = Driver::where('user_id', auth()->user()->id)->first();

        $receipt = new Receipt;
        $receipt->driver_id = $driver->id;
        $receipt->value = $request->value;
        $receipt->save();

        if ($request->input('file', false)) {
            $receipt->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $receipt->id]);
        }

        //SEND EMAIL TO ADMIN
        User::find(2)->notify(new NewReceipt($driver));

        return redirect()->back()->with('message', 'Enviado com sucesso');
    }

    public function payReceipt($receipt_id, $paid)
    {
        $receipt = Receipt::find($receipt_id);
        $receipt->paid = $paid;
        $receipt->save();
    }

}