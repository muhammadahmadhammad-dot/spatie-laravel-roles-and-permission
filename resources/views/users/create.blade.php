<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User / Create') }}
            </h2>
            <a href="{{route('user.index')}}" class="bg-red-600 hover:bg-red-500 text-sm rounded-lg px-5 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('user.store')}}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="" class="font-medium text-lg mb-3">Name</label>
                            <div>
                                <input name="name" type="text" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                            </div>
                            @error('name')
                                <p class="text-red-600">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="font-medium text-lg mb-3">Email</label>
                            <div>
                                <input name="email" type="email" placeholder="Enter email" class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                            </div>
                            @error('email')
                                <p class="text-red-600">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="font-medium text-lg mb-3">Password</label>
                            <div>
                                <input name="password" type="password" placeholder="Enter password" class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                            </div>
                            @error('password')
                                <p class="text-red-600">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="font-medium text-lg mb-3">Confirm Password</label>
                            <div>
                                <input name="confirm_password" type="password" placeholder="Enter Confirm password" class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                            </div>
                            @error('confirm_password')
                                <p class="text-red-600">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="my-3">

                            
                            <label for="" class="font-medium text-lg my-3">Assign Pemissions</label>
                            <div class="grid grid-cols-4">
                                @if ($roles)
                                    @foreach ($roles as $role)
                                    <div>

                                        <input type="checkbox" class="font-medium text-sm " value="{{$role->name}}" name="roles[]" id="{{$role->id}}">
                                        <label for="{{$role->id}}" >{{$role->name}}</label>
                                    </div>
                                    @endforeach
                                @endif

                            </div>
                            @error('roles')
                                <p class="text-red-600">{{$message}}</p>
                            @enderror
                        </div>
                        
                        <button class="bg-slate-700 hover:bg-slate-600 text-sm rounded-lg px-5 py-2 text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
