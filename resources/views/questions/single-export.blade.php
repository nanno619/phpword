@extends('layouts.app')
@section('content')
<div id="export-content">
    <div class="header">
        PERTANYAAN-PERTANYAAN BAGI<br/>
        PERSIDANGAN KETIGA (BELANJAWAN) PENGGAL KEDUA, DEWAN<br/>
        UNDANGAN NEGERI, NEGERI SEMBILAN YANG KE-15
        <p style="margin-bottom:0;"><br/></p>
    </div>
    <div class="header">
        PERTANYAAN-PERTANYAAN<br/>YANG BERKEHENDAKKAN JAWAPAN LISAN<br/>YANG DIKEMUKAKAN OLEH YB AHLI DEWAN UNDANGAN NEGERI,<br/>NEGERI SEMBILAN
        <p style="margin-bottom:0;"><br/></p>
    </div>
    <div class="header">
        PERTANYAAN LISAN (HARI KETIGA)<br/><span style="text-decoration: underline;"><strong>PADA 30 DISEMBER 2024</strong></span>
    </div>
    <p style="margin-bottom:0;font-size:12pt;"><br/></p>

    <div class="adun-section">ADUN GEMENCHECH</div>

    <p style="margin-bottom:0;font-size:12pt;"><br/></p>

    <table style="width: 100%; border-collapse: collapse; font-family: Tahoma, sans-serif; border: none;">
        <tr>
            <td style="font-weight: bold; width: 3cm; border: none;">TAJUK:</td>
            <td style="border: none;">PERUMAHAN RAKYAT</td>
        </tr>
    </table>

    <p style="margin-bottom:0;font-size:12pt;"><br/></p>

    <table style="width: 100%; border-collapse: collapse; font-family: Tahoma, sans-serif; border: none;">
        <tr>
            <td style="width: 1cm; border: none; vertical-align: top; padding: 0;">{{ $question->soal_soalan_no }}.</td>
            <td style="border: none;">{!! $question->soal_soalan !!}</td>
        </tr>
    </table>

    <p style="margin-bottom:0;font-size:12pt;"><br/></p>
    <p style="margin-bottom:0;font-size:12pt;"><br/></p>

    <div class="question-content">
        <strong>JAWAPAN</strong>
    </div>
    <p style="margin-bottom:0;font-size:12pt;"><br/></p>

    <div class="answer-content">
        {!! $question->soal_jawapan !!}
    </div>
</div>
@endsection
@push('styles')
<style>
    #export-content{
        font-family: Tahoma;
    }
    p{
        font-size: 12pt;
    }
    .header{
        text-align: center;
        line-height: 1.4;
        font-weight: bold;
    }
    .adun-section {
        text-decoration: underline;
        font-weight: bold;
    }

    .soalan-wrapper {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1em;
        }

        .soalan-wrapper span {
            min-width: 2em;
            margin-right: 1em;
        }

        .soalan-content {
            flex: 1;
            text-align: justify;
        }

</style>
@endpush
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush