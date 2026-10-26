<x-layout>
    <x-form title="Register an account" description="Start tracking your ideas today.">
        <form action="/register" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Name" name="name" />
            <x-form.field label="Email" name="email" type="email" />
            <x-form.field label="Password" name="password" type="password" />

            {{-- <div class="space-y-2">
                <label for="name" class="label">Name</label>
                <input type="text" class="input" id="name" name="name">
            </div>

            <div class="space-y-2">
                <label for="email" class="label">Email</label>
                <input type="email" class="input" id="email" name="email">
            </div>

            <div class="space-y-2">
                <label for="password" class="label">Password</label>
                <input type="password" class="input" id="password" name="password">
            </div> --}}

            <button type="submit" class="btn mt-2 h-10 w-full">Create Account</button>

        </form>
    </x-form>
</x-layout>