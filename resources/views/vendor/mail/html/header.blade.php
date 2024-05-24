@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{asset('vendor/adminlte/dist/img/fire_hazard_logo.png')}}" class="logo"
                     alt="FireHazard Logo">
            @else
                <img src="{{asset('vendor/adminlte/dist/img/fire_hazard_logo.png')}}" class="logo"
                     alt="FireHazard Logo">
            @endif
        </a>
    </td>
</tr>
