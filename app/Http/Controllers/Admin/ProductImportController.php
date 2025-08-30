<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessProductImport;
use App\Jobs\ImportProductsChunk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class ProductImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showImportForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls|max:563200'
        ]);

        try {
            $file = $request->file('csv_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('imports', $filename);

            // Dispatch import job
            ProcessProductImport::dispatch($path);

            return back()->with('success', 'Products import has been started. You will be notified when it completes.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error starting import: ' . $e->getMessage());
        }
    }
}
