@if (session('success'))
<div class="bg-green-200 border-green-600 p-3 my-2 rounded-sm shadow-sm">
    {{session('success')}}
</div>
@endif
@if (session('danger'))
<div class="bg-red-200 border-red-600 p-3 my-2 rounded-sm shadow-sm">
    {{session('danger')}}
</div>
@endif