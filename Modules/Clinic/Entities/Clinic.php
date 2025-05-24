<?php

namespace Modules\Clinic\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;

class Clinic extends Model
{
    use Translatable;
    use SoftDeletes;
    use ScopesTrait;

    // protected $with              = ['translations'];
    protected $fillable          = [
        'status', 'image' , 'lat' , 'lang' , 'is_busy' , 'open_time' , 'close_time' , 'blogs_limit','supplier_value','supplier_code','sorting'
    ];
    public $translatedAttributes = ['description', 'title', 'slug', 'open_time_message'];
    public $translationModel     = ClinicTranslation::class;

    public function branches()
    {
        return $this->hasOne(ClinicBranche::class);
    }

    public function categories()
    {
        return $this->hasMany(\Modules\Category\Entities\Category::class);
    }

    public function offers()
    {
        return $this->hasMany(\Modules\Offer\Entities\Offer::class);
    }

    public function contacts()
    {
        return $this->morphMany(\Modules\Contact\Entities\Contact::class, 'contactable');
    }

    public function gallery()
    {
        return $this->morphMany(\Modules\Gallery\Entities\Gallery::class, 'galleryable');
    }

    public function socialMedia()
    {
        return $this->morphMany(\Modules\SocialMedia\Entities\SocialMedia::class, 'socialable');
    }

    public function shift()
    {
        return $this->morphOne(\Modules\Availability\Entities\Shift::class, 'shiftable');
    }

    public function offDays()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffDays::class, 'dayable_off');
    }

    public function offCustomDates()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffCustomDate::class, 'customable_off');
    }

    public function offDates()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffDates::class, 'dateable_off');
    }

    public function offTimes()
    {
        return $this->morphMany(\Modules\Availability\Entities\OffTimes::class, 'timeable_off');
    }

    public function clinicSocialMediaByName($name)
    {
        return $this->socialMedia()->where('name', $name)->first();
    }

    public function doctors()
    {
        return $this->belongsToMany('Modules\Doctor\Entities\Doctor', 'clinic_doctors', 'clinic_id', 'doctor_id');
    }

    public function rooms()
    {
        return $this->belongsToMany('Modules\Room\Entities\Room', 'clinic_rooms', 'clinic_id', 'room_id');
    }

    public function operators()
    {
        return $this->belongsToMany('Modules\Operator\Entities\Operator', 'clinic_operators', 'clinic_id', 'operator_id');
    }

    public function staff()
    {
        return $this->belongsToMany('Modules\Staff\Entities\Staff', 'clinic_staffs', 'clinic_id', 'staff_id');
    }

    public function blogs()
    {
        return $this->morphMany(\Modules\Blog\Entities\Blog::class, 'blogable');
    }

    public function services()
    {
        return $this->hasMany(\Modules\Service\Entities\Service::class);
    }

    public function rates()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderRate::class);
    }
}
