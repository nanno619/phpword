<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')  // Eager load user relationship
            ->orderBy('soal_adun')
            ->orderBy('soal_soalan_no')
            ->get();

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $users = User::all();
        return view('questions.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'soal_adun' => 'required|exists:users,id',
            'soal_soalan' => 'required',
            'soal_jawapan' => 'required',
        ]);

        try {
            // Get the last question number for this user
            $lastQuestionNo = Question::where('soal_adun', $validated['soal_adun'])
                ->max('soal_soalan_no') ?? 0;

            // Create new question
            Question::create([
                'soal_persidangan' => 101,
                'soal_kategori' => 1,
                'soal_soalan_no' => $lastQuestionNo + 1,
                'soal_soalan' => $validated['soal_soalan'],
                'soal_jawapan' => $validated['soal_jawapan'],
                'soal_adun' => $validated['soal_adun'],
            ]);

            return to_route('questions.index')->with('success', 'Question created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating question: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Question $question)
    {
        try {
            $question->delete();
            return redirect()->back()->with('success', 'Question deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting question');
        }
    }

    public function cetakjawapan(Question $question)
    {
        $templatePath = storage_path("app/public/templates/Lisan/template.docx");
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templateProcessor = new TemplateProcessor($templatePath);

        $question->load('user');

        $templateProcessor->setValue('name', strtoupper($question->user->name));
        $templateProcessor->setValue('question_number', $question->soal_soalan_no);
        $templateProcessor->setValue('question', $question->soal_soalan);
        $templateProcessor->setValue('answer', $question->soal_jawapan);

        // Set filename
        $fileName = 'Cetakan_Jawapan.docx';

        // Use storage_path for temporary file storage
        $tempPath = storage_path('app/public/temp/' . $fileName);

        // Ensure the temporary directory exists
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $templateProcessor->saveAs($tempPath);

        // Send the file for download
        $response = response()->download($tempPath, $fileName);

        $response->deleteFileAfterSend(true);

        return $response;
    }
}
