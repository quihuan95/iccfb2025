<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RegistrationHelper;
use Illuminate\Support\Facades\DB;

class Registration extends Model
{
    protected $fillable = [
        'title',
        'registration_code',
        'other_title',
        'fullname',
        'position',
        'organization',
        'country',
        'phone',
        'email',
        'dietary_requirement',
        'conference_type',
        'other_dietary_requirement',
        'display_country',
        'display_conference',
        'display_title',
        'display_dietary_requirement',
        'address',
        'total_fee',
        'paper_id',
        'paper_title',
        'payment_method',
        'payment_status',
        'register_type', // ✅ Thêm dòng này
    ];

    public static function getNextRegistrationCode($type = 'international')
    {
        $prefix = $type === 'vietnamese' ? 'ICCFB2025-VN' : 'ICCFB2025';

        return DB::transaction(function () use ($prefix) {
            // Khóa bản ghi cuối cùng để tránh race condition
            $latest = DB::table('registrations')
                ->where('registration_code', 'like', $prefix . '%')
                ->orderByDesc('created_at')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;

            if ($latest && preg_match('/(\d+)$/', $latest->registration_code, $matches)) {
                $nextNumber = (int)$matches[1] + 1;
            }

            return sprintf('%s-%04d', $prefix, $nextNumber);
        });
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_code)) {
                // Giả sử $registration->register_type có giá trị 'VN' hoặc 'INT'
                $registration->registration_code = self::getNextRegistrationCode($registration->register_type === 'vietnamese' ? 'vietnamese' : 'international');
            }

            // Xử lý display_country
            if (!empty($registration->country)) {
                $registration->display_country = RegistrationHelper::getCountryName($registration->country);
            }

            // Xử lý display_conference
            if (!empty($registration->conference_type)) {
                $registration->display_conference = json_encode(
                    RegistrationHelper::getConferenceDetail($registration->register_type, $registration->conference_type)
                );
            }

            // Xử lý display_title
            if (!empty($registration->title)) {
                if ($registration->title == 'Other') {
                    $registration->display_title = $registration->other_title;
                } else {
                    $registration->display_title = $registration->title;
                }
            }

            // Xử lý display_dietary_requirement
            if (!empty($registration->dietary_requirement)) {
                $registration->display_dietary_requirement = $registration->dietary_requirement === 'Other'
                    ? $registration->other_dietary_requirement
                    : $registration->dietary_requirement;
            }
        });
    }
}
