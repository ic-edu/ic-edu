@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(isset($message))
<img src="{{ $message->embed(public_path('assets/icidu_logo.png')) }}" class="logo" alt="IC EDU Logo" style="width: auto; height: 50px;">
@else
<img src="{{ asset('assets/icidu_logo.png') }}" class="logo" alt="IC EDU Logo" style="width: auto; height: 50px;">
@endif
</a>
</td>
</tr>
