@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'Laravel')
        <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
    @else
        @if(isset($message))
            <img src="{{ $message->embed(public_path(config('tenant.active.logo_light'))) }}" class="logo" alt="{{ config('tenant.active.app_name') }} Logo" style="width: auto; height: 50px;">
        @else
            <img src="{{ asset(config('tenant.active.logo_light')) }}" class="logo" alt="{{ config('tenant.active.app_name') }} Logo" style="width: auto; height: 50px;">
        @endif
    @endif
</a>
</td>
</tr>
