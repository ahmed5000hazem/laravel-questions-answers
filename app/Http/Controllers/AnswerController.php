<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Traits\AnswerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    use AnswerTrait;
    public function answerQuestion(Request $request, $id)
    {
        $q = Question::find($id);
        if (!$q) {
            return $this->getResponse("invalid question", $request->all(), true);
        }

        $validator = Validator::make($request->all(), [
            "answer" => "required"
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->getResponse($errors->all(), $request->all(), true);
        }

        $ans = new Answer;
        $ans->answer = $request->answer;
        $ans->user_id = $request->user()->id;
        $ans->question_id = $id;
        $ans->created_at = time();
        $ans->updated_at = time();
        $ans->save();

        $ans->question = $q->question;

        return $this->getResponse("you answerd this question", [
            "answer" => $ans
        ], false);
    }
    public function getAllAnswers(Request $request, $id)
    {

        if (filter_var($request->query("answer"), FILTER_VALIDATE_INT)){
            $ans = Answer::find($request->query("answer"));
            return $this->getResponse("", $ans, false);
        }

        $user = User::find($id);
        if(!$user){
            return $this->getResponse("invalid user", $request->all(), true);
        }

        $ans = Answer::where("answers.user_id", $user->id);

        if (filter_var($request->query("question"), FILTER_VALIDATE_INT)){
            $ans->where("question_id", $request->query("question"));
        }

        $ans->join("questions", "questions.id", "=", "answers.question_id");

        $ans->select("answers.*", "questions.question")->orderBy('id', 'asc');

        return $this->getResponse("", $ans->get(), false);
    }
    public function deleteAnswer(Request $request, $id)
    {
        $ans = Answer::find($id);
        if (!$ans) {
            return $this->getResponse("answer not found", $request->all(), true);
        }
        $ans->delete();
        return $this->getResponse("answer deleted", "", false);
    }
}
