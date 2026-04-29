<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfAnnotation extends Model
{
   protected $fillable = [
     'dokumen_review_id','user_id','page','type','rect','data'
   ];
   protected $casts = ['rect'=>'array','data'=>'array'];

   // app/Models/PdfAnnotation.php
   public function user(){ return $this->belongsTo(\App\Models\User::class, 'user_id'); }
    public function dokumenReview()
   {
       return $this->belongsTo(DokumenReview::class, 'dokumen_review_id');
   }
   
    public function images()
   {
       return $this->hasMany(AnnotationImage::class, 'annotation_id');
   }

}

