<?php

namespace App\Services;

use App\Events\Plan\PlanCreated;
use App\Events\Plan\PlanDeleted;
use App\Events\Plan\PlanUpdated;
use App\Models\Plan;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PlanService.
 */
class PlanService extends BaseService
{
    /**
     * PlanService constructor.
     *
     * @param  Plan  $plan
     */
    public function __construct(Plan $plan)
    {
        $this->model = $plan;
    }

    /**
     * @param  array  $data
     *
     * @return Plan
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Plan
    {
        DB::beginTransaction();

        try {
            $plan = $this->model::create(
                [
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'currency' => $data['currency'],
                    'billing_type' => $data['billing_type'],
                    'subusers_quota' => $data['subusers_quota'],
                ]
            );
            $plan->syncPermissions($data['permissions'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Plan.'));
        }

        event(new PlanCreated($plan));

        DB::commit();

        return $plan;
    }

    /**
     * @param  Plan  $plan
     * @param  array  $data
     *
     * @return Plan
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Plan $plan, array $data = []): Plan
    {
        DB::beginTransaction();

        try {
            $plan->update(
                [
                    'name' => $data['name'] ?? $plan->name,
                    'price' => $data['price'] ?? $plan->price,
                    'currency' => $data['currency'] ?? $plan->currency,
                    'billing_type' => $data['billing_type'] ?? $plan->billing_type,
                    'subusers_quota' => $data['subusers_quota'] ?? $plan->subusers_quota,
                ]
            );
            $plan->syncPermissions($data['permissions'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Plan.'));
        }

        event(new PlanUpdated($plan));

        DB::commit();

        return $plan;
    }

    /**
     * @param  Plan  $plan
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Plan $plan): bool
    {
        if ($this->deleteById($plan->id)) {
            event(new PlanDeleted($plan));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Plan.'));
    }
}