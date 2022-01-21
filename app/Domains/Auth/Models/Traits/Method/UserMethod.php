<?php

namespace App\Domains\Auth\Models\Traits\Method;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonInterval;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        return $this->id === 1;
    }

    /**
     * @return mixed
     */
    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    /**
     * @return mixed
     */
    public function isUser(): bool
    {
        return $this->type === self::TYPE_USER;
    }

    /**
     * @return mixed
     */
    public function hasAllAccess(): bool
    {
        return $this->isAdmin() && $this->hasRole(config('boilerplate.access.role.admin'));
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isType($type): bool
    {
        return $this->type === $type;
    }

    /**
     * @return mixed
     */
    public function canChangeEmail(): bool
    {
        return config('boilerplate.access.user.change_email');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function isSocial(): bool
    {
        return $this->provider && $this->provider_id;
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }

    /**
     * @param  bool  $size
     *
     * @return mixed|string
     * @throws \Creativeorange\Gravatar\Exceptions\InvalidEmailException
     */
    public function getAvatar($size = null)
    {
        return 'https://gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s='.config('boilerplate.avatar.size', $size).'&d=mp';
    }

    /**
     * @return bool
     */
    public function isOrganizationOwner(): bool
    {
        $organization = $this->organization()->first();
        return is_null($organization) ? false : $this->id == $organization->owner_id;
    }

    /**
     * @return array
     */
    public function getTimesChartData(): array
    {
        $times = $this->times()->where('start_time', '>=', now()->subYear()->toDateTimeString())->orderBy('start_time')->get();
        $daily = [];
        $monthly = [];
        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
        ]);
        foreach ($times as $time) {
            $start_time_carbon = Carbon::createFromFormat('Y-m-d H:i:s', $time->start_time);
            $end_time_carbon = Carbon::createFromFormat('Y-m-d H:i:s', $time->end_time);
            if (isset($daily[$start_time_carbon->format('M j')])) {
                $daily[$start_time_carbon->format('M j')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            } else {
                $daily[$start_time_carbon->format('M j')] = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                $daily[$start_time_carbon->format('M j')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            }
            if (isset($monthly[$start_time_carbon->format('M Y')])) {
                $monthly[$start_time_carbon->format('M Y')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            } else {
                $monthly[$start_time_carbon->format('M Y')] = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                $monthly[$start_time_carbon->format('M Y')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            }
        }

        foreach ($daily as $key => $value) {
            $value = $value->cascade();
            $daily[$key] = number_format($value->hours + ($value->minutes / 100), 2);
        }

        foreach ($monthly as $key => $value) {
            $value = $value->cascade();
            $monthly[$key] = number_format($value->hours + ($value->minutes / 100), 2);
        }

        $daily = array_slice($daily, -30, 30);
        $monthly = array_slice($monthly, -12, 12);

        return [
            'daily' => $daily,
            'monthly' => $monthly,
        ];
    }
}
