<?php

namespace App\Services;

use App\Events\Organization\OrganizationCreated;
use App\Events\Organization\OrganizationDeleted;
use App\Events\Organization\OrganizationUpdated;
use App\Models\Organization;
use App\Models\Plan;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrganizationService.
 */
class OrganizationService extends BaseService
{
    /**
     * OrganizationService constructor.
     *
     * @param  Organization  $organization
     */
    public function __construct(Organization $organization)
    {
        $this->model = $organization;
    }

    /**
     * @param  array  $data
     *
     * @return Organization
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Organization
    {
        DB::beginTransaction();

        try {
            $organization = $this->model::create(
                [
                    'owner_id' => ($data['owner_id'] ?? auth()->id()),
                    'plan_id' => env('DEFAULT_PLAN'),
                    'next_plan_id' => env('DEFAULT_PLAN'),
                    'company_name' => ($data['company_name'] ?? null),
                    'tax_number' => ($data['tax_number'] ?? null),
                    'vat_number' => ($data['vat_number'] ?? null),
                    'address' => ($data['address'] ?? null),
                    'bank_name' => ($data['bank_name'] ?? null),
                    'bank_account' => ($data['bank_account'] ?? null),
                    'plan_expire' => ($data['plan_expire'] ?? null),
                    'start_period' => ($data['start_period'] ?? true),
                ]
            );
            $this->updateOrganizationPermissions($organization);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Organization.'));
        }

        event(new OrganizationCreated($organization));

        DB::commit();

        return $organization;
    }

    /**
     * @param  Organization  $organization
     * @param  array  $data
     *
     * @return Organization
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Organization $organization, array $data = []): Organization
    {
        DB::beginTransaction();

        try {
            $organization->update(
                [
                    'owner_id' => $data['owner_id'] ?? $organization->owner_id,
                    'plan_id' => $data['plan_id'] ?? $organization->plan_id,
                    'next_plan_id' => $data['next_plan_id'] ?? $organization->next_plan_id,
                    'company_name' => $data['company_name'] ?? $organization->company_name,
                    'tax_number' => $data['tax_number'] ?? $organization->tax_number,
                    'vat_number' => $data['vat_number'] ?? $organization->vat_number,
                    'address' => $data['address'] ?? $organization->address,
                    'bank_name' => $data['bank_name'] ?? $organization->bank_name,
                    'bank_account' => $data['bank_account'] ?? $organization->bank_account,
                    'subusers_quota' => $data['subusers_quota'] ?? $organization->subusers_quota,
                    'plan_expire' => array_key_exists('plan_expire', $data) ? $data['plan_expire'] : $organization->plan_expire,
                    'start_period' => array_key_exists('start_period', $data) ? $data['start_period'] : $organization->start_period,
                ]
            );
            $this->updateOrganizationPermissions($organization);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Organization.'));
        }

        event(new OrganizationUpdated($organization));

        DB::commit();

        return $organization;
    }

    /**
     * @param  Organization  $organization
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Organization $organization): bool
    {
        if ($this->deleteById($organization->id)) {
            event(new OrganizationDeleted($organization));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Organization.'));
    }

    /**
     * @param  Organization  $organization
     *
     * @return void
     * @throws GeneralException
     * @throws \Throwable
     */
    public function updateOrganizationPermissions(Organization $organization): void
    {
        $owner = $organization->owner()->first();
        $users = $organization->users()->where('users.id', '<>', $owner->id)->get();
        $plan_permissions = $organization->plan()->first()->permissions->modelKeys();
        $owner->syncPermissions($plan_permissions);
        foreach ($users as $user) {
            $user->syncPermissions(array_intersect($plan_permissions, $user->permissions->modelKeys()));
        }
    }

    /**
     * @param  Organization  $organization
     * @param  Plan  $plan
     *
     * @return void
     */
    public function switchPlan(Organization $organization, Plan $plan): void
    {
        $subscription = $organization->subscription('default');

        if (is_null($subscription)) {
            throw new GeneralException(__("The organization does not have a valid subscription."));
        }

        $organization_current_plan = $organization->plan()->first();
        $organization_next_plan = $organization->nextPlan()->first();

        try {
            $organization->subscription('default')->updatePaddleSubscription(
                [
                    'passthrough' => json_encode(['plan_id' => $plan->id]),
                    'prorate' => false,
                    'bill_immediately' => ($plan->price > $organization_current_plan->price ? true : false),
                    'quantity' => 1,
                    'currency' => $plan->currency,
                    'recurring_price' => $plan->price,
                ]
            );
        } catch (PaddleException $e) {
            throw new GeneralException($e->getMessage());
        }
    }
    
    /**
     * @param  Organization  $organization
     *
     * @return void
     */
    public function cancelSubscription(Organization $organization): void
    {
        $subscription = $organization->subscription('default');

        if (is_null($subscription)) {
            throw new GeneralException(__('You don\'t have a valid subscription.'));
        }

        if (!$organization->plan()->first()->isDefault()) {
            $this->update($organization, [
                'next_plan_id' => Plan::default()->get()->first()->id,
                'plan_expire' => $subscription->nextPayment()->date()->format('Y-m-d H:i:s'),
            ]);
        }
        
        $subscription->cancelNow();
    }
}