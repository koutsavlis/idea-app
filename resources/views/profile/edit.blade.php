<x-layout>
    <x-form title="Edit your account" description="Need to make a tweak?">
        <form action="{{ route('profile.update')}}" method="POST" class="mt-10 space-y-4">
            @csrf
            @method('PATCH')

            <x-form.field label="Name" name="name" :value="$user->name" />
            <x-form.field label="Email" name="email" type="email" :value="$user->email" />
            <x-form.field label="New Password" name="password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full">Update Account</button>

        </form>
    </x-form>
</x-layout>