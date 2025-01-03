<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles  ') }}
            </h2>
            <a href="{{route('role.create')}}" class="bg-blue-700 hover:bg-blue-600 text-sm rounded-lg px-5 py-2 text-white">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <x-message ></x-message>
                   <table class="w-full mt-3">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 text-left py-3" width="60px">#</th>
                            <th class="px-6 text-left py-3" width="150px">Name</th>
                            <th class="px-6 text-left py-3">Permissions</th>
                            <th class="px-6 text-left py-3" width="150px">Created_at</th>
                            <th class="px-6 text-left py-3" width="250px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($roles)
                        @foreach ($roles as $role)
                            
                        <tr>
                            <td  class="px-6 text-left py-3">{{$role->id}}</td>
                            <td  class="px-6 text-left py-3">{{$role->name}}</td>
                            <td  class="px-6 text-left py-3">{{$role->permissions->pluck('name')->implode(', ')}}</td>
                            <td  class="px-6 text-left py-3">{{$role->created_at->format('d M, Y')}}</td>
                            <td class="px-4 text-left py-3 flex">
                                <a href="{{route('role.edit',$role->id)}}" class="bg-blue-700 hover:bg-blue-600 text-sm rounded-lg px-5 py-2 text-white">Edit</a>
                                <form action="{{route('role.destroy',$role->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 ms-2 hover:bg-red-500 text-sm rounded-lg px-5 py-2 text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                            
                        @endif
                    </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
