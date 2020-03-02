<?php


namespace Source\Models;


class Session
{


    public function setSession(array $data): void
    {
        $_SESSION['analyze'] = $data;
    }

    public function delete(int $indiceMajor, $indiceMinor): bool
    {
        if (isset($_SESSION['analyze'][$indiceMajor][$indiceMinor])) {
            unset($_SESSION['analyze'][$indiceMajor][$indiceMinor]);
            return true;
        }
        return false;
    }
}