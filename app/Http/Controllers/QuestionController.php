<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use App\Services\HtmlToPhpWordParser;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Services\CustomTemplateProcessor;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')  // Eager load user relationship
            ->orderBy('soal_adun')
            ->orderBy('soal_soalan_no')
            ->get();

        return view('questions.index', [
            'questions' => $questions
        ]);
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

    public function edit(Question $question)
    {
        $users = User::all();
        return view('questions.edit', [
            'users' => $users,
            'question' => $question,
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'soal_adun' => 'required|exists:users,id',
            'soal_soalan' => 'required',
            'soal_jawapan' => 'required',
        ]);

        try {
            // Update question
            $question->update([
                'soal_soalan' => $validated['soal_soalan'],
                'soal_jawapan' => $validated['soal_jawapan'],
                'soal_adun' => $validated['soal_adun'],
            ]);

            return to_route('questions.index')->with('success', 'Question updated successfully!');
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

    public function cetakalljawapan2()
    {
        $questions = Question::with('user')  // Eager load user relationship
            ->orderBy('soal_adun')
            ->orderBy('soal_soalan_no')
            ->get();

        $templatePath = storage_path("app/public/templates/Lisan/template_all.docx");
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templateProcessor = new TemplateProcessor($templatePath);
        // Use custom template processor instead of the default one
        // $templateProcessor = new \App\Services\CustomTemplateProcessor($templatePath);


        // dd($questions);

        // $test = '<w:p><w:r><w:t>test1</w:t></w:r></w:p><w:p><w:r><w:t>test2</w:t></w:r></w:p>';

        // $templateProcessor->setValue('question', $test);

        // Define your HTML content
        $htmlContent = "<p>test1</p><p>test2</p>";

        // Process the HTML and append it to a new section (or replace a placeholder)
        $doc = new \PhpOffice\PhpWord\PhpWord();
        $section = $doc->addSection();
        Html::addHtml($section, $htmlContent);

        // Replace the placeholder in the template with the rendered content
        $placeholder = 'question'; // Replace with your actual placeholder name
        // $templateProcessor->setValue($placeholder, $renderedContent);

        // Clone the main template for each ADUN
        $templateProcessor->cloneBlock('block_main', count($questions), true, true);

        // foreach ($questions as $index => $question) {
        //     $id = $index + 1;

        // }
        // dd($id);

        $pathToSave = storage_path('app/public/templates/Lisan/generated_file_' . rand(1, 300) . '.docx');

        $templateProcessor->saveAs($pathToSave);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=generated_file_' . rand(1, 300) . '.docx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        readfile($pathToSave);
    }

    public function downloadDocx(Question $question)
    {
        $data = [
            'question' => $question,
        ];

        $htmlContent = view('questions.single-export', $data)->render();

        // Prepare single question HTML content
        // $htmlContent = view('questions.single-export', compact('question'))->render();

        return response()->json([
            'html' => $htmlContent
        ]);
    }
}
