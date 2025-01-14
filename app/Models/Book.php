<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author',
        'book_title',
        'publication_year',
        'information',
        'cover_photo',
        'additional_information',
        'user_id',
    ];

    public function setAuthorAttribute($value)
    {
        $this->attributes['author'] = ucfirst(trim($value)); 
    }

    public function setBookTitleAttribute($value)
    {
        $this->attributes['book_title'] = ucwords(trim($value)); 
    }

    public function setPublicationYearAttribute($value)
    {
        $this->attributes['publication_year'] = (int) $value; 
    }

    public function setInformationAttribute($value)
    {
        $this->attributes['information'] = trim($value); 
    }

    public function setAdditionalInformationAttribute($value)
    {
        $this->attributes['additional_information'] = trim($value); 
    }

    public function setCoverPhotoAttribute($value)
    {
        if ($value) {
            $this->attributes['cover_photo'] = trim($value); 
        }
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}