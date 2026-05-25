<div class="border rounded-lg p-4 bg-white shadow">

  <h2 class="text-xl font-bold text-green-700 mb-3">
    {{ $province->name }} ({{ $province->code }})
  </h2>

  @if(!empty($province->regencies) && count($province->regencies))
  @foreach($province->regencies as $regency)
  @include('administrator.wilayah.partials.regency', [
  'regency' => $regency
  ])
  @endforeach
  @else
  <a href="{{ url('/wilayah/'.$province->code) }}"
    class="text-blue-600 underline">
    Lihat Kabupaten
  </a>
  @endif

</div>