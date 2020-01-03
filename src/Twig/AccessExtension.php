<?php

namespace App\Twig;

use App\Entity\Courses;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AccessExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('checkCourseAccess', [$this, 'checkCourseAccess']),
        ];
    }

    public function checkCourseAccess(?User $user, ?Courses $course, bool $isPremium): bool
    {
        if (!empty($user) && !empty($course)) {
            if ($isPremium) {
                if ($user->getIsPremium() && !empty($user->getSubscriptionExpireDateTime())) {
                    return $user->getSubscriptionExpireDateTime() > new \DateTime();
                } elseif ($user->getIsPremium()) {
                    return true;
                }
            } else {
                return true;
            }
        }

        return false;
    }
}