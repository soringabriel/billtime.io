<?php

namespace App\Http\Requests\Frontend\Time;

use App\Models\Time;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

/**
 * Class UpdateTimeRequest.
 */
class UpdateTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project_client_id_rules = [Rule::exists('clients', 'id')->where(function ($query) {
            return $query->where('organization_id', auth()->user()->organization()->first()->id);
        })];
        if (FormRequest::input('new_project') == 1 && FormRequest::input('new_client') == 0) {
            $project_client_id_rules[] = 'required';
        }
        return [
            'start_time' => [
                'required', 
                'date_format:Y-m-d H:i', 
                'before_or_equal:' . Carbon::now()->timezone(auth()->user()->timezone), 
                'before_or_equal:' . FormRequest::input('end_time'), 
                (!empty(FormRequest::input('end_time')) ? 'after:' . Carbon::createFromFormat('Y-m-d H:i', FormRequest::input('end_time'))->subDay() : '')
            ],
            'end_time' => ['required', 'date_format:Y-m-d H:i', 'before_or_equal:' . Carbon::now()->timezone(auth()->user()->timezone)],
            'project_id' => ['required_if:new_project,0', Rule::exists('projects', 'id')->where('organization_id', auth()->user()->organization()->first()->id)],
            'task' => ['max:255'],
            'details' => ['max:255'],
            'new_project' => ['sometimes', 'boolean'],
            'project_name' => ['required_if:new_project,1', 'max:255'],
            'project_client_id' => $project_client_id_rules,
            'new_client' => ['sometimes', 'boolean'],
            'client_name' => ['required_if:new_client,1', 'max:255'],
            'client_company_name' => ['max:255'],
            'client_tax_number' => ['max:255'],
            'client_vat_number' => ['max:255'],
            'client_address' => ['max:255'],
            'client_bank_account' => ['max:255'],
        ];
    }
}
