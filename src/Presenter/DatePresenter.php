<?php


namespace App\Presenter;


class DatePresenter
{
    public function present(?\DateTime $dateTime): string
    {
        return $dateTime->format('Y/m/d');
    }
}
