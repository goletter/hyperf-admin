<?php
namespace Goletter\Admin\Request;

use Hyperf\Validation\Request\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'display_name' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '角色名称',
            'display_name' => '角色标识',
        ];
    }
}
