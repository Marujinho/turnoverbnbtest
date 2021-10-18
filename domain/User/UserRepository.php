<?php

namespace Domain\User;


class UserRepository
{
    protected $model;

    /**
     * AssessmentRepository constructor.
     * @param \Domain\User\User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function getUserBank($user)
    {
        $user_bank = $user->banks()->where('bank_user.user_id', $user->id)->where('bank_user.bank_id', $user->current_bank)->first();

        return $user_bank;
    }

    public function prepareUserData($user_bank)
    {
        $user_data = [
          'name' => $user_bank->name,
          'balance' => $user_bank->pivot->balance,
          'role' => $user_bank->pivot->role,
          'relationshipId' => $user_bank->pivot->id
        ];

        return $user_data;
    }

    public function getUser($user_id)
    {
        return $this->model->find($user_id);
    }

}
