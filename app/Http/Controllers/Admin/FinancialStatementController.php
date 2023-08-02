<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialStatementController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('financial_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id = session()->get('company_id') ?? $company_id = session()->get('company_id');

        return view('admin.financialStatements.index', compact('company_id'));
    }

    public function pdf(Request $request)
    {
        abort_if(Gate::denies('financial_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pdf = Pdf::loadView('admin.financialStatements.pdf', [

        ])->setOption([
                    'isRemoteEnabled' => true,
                ]);

        if ($request->stream) {
            return $pdf->stream();
        } else {
            return $pdf->download('name_of_file' . '.pdf');
        }

    }

}