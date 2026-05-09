<?php

namespace App\Enums;

enum ExamAttemptStatus: string
{
    case ONGOING  = 'ongoing';
    case FINISHED = 'finished';
    case GRADED   = 'graded';

    /**
     * Label yang ditampilkan ke user.
     */
    public function label(): string
    {
        return match($this) {
            self::ONGOING  => 'Sedang Dikerjakan',
            self::FINISHED => 'Menunggu Penilaian',
            self::GRADED   => 'Sudah Dinilai',
        };
    }

    /**
     * Apakah attempt ini masih bisa dikerjakan peserta.
     */
    public function isActive(): bool
    {
        return $this === self::ONGOING;
    }

    /**
     * Apakah attempt ini sudah selesai (finished atau graded).
     */
    public function isDone(): bool
    {
        return in_array($this, [self::FINISHED, self::GRADED]);
    }
}
