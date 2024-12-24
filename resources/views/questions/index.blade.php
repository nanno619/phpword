@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Questions List</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('questions.create') }}" class="btn btn-primary">
                Add New Question
            </a>
        </div>
    </div>

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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User</th>
                            <th>Question</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td>{{ $question->soal_soalan_no }}</td>
                                <td>{{ $question->user->name }}</td>
                                <td>
                                    {!! Str::limit(strip_tags($question->soal_soalan), 100) !!}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('questions.edit', $question->soal_id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        {{-- <a href="{{ route('questions.cetakjawapan', $question->soal_id) }}"
                                           class="btn btn-sm btn-info">
                                            Download
                                        </a> --}}

                                        <a href="javascript:void(0)"
                                           onclick="downloadQuestion({{ $question->soal_id }})"
                                           class="btn btn-sm btn-info">
                                            Download
                                        </a>

                                        <form action="{{ route('questions.destroy', $question->soal_id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this question?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No questions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    function exportToWord(html, filename = 'document.doc') {
    const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
        "xmlns:w='urn:schemas-microsoft-com:office:word' " +
        "xmlns='http://www.w3.org/TR/REC-html40'>" +
        "<head><meta charset='utf-8'><title>Export HTML to Word</title></head><body>";
    const footer = "</body></html>";
    const sourceHTML = header + html + footer;

    const source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
    const fileDownload = document.createElement("a");
    document.body.appendChild(fileDownload);
    fileDownload.href = source;
    fileDownload.download = filename;
    fileDownload.click();
    document.body.removeChild(fileDownload);
    }

    // Function to handle single question export
    function downloadQuestion(questionId) {
        console.log(questionId);
        fetch(`/cetakjawapan/${questionId}`)
            .then(response => response.json())
            .then(data => {
                exportToWord(data.html, `question_${questionId}.doc`);
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@endpush