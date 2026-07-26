<?php

namespace App\Imports;

use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class BankSoalImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            $createdGroups = [];

            $maxGroupOrders = [];
            $maxQuestionOrders = [];

            foreach ($rows as $row) {
                if (empty($row['subsection_id'])) {
                    continue;
                }

                preg_match('/\[(\d+)\]/', $row['subsection_id'], $matches);
                $subId = $matches[1] ?? $row['subsection_id'];

                $groupCode = $row['group_code'];
                $qType = strtolower(trim($row['question_type']));

                if (!isset($createdGroups[$groupCode])) {

                    if (!isset($maxGroupOrders[$subId])) {
                        $maxGroupOrders[$subId] = QuestionGroup::where('subsection_id', $subId)->max('order_position') ?? 0;
                    }

                    $maxGroupOrders[$subId]++;

                    $group = QuestionGroup::create([
                        'subsection_id' => $subId,
                        'title'         => $row['group_title'] ?? null,
                        'instruction'   => $row['group_instruction'] ?? null,
                        'group_type'    => !empty($row['group_type']) ? strtolower(trim($row['group_type'])) : 'default',
                        'passage_text'  => $row['group_passage'] ?? null,
                        'audio_path'    => !empty($row['group_audio']) ? 'questions/audios/' . $row['group_audio'] : null,
                        'image_path'    => !empty($row['group_image']) ? 'questions/images/' . $row['group_image'] : null,
                        'order_position' => $maxGroupOrders[$subId],
                    ]);
                    $createdGroups[$groupCode] = $group->id;
                }

                $currentGroupId = $createdGroups[$groupCode];

                if (!isset($maxQuestionOrders[$currentGroupId])) {
                    $maxQuestionOrders[$currentGroupId] = Question::where('question_group_id', $currentGroupId)->max('order_position') ?? 0;
                }

                $maxQuestionOrders[$currentGroupId]++;

                $question = Question::create([
                    'question_group_id' => $currentGroupId,
                    'type'              => $qType,
                    'question_text'     => $row['question_text'] ?? '-',
                    'image_path'        => !empty($row['question_image']) ? 'questions/images/' . $row['question_image'] : null,
                    'audio_path'        => !empty($row['question_audio']) ? 'questions/audios/' . $row['question_audio'] : null,
                    'points'            => $row['points'] ?? 1,
                    'order_position'    => $maxQuestionOrders[$currentGroupId],
                ]);

                if ($qType === 'multiple_choice') {
                    $correctAnswer = strtoupper(trim($row['correct_answer']));

                    $options = [
                        ['text' => $row['opt_a'], 'is_correct' => $correctAnswer === 'A'],
                        ['text' => $row['opt_b'], 'is_correct' => $correctAnswer === 'B'],
                        ['text' => $row['opt_c'], 'is_correct' => $correctAnswer === 'C'],
                        ['text' => $row['opt_d'], 'is_correct' => $correctAnswer === 'D'],
                    ];

                    foreach ($options as $opt) {
                        if (!empty($opt['text'])) {
                            QuestionOption::create([
                                'question_id' => $question->id,
                                'option_text' => $opt['text'],
                                'is_correct'  => $opt['is_correct'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
