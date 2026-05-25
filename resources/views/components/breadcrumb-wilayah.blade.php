@props([
'province' => null,
'regency' => null,
'district' => null,
])

<nav class="text-sm text-gray-500 mb-4">
  <ol class="flex flex-wrap items-center space-x-2">

    {{-- HOME / PROVINSI LIST --}}
    <li>
      <a href="{{ route('wilayah.index') }}" class="text-blue-600 hover:underline">
        Provinsi
      </a>
    </li>

    {{-- PROVINCE --}}
    @if($province)
    <li>/</li>
    <li>
      <a href="{{ route('wilayah.province', $province->code) }}" class="text-blue-600 hover:underline">
        {{ $province->name }}
      </a>
    </li>
    @endif

    {{-- REGENCY --}}
    @if($regency && $province)
    <li>/</li>
    <li>
      <a href="{{ route('wilayah.regency', [
      'province' => $province->code,
      'regency'  => $regency->code
  ]) }}"
        class="text-blue-600 hover:underline">
        {{ $regency->name }}
      </a>
    </li>
    @endif

    {{-- DISTRICT (CURRENT) --}}
    @if($district)
    <li>/</li>
    <li class="text-gray-700 font-semibold">
      {{ $district->name }}
    </li>
    @endif

  </ol>
</nav>