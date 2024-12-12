@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('questions.index') }}" class="btn btn-warning">Back</a>
            <div class="card">

                <div class="card-header">Create New Question</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('questions.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="soal_adun" class="form-label">Select User</label>
                            <select name="soal_adun" id="soal_adun" class="form-control @error('soal_adun') is-invalid @enderror" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('soal_adun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="soal_soalan" class="form-label">Soalan</label>
                            <textarea name="soal_soalan" id="soal_soalan" class="form-control @error('soal_soalan') is-invalid @enderror"></textarea>
                            @error('soal_soalan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="soal_jawapan" class="form-label">Jawapan</label>
                            <textarea name="soal_jawapan" id="soal_jawapan" class="form-control @error('soal_jawapan') is-invalid @enderror"></textarea>
                            @error('soal_jawapan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Froala Editor for Soalan
        new FroalaEditor('#soal_soalan', {
            heightMin: 200,
        });

        // Initialize Froala Editor for Jawapan
        new FroalaEditor('#soal_jawapan', {
            heightMin: 200,
        });
    });
</script>
@endsection