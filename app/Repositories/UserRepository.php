<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function setTask(string $name, string $mail): int
    {
        DB::table('users')->updateOrInsert(
            ['name' => $name],
            ['email' => $mail]
        );
        return DB::table('users')
        ->where('name', $name)
        ->select(['id'])
        ->first()
        ->id;
    }

    public function getTask(int $id): string
    {
        return DB::table('users')
        ->where('id', $id)
        ->select(['name'])
        ->first()->name;
    }

    public function setUserStats(string $name, int $publicRepo, int $commitSum, int $issues, int $pullRequests, int $starSum, int $followers): void
    {
        DB::table('users')->where('name', $name)
        ->update([
            'public_repo'=>$publicRepo,
            'commit_sum'=>$commitSum,
            'issues'=>$issues,
            'pull_requests'=>$pullRequests,
            'star_sum'=>$starSum,
            'followers'=>$followers
            ]);
    }

    public function getUserStats(string $name):object
    {
        $result = DB::table('users')
        ->where('name', $name)
        ->select(['public_repo','commit_sum','issues','pull_requests','star_sum','followers'])
        ->first();
        return $result;
    }

    public function setUserRank(string $name, string $rank): void
    {
        DB::table('users')->where('name', $name)
        ->update([
            'user_rank'=>$rank
            ]);
    }

    public function getResultId(string $name):int
    {
        return intval(DB::table('users')
        ->where('name', $name)
        ->select(['id'])
        ->first()->id);
    }

    public function getResult(int $id): object
    {
        return DB::table('users')
        ->where('id', $id)
        ->select(['name','email','public_repo','commit_sum','issues','pull_requests','star_sum','followers','user_rank'])
        ->first();
    }
}
