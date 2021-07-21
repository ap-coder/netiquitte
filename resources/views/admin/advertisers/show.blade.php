@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.advertiser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advertisers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.id') }}
                        </th>
                        <td>
                            {{ $advertiser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.name') }}
                        </th>
                        <td>
                            {{ $advertiser->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.account_status') }}
                        </th>
                        <td>
                            {{ App\Models\Advertiser::ACCOUNT_STATUS_SELECT[$advertiser->account_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.created_at') }}
                        </th>
                        <td>
                            {{ $advertiser->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.everflow_account') }}
                        </th>
                        <td>
                            {{ $advertiser->everflow_account }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.featured_image') }}
                        </th>
                        <td>
                            @if($advertiser->featured_image)
                                <a href="{{ $advertiser->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $advertiser->featured_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.account_manager_name') }}
                        </th>
                        <td>
                            {{ $advertiser->account_manager_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.account_executive_name') }}
                        </th>
                        <td>
                            {{ $advertiser->account_executive_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.balance') }}
                        </th>
                        <td>
                            {{ $advertiser->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.last_login') }}
                        </th>
                        <td>
                            {{ $advertiser->last_login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.network_country_code') }}
                        </th>
                        <td>
                            {{ $advertiser->network_country_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.global_tracking_domain_url') }}
                        </th>
                        <td>
                            {{ $advertiser->global_tracking_domain_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.published') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $advertiser->published ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.today_revenue') }}
                        </th>
                        <td>
                            {{ $advertiser->today_revenue }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.network_affiliateid') }}
                        </th>
                        <td>
                            {{ $advertiser->network_affiliateid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.account_executiveid') }}
                        </th>
                        <td>
                            {{ $advertiser->account_executiveid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.account_managerid') }}
                        </th>
                        <td>
                            {{ $advertiser->account_managerid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.networkid') }}
                        </th>
                        <td>
                            {{ $advertiser->networkid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.network_employeeid') }}
                        </th>
                        <td>
                            {{ $advertiser->network_employeeid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.internal_notes') }}
                        </th>
                        <td>
                            {{ $advertiser->internal_notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.is_contact_address_enabled') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $advertiser->is_contact_address_enabled ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.sales_managerid') }}
                        </th>
                        <td>
                            {{ $advertiser->sales_managerid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.is_expose_publisher_reporting_data') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $advertiser->is_expose_publisher_reporting_data ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.platform_name') }}
                        </th>
                        <td>
                            {{ $advertiser->platform_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.platform_url') }}
                        </th>
                        <td>
                            {{ $advertiser->platform_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.platform_username') }}
                        </th>
                        <td>
                            {{ $advertiser->platform_username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.accounting_contact_email') }}
                        </th>
                        <td>
                            {{ $advertiser->accounting_contact_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.offer_id_macro') }}
                        </th>
                        <td>
                            {{ $advertiser->offer_id_macro }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.affiliate_id_macro') }}
                        </th>
                        <td>
                            {{ $advertiser->affiliate_id_macro }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.attribution_method') }}
                        </th>
                        <td>
                            {{ $advertiser->attribution_method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.email_attribution_method') }}
                        </th>
                        <td>
                            {{ $advertiser->email_attribution_method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advertiser.fields.network_advertiserid') }}
                        </th>
                        <td>
                            {{ $advertiser->network_advertiserid }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advertisers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#adertisers_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="adertisers_users">
            @includeIf('admin.advertisers.relationships.adertisersUsers', ['users' => $advertiser->adertisersUsers])
        </div>
    </div>
</div>

@endsection