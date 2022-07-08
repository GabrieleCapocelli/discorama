<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;


class ReviewVoter extends Voter
{
    public const REVIEW_EDIT = 'REVIEW_EDIT';
    public const REVIEW_DELETE = 'REVIEW_DELETE';
    public const USER_EDIT = 'USER_EDIT';
    public const USER_DELETE = 'USER_DELETE';
    private Security $security;

    public function  __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::REVIEW_EDIT, self::REVIEW_DELETE, self::USER_EDIT, self::USER_DELETE])
            && $subject instanceof \App\Entity\Review;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the User is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // check if User is admin
        if($this->security->isGranted('ROLE_ADMIN')) return true;

        //check if review has an owner
        if(false === $subject->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::REVIEW_EDIT:
                return $this->canEditReview($subject, $user);
                break;
            case self::REVIEW_DELETE:
                return $this->canDeleteReview($subject, $user);
                break;
            case self::USER_EDIT:
                return $this->canEditUser($subject, $user);
                break;
            case self::USER_DELETE:
                return $this->canDeleteUser($subject, $user);
                break;
        }

        return false;
    }

    protected function canDeleteReview(Review $review, User $user, ): bool
    {
        return $user === $review->getUser();
    }

    protected function canEditReview(Review $review, User $user): bool
    {
        return $user === $review->getUser();
    }

    protected function canDeleteUser($account, User $user, ): bool
    {
        return $user === $account->getUser();
    }

    protected function canEditUser($account, User $user): bool
    {
        return $user === $account->getUser();
    }
}
