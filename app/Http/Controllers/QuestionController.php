<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Traits\QuestionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use QuestionTrait;
    public function askQuestion(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "question" => "required|string"
        ]);
        if ($validator->fails()) {
            $errors= $validator->errors();
            $errors = $errors->all();
            return $this->getResponse($errors, $request->all(), true);
        }
        $q = new Question;
        $q->question = $request->question;
        $q->user_id = $request->user()->id;
        $q->created_at = time();
        $q->updated_at = time();
        $q->save();
        return $this->getResponse("question sent...", $q, false);
    }
    public function getAllQuestions(Request $request)
    {
        $id = $request->query("user_id") ? $request->query("user_id") : $request->user()->id;

        if (!$id) {
            return $this->getResponse("user not found", $request->all(), true);
        }
        $user = User::find($id);

        if (!$user) {
            return $this->getResponse("user not found", $request->all(), true);
        }

        if ($request->query("question") === "all" || !$request->query("question")) {
            $questions = $user->questions()->orderBy("id", "desc")->cursorPaginate(15);
            return $this->getResponse("", [
                "user" => $request->user(),
                "questions" => $questions
            ], false);
        } else if (filter_var($request->query("question"), FILTER_VALIDATE_INT)) {
            $questions = $user->questions()->where("id", $request->query("question"))->get();
            return $this->getResponse("", [
                "user" => $request->user(),
                "questions" => $questions
            ], false);
        } else {
            return $this->getResponse("invalid question", $request->all(), true);
        }
    }
    public function deleteQuestion(Request $request, $id)
    {
        $q = Question::where([
            ["user_id", $request->user()->id],
            ["id", $id]
            ])->first();
            
        if (!$q) {
            return $this->getResponse("invalid question", $request->all(), true);
        }

        $q->delete();
        return $this->getResponse("question deleted...", $request->all(), false);
    }
    public function getFullQuestion(Request $request, $question)
    {
        $q = Question::where("id", $question)->first();
        if (!$q) {
            return $this->getResponse("Question not found", $request->all(), true);
        }

        $answers = $q->answers()->orderBy('id', 'desc')->get();

        return $this->getResponse("", [
            "user" => $request->user(),
            "question" => $q,
            "answers" => $answers,
        ], false);
    }
}
