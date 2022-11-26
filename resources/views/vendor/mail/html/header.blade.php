<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{-- {{ $slot }} --}}
<img src="{{ asset('FrontAssets/img/logo.png') }}" class="logo" alt="Laravel Logo" style="width: 100%;">
@endif
</a>
</td>
</tr>
