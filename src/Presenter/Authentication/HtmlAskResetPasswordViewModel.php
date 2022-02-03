<?php

declare(strict_types=1);

namespace App\Presenter\Authentication;

class HtmlAskResetPasswordViewModel
{
    public string $successMessage;
    public string $redirectPath;
    public string $error;

    public function __construct(string $successMessage, string $redirectPath, string $error)
    {
        $this->successMessage = $successMessage;
        $this->redirectPath = $redirectPath;
        $this->error = $error;
    }
}
