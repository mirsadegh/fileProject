<?php

use Morilog\Jalali\Jalalian;

if(!function_exists('newFeedback')){
    function newFeedback($title ='عملیات موفقیت آمیز',$body ='عملیات با موفقیت انجام شد.',$type ='success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title,'body' => $body, "type" => $type];
    session()->flash('feedbacks',$session);
}

}

if(!function_exists('dateFromJalali')){

    function dateFromJalali($date, $format = "Y/m/d")
    {
        return $date ? Jalalian::fromFormat($format, $date)->toCarbon() : null;
    }


}

if(!function_exists('getJalaliFromFormat')){

   function getJalaliFromFormat($date, $format = "Y-m-d" ){
    return Jalalian::fromCarbon(\Carbon\Carbon::createFromFormat($format, $date))->format($format);
  }
}


if(!function_exists('createFromCarbon')){

    function createFromCarbon(\Carbon\Carbon $carbon)
{
    return Jalalian::fromCarbon($carbon);
}
}


