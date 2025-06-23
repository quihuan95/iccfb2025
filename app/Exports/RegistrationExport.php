<?php

namespace App\Exports;

use App\Models\Registration;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class RegistrationExport implements FromCollection, WithStyles, WithHeadings
{
    use Exportable;

    protected $query;

    protected $registerType;

    public function __construct($query, $registerType = null)
    {
        $this->query = $query;
        $this->registerType = $registerType;
    }

    public function query()
    {
        return $this->query;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $records = $this->query->get();
        return $records->map(function ($record) {
            $row = [
                Carbon::parse($record->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                $record->registration_code,
                $record->display_title,
                $record->fullname,
                $record->position,
                $record->organization,
                $record->address,
                $record->display_country,
                $record->phone,
                $record->email,
                $record->display_dietary_requirement,
                $this->formatConferenceType($record->display_conference),
                $record->paper_id,
                $record->paper_title,
                $record->total_fee,
                $record->payment_method,
                $record->payment_status
            ];

            return $row;
        });
    }

    public function headings(): array
    {
        if ($this->registerType === 'international') {
            return [
                'Registered Date',
                'Registration ID',
                'Title',
                'Full Name',
                'Position',
                'Organization',
                'Billing Address',
                'Country',
                'Phone',
                'Email',
                'Dietary',
                'Conference Type',
                'Paper ID',
                'Paper title',
                'Total Fee (USD)',
                'Payment Method',
                'Payment Status'
            ];
        } else {
            return [
                'Registered Date',
                'Registration ID',
                'Title',
                'Full Name',
                'Position',
                'Organization',
                'Billing Address',
                'Country',
                'Phone',
                'Email',
                'Dietary',
                'Conference Type',
                'Paper ID',
                'Paper title',
                'Total Fee (VND)',
                'Payment Method',
                'Payment Status'
            ];
        }
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . $lastRow;

        // Border cho toàn bộ bảng
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Font đậm cho dòng tiêu đề
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => ['bold' => true],
        ]);
        return [];
    }

    private function formatConferenceType($conference_type)
    {
        $display_conference_type = json_decode($conference_type);
        return $display_conference_type->label;
    }
}
