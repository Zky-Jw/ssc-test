<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionExport implements FromCollection, WithHeadings
{
    protected $unit;
    protected $sortType;
    protected $sortBy;

    public function __construct($unit, $sortBy, $sortType)
    {
        $this->unit = $unit;
        $this->sortBy = $sortBy;
        $this->sortType = $sortType;
    }

    public function collection()
    {
        $query = Question::when($this->unit, function ($query) {
            return $query->where('category.unit.name', $this->unit);
        });

        $query = $query->orderBy($this->sortBy, $this->sortType);

        return $query->get()->map(function ($question) {
            return [
                'Nomor Pertanyaan' => $question->questionNumber ?? '',
                'Judul'            => $question->title ?? '',
                'Isi Pertanyaan'   => strip_tags($question->question) ?? '',
                'Jawaban'          => strip_tags($question->question) ?? '',
                'Unit'             => $question->category['unit']['name'] ?? '',
                'Layanan'          => $question->category['service']['name'] ?? '',
                'Tanggal Dibuat'   => $question->created_at ? $question->created_at->format('Y-m-d H:i:s') : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Pertanyaan',
            'Judul',
            'Isi Pertanyaan',
            'Jawaban',
            'Unit',
            'Layanan',
            'Tanggal Dibuat',
        ];
    }
}
