@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bulk Import Products</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.import.process') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="csv_file" class="form-label">CSV File</label>
                            <input type="file" class="form-control @error('csv_file') is-invalid @enderror" id="csv_file" name="csv_file" accept=".csv,.xlsx,.xls" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Upload a CSV file with columns: name, description, price, image (optional), category, stock
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Import Products</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                    <hr>

                    <div class="mt-4">
                        <h5>Sample CSV Format</h5>
                        <p>Download this sample file to see the required format:</p>
                        <a href="{{ asset('sample/products_sample_import.csv') }}" class="btn btn-outline-primary" download>
                            Download Sample CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection