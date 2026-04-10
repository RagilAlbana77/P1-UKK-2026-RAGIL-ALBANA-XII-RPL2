@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 text-sm border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 p-3 rounded-lg bg-yellow-100 text-yellow-900 text-sm border border-yellow-200">
        {{ session('warning') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 text-sm border border-red-200">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 text-sm border border-red-200">
        <div class="font-semibold mb-1">Ada kesalahan pada input:</div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
