<x-specialauth::layout>
{{-- Header --}}
<x-slot:header>
<x-specialauth::header :url="config('app.url')">
{{ config('app.name') }}
</x-specialauth::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-specialauth::subcopy>
{{ $subcopy }}
</x-specialauth::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-specialauth::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-specialauth::footer>
</x-slot:footer>
</x-specialauth::layout>
