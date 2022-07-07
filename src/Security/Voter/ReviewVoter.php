<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Component\Security;

class ReviewVoter extends Voter
{
    public const EDIT = 'REVIEW_EDIT';
    public const DELETE = 'REVIEW_VIEW';
    private $security;

    public function  __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Review;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // check if user is admin
        if($this->security->isGranted('ROLE_ADMIN')) return true;

        //check if review has an owner
        if(false === $review->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                return $this->canEdit($review, $user);
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                return $this->canDelete($review, $user);
                break;
        }

        return false;
    }

    protected function canEdit(Review $review, User $user): bool
    {
        return $user === $review->getUser();
    }

    protected function canDelete(Review $review, User $user): bool
    {
        return $user === $review->getUser();
    }
}
