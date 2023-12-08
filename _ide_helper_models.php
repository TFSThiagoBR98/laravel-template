<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AcquirerTransaction
 *
 * @property string $id
 * @property string|null $description
 * @property string|null $operation
 * @property string $method
 * @property \Illuminate\Support\Collection $request
 * @property \Illuminate\Support\Collection $response
 * @property string $http_code
 * @property string|null $acquirer
 * @property string|null $payable_type
 * @property string|null $payable_id
 * @property string|null $payer_type
 * @property string|null $payer_id
 * @property \App\Enums\GenericStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payable
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereAcquirer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereHttpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperAcquirerTransaction {}
}

namespace App\Models{
/**
 * App\Models\Audit
 *
 * @property string $id
 * @property string|null $user_type
 * @property string|null $user_id
 * @property string $event
 * @property string $auditable_type
 * @property string $auditable_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string|null $url
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $auditable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|Audit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereAuditableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereAuditableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Audit whereUserType($value)
 * @mixin \Eloquent
 */
	class IdeHelperAudit {}
}

namespace App\Models{
/**
 * App\Models\CashFlow
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon $work_date
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $start_amount
 * @property \App\Enums\CashFlowStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $employee_open_id
 * @property string|null $employee_close_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User|null $closedBy
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $openedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CashFlowTransaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereEmployeeCloseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereEmployeeOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereStartAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow whereWorkDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlow withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCashFlow {}
}

namespace App\Models{
/**
 * App\Models\CashFlowTransaction
 *
 * @property string $id
 * @property string $name
 * @property \App\Enums\CashFlowTransactionType $operation_type
 * @property int $amount
 * @property \App\Enums\GenericStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $creator_id
 * @property string $cash_flow_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\CashFlow $cashFlow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCashFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereOperationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCashFlowTransaction {}
}

namespace App\Models{
/**
 * Model Company
 *
 * @property string $id
 * @property string $name
 * @property string $tax_id
 * @property bool $visible_to_client
 * @property \App\Enums\GenericStatus $status
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereVisibleToClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCompany {}
}

namespace App\Models{
/**
 * Model Employee
 *
 * @property string $id
 * @property string|null $role
 * @property \App\Enums\GenericStatus $status
 * @property string|null $user_id
 * @property string $company_id
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperEmployee {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property string $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereGeneratedConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperMedia {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property string $id
 * @property string $description
 * @property string $method
 * @property \Illuminate\Support\Collection|null $payment_data
 * @property \Illuminate\Support\Collection|null $confirmation_data
 * @property \Illuminate\Support\Collection|null $chargeback_data
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string $acquirer
 * @property string|null $payable_type
 * @property string|null $payable_id
 * @property string|null $payer_type
 * @property string|null $payer_id
 * @property \App\Enums\PaymentStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $creator_id
 * @property string|null $cash_flow_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\CashFlow|null $cashFlow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payer
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAcquirer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCashFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereChargebackData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereConfirmationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperPayment {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property string $id
 * @property string $name
 * @property \App\Enums\GenericStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperPaymentMethod {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property string $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	class IdeHelperPermission {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property string $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 * @mixin \Eloquent
 */
	class IdeHelperRole {}
}

namespace App\Models{
/**
 * User model
 *
 * @property string $id
 * @property string $name
 * @property string $tax_id
 * @property string|null $phone
 * @property string $email
 * @property string|null $activated_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $avatar
 * @property string|null $theme
 * @property string|null $theme_color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read string $balance
 * @property-read int $balance_int
 * @property-read \Bavix\Wallet\Models\Wallet $wallet
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \TFSThiagoBR98\LighthouseGraphQLPassport\Models\SocialProvider> $socialProviders
 * @property-read int|null $social_providers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @property-read \Laragear\TwoFactor\Models\TwoFactorAuthentication $twoFactorAuth
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $walletTransactions
 * @property-read int|null $wallet_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Wallet> $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

